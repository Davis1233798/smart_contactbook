<?php

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use App\Models\Student;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Illuminate\Http\Request;
use App\Models\SchoolNotificationContent; // Add this line
use App\Models\StudentNotification; // Add this line
use App\Models\ClassNotification;

use Illuminate\Support\Facades\Log;

class ContactBookEditScreen extends Screen
{
    private $contactBook;
    private $isEdit;
    public function query($contactBookId = null): array
    {
        Log::info('into query');
        Log::info($contactBookId);
        // Log::info($request);
        // // 檢查是否有傳入 ID
        // $contactBookId = $request->input('id', null);

        if ($contactBookId) {
            // 編輯現有聯絡簿
            $contactBook = ContactBook::findOrFail($contactBookId);
            $this->isEdit = true;  // 設定一個狀態標記
        } else {
            // 新增聯絡簿
            $contactBook = new ContactBook();
            $this->isEdit = false;
        }
        // $contactBook = ContactBook::whereDate('created_at', now()->toDateString())->first();
        $contactBook->load(
            'classNotifications',
            'studentNotifications',
            'schoolNotificationContents'
        );
        $this->contactBook = $contactBook;

        $students = Student::all();
        $students->load('studentParentSignContactBooks');
        Log::info('$contactBook');
        Log::info($contactBook);

        // 轉換 studentNotifications 中的 student_id 為 student
        $studentNotificationsTransformed = $contactBook->studentNotifications->map(function ($notification) use ($students) {
            return [
                'id' => $notification->id,
                'student' => $notification->student_id,
                'content' => $notification->content,
            ];
        });

        return [
            'contactBook' => $contactBook,
            'student_notifications' => $contactBook->studentNotifications,
            'class_notifications' => $contactBook->classnotifications ? $contactBook->classnotifications : null,
            'school_notification_contents' => $contactBook->schoolNotificationContents ? $contactBook->schoolNotificationContents : null,
            'students' => $students,
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('儲存')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): array
    {
        $students = Student::all()->pluck('name', 'id');

        return [
            Layout::rows([
                Group::make([
                    Matrix::make('schoolNotificationContents')
                        ->title('學校通知事項')
                        ->columns([
                            '通知內容' => 'content',
                        ])
                        ->value($this->contactBook->schoolNotificationContents->values())
                        ->enableAdd(false),
                ]),
                Group::make([
                    Matrix::make('classNotifications')
                        ->title('班級通知事項')
                        ->columns([
                            '通知內容' => 'content',
                        ])
                        ->value($this->contactBook->classNotifications->values())
                        ->enableAdd(false),
                ]),
                Group::make([
                    Matrix::make('studentNotifications')
                        ->title('學生通知事項')
                        ->columns([
                            '學生' => 'student_id',
                            '通知內容' => 'content',
                        ])
                        ->fields([
                            'student_id' => Select::make('student_id')
                                ->fromModel(Student::class, 'name'),
                            'content' => TextArea::make('content'),
                        ])
                        ->value($this->contactBook->studentNotifications->values())
                        ->enableAdd(false),
                ]),

                TextArea::make('contactBook.remark')
                    ->title('備註'),
            ]),
        ];
    }

    public function name(): string
    {
        return $this->isEdit ? '編輯聯絡簿' : '新增聯絡簿';
    }

    public function description(): string
    {
        return $this->isEdit ? '編輯特定聯絡簿記錄' : '新增聯絡簿記錄';
    }

    public function save(ContactBook $contactBook, Request $request)
    {
        $data = $request->validate([
            'schoolNotificationContents' => 'nullable|array',
            'classNotifications' => 'nullable|array',
            'studentNotifications' => 'nullable|array',
        ]);

        $existingContactBook = ContactBook::whereDate('created_at', now()->toDateString())->first();
        $contactBook = $existingContactBook ? $existingContactBook->fill($data) : new ContactBook($data);
        Log::info('$contactBook->id');
        Log::info($request->input('contactBook.remark'));
        $contactBook->remark = $request->input('contactBook.remark');
        $contactBook->save();
        Log::info('$contactBook->id');

        $this->handleMatrixData($contactBook, $data);
        Toast::info('聯絡簿記錄已' . ($existingContactBook ? '更新' : '儲存') . '。');
        return redirect()->route('platform.contactbook.list');
    }

    private function handleMatrixData($contactBook, $data)
    {
        Log::info('into handleMatrixData');
        Log::info($contactBook);

        $this->processMatrixData(SchoolNotificationContent::class, $data['schoolNotificationContents'] ?? [], $contactBook);
        $this->processStudentNotifications($data['studentNotifications'] ?? [], $contactBook);
        $this->processMatrixData(ClassNotification::class, $data['classNotifications'] ?? [], $contactBook);
    }

    private function processMatrixData($model, $data, $contactBook)
    {
        $existingIds = $model::where('contact_book_id', $contactBook->id)->pluck('id')->toArray();

        $updatedIds = [];
        foreach ($data as $item) {
            $item['contact_book_id'] = $contactBook->id;
            $modelInstance = $model::updateOrCreate(['id' => $item['id'] ?? null], $item);
            $updatedIds[] = $modelInstance->id;
        }

        $idsToDelete = array_diff($existingIds, $updatedIds);
        if (!empty($idsToDelete)) {
            $model::whereIn('id', $idsToDelete)->delete();
        }
    }

    private function processStudentNotifications($data, $contactBook)
    {
        $existingIds = StudentNotification::where('contact_book_id', $contactBook->id)->pluck('id')->toArray();

        $updatedIds = [];
        foreach ($data as $item) {
            $itemData = [
                'contact_book_id' => $contactBook->id,
                'student_id' => $item['student_id'], // 映射 'student' 到 'student_id'
                'content' => $item['content']
            ];

            $notification = StudentNotification::updateOrCreate(['id' => $item['id'] ?? null], $itemData);
            $updatedIds[] = $notification->id;
        }

        $idsToDelete = array_diff($existingIds, $updatedIds);
        if (!empty($idsToDelete)) {
            StudentNotification::whereIn('id', $idsToDelete)->delete();
        }
    }
}

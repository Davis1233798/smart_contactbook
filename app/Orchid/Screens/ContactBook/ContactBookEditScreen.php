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

    public function query(ContactBook $contactBook): array
    {
        $contactBook->load(
            'classNotifications',
            'studentNotifications',
            'schoolNotificationContents'
        );
        $this->contactBook = $contactBook;

        // 取得所有學生
        $students = Student::all(); // 假設學生有 id 和 name 欄位
        $students->load('studentParentSignContactBooks');

        return [
            'contactBook' => $contactBook,
            'student_notifications' => $contactBook->studentNotifications ? $contactBook->studentNotifications : null,
            'class_notifications' => $contactBook->classnotifications ? $contactBook->classnotifications : null,
            'school_notification_contents' => $contactBook->schoolNotificationContents ? $contactBook->schoolNotificationContents : null,
            'students' => $students, // 新增學生列表
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
        // 取得所有學生的 id 和 name，用於 Select
        $students = Student::all()->pluck('name', 'id');

        return [
            Layout::rows([
                // TextArea::make('contactBook.content')
                //     ->title('聯絡事項'),


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
                            '學生' => 'student',
                            '通知內容' => 'content',
                        ])
                        ->fields([
                            'student' => Select::make('student')->options($students),
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
        return '新增聯絡簿';
    }

    public function description(): string
    {
        return '編輯特定聯絡簿記錄';
    }

    public function save(ContactBook $contactBook, Request $request)
    {
        $data = $request->validate([
            'schoolNotificationContents' => 'nullable|array',
            'classNotifications' => 'nullable|array',
            'studentNotifications' => 'nullable|array',
        ]);

        // 更新或創建 ContactBook 實例
        $existingContactBook = ContactBook::whereDate('created_at', now()->toDateString())->first();
        $contactBook = $existingContactBook ? $existingContactBook->fill($data) : new ContactBook($data);
        $contactBook->save();
        Log::info('$contactBook->id');
        Log::info($contactBook);
        // 處理 Matrix 相關資料
        $this->handleMatrixData($contactBook, $data);
        Toast::info('聯絡簿記錄已' . ($existingContactBook ? '更新' : '儲存') . '。');
        return redirect()->route('platform.contactbook.list');
    }

    private function handleMatrixData($contactBook, $data)
    {
        Log::info('into handleMatrixData');
        Log::info($contactBook);
        // 檢查並處理 school_notification_contents
        if (isset($data['schoolNotificationContents']) && is_array($data['schoolNotificationContents'])) {
            foreach ($data['schoolNotificationContents'] as $contentData) {
                // 在這裡進行創建或更新操作
                SchoolNotificationContent::updateOrCreate(
                    ['id' => $contentData['id'] ?? null],
                    [
                        'contact_book_id' => $contactBook->id,
                        'content' => $contentData['content'],
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]
                );
            }
        }

        // 檢查並處理 student_notifications
        if (isset($data['studentNotifications']) && is_array($data['studentNotifications'])) {
            foreach ($data['studentNotifications'] as $notificationData) {
                // 在這裡進行創建或更新操作                
                StudentNotification::updateOrCreate(
                    ['id' => $notificationData['id'] ?? null],

                    [
                        'student_id' => $notificationData['student'],
                        'contact_book_id' => $contactBook->id,
                        'sign_time' => now(),
                        'content' => $notificationData['content'],
                    ]
                );
            }
        }
        // 檢查並處理 class_notifications
        if (isset($data['classNotifications']) && is_array($data['classNotifications'])) {
            foreach ($data['classNotifications'] as $notificationData) {
                // 在這裡進行創建或更新操作
                ClassNotification::updateOrCreate(
                    ['id' => $notificationData['id'] ?? null],
                    [
                        'contact_book_id' => $contactBook->id,
                        'content' => $notificationData['content'],
                    ]
                );
            }
        }
    }
}

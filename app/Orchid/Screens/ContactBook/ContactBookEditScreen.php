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
                TextArea::make('contactBook.content')
                    ->title('聯絡事項'),

                TextArea::make('contactBook.remark')
                    ->title('備註'),

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
                            '通知內容' => 'reply',
                        ])
                        ->fields([
                            'student' => Select::make('student')->options($students),
                        ])
                        ->value($this->contactBook->studentNotifications->values())
                        ->enableAdd(false),
                ]),
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
        // 從請求中獲取表單數據
        $data = $request->validate([
            'contactBook.content' => 'required|string',
            'contactBook.remark' => 'nullable|string',
            'schoolNotificationContents' => 'nullable|array',
            'classNotifications' => 'nullable|array',
            'studentNotifications' => 'nullable|array',
        ]);

        // 檢查是否已存在當日的聯絡簿記錄
        $existingContactBook = ContactBook::whereDate('created_at', now()->toDateString())->first();

        if ($existingContactBook) {
            // 如果已存在，更新該記錄
            $existingContactBook->update($data);
            $message = '聯絡簿記錄已更新。';
        } else {
            // 如果不存在，創建新的記錄
            ContactBook::create($data);
            $message = '聯絡簿記錄已儲存。';
        }

        // 顯示成功信息並重定向到列表頁面
        Toast::info($message);
        return redirect()->route('platform.contactbook.list');
    }
}

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
use Orchid\Screen\Fields\Matrix as FieldsMatrix;
use Orchid\Screen\Fields\Select;

class ContactBookEditScreen extends Screen
{
    private $contactBook;

    public function query(ContactBook $contactBook): array
    {
        $this->contactBook = $contactBook;

        // 获取所有学生
        $students = Student::all()->pluck('name', 'id'); // 假设学生有 id 和 name 字段

        return [
            'contactBook' => $contactBook,
            'student_notifications' => $contactBook->student ? $contactBook->student->notifications : null,
            'class_notifications' => $contactBook->student ? $contactBook->student->classnotifications : null,
            'students' => $students, // 添加学生列表
        ];
    }


    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): array
    {
        debug($this);
        return [
            Layout::rows([

                Group::make([
                    FieldsMatrix::make('student_notifications')
                        ->title('學生通知')
                        ->columns(['學生' => 'student_id', '內容' => 'content'])
                        ->fields([
                            'student_id' => Select::make('student_id')
                                ->options($this->query($this->contactBook)['students']) // 使用学生列表
                            ,
                            'content' => TextArea::make('content'),
                        ])
                        ->value($this->contactBook ? $this->contactBook->studentNotifications : [])
                        ->addRows(),
                ]),
                Group::make([
                    FieldsMatrix::make('class_notifications')
                        ->title('班級通知')
                        ->columns(['內容' => 'content'])
                        ->value($this->contactBook ? $this->contactBook->classNotifications : [])
                        ->addRows(),
                ]),


                TextArea::make('contactBook.content')
                    ->title('其他內容'),
                TextArea::make('contactBook.reply')
                    ->title('回覆事項'),
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
        return 'Edit a specific contact book record';
    }

    public function save(ContactBook $contactBook)
    {


        Toast::info('Contact book record saved.');

        return redirect()->route('platform.contactbook.list');
    }
}

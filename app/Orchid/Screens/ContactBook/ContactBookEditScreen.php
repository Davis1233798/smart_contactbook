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

        // 取得所有學生
        $students = Student::all()->pluck('name', 'id'); // 假設學生有 id 和 name 欄位

        return [
            'contactBook' => $contactBook,
            'student_notifications' => $contactBook->student ? $contactBook->student->notifications : null,
            'class_notifications' => $contactBook->student ? $contactBook->student->classnotifications : null,
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
        debug($this);
        return [
            Layout::rows([





                TextArea::make('contactBook.content')
                    ->title('聯絡事項'),

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

    public function save(ContactBook $contactBook)
    {


        Toast::info('聯絡簿記錄已儲存。');

        return redirect()->route('platform.contactbook.list');
    }
}

<?php

namespace App\Orchid\Layouts\ContactBook;

use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StudentNotificationLayout extends Table
{
    protected $target = 'studentNotifications';

    protected function columns(): array
    {
        return [

            TD::make('student_name', '學生姓名')
                ->render(function ($studentNotifications) {
                    $nameData = Student::find($studentNotifications->student_id);
                    $name = json_decode($nameData)->name;
                    return $name;
                }),

            TD::make('content', '內容')
                ->render(function ($studentNotifications) {
                    return '<div>' . $studentNotifications->content . '</div>';
                }),

            TD::make('created_at', '創建時間')
                ->sort()
                ->render(function ($studentNotifications) {
                    return $studentNotifications->created_at->toDateTimeString();
                }),
        ];
    }
}

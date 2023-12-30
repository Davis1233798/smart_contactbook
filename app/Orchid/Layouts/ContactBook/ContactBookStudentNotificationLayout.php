<?php

namespace App\Orchid\Layouts\ContactBook;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactBookStudentNotificationLayout extends Table
{
    protected $target = 'studentNotifications';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide(),

            TD::make('student_id', '學生ID')
                ->sort(),

            TD::make('title', '標題')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('content', '內容')
                ->render(function ($notification) {
                    return '<div>' . $notification->content . '</div>';
                }),

            TD::make('created_at', '創建時間')
                ->sort()
                ->render(function ($notification) {
                    return $notification->created_at->toDateTimeString();
                }),
        ];
    }
}

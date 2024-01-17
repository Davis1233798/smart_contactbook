<?php

namespace App\Orchid\Layouts\ContactBook;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SchoolNotificationContentLayout extends Table
{
    protected $target = 'schoolNotificationContents';

    protected function columns(): array
    {
        return [
            // TD::make('id', 'ID')
            //     ->sort()
            //     ->cantHide(),

            // TD::make('student_id', '學生ID')
            //     ->sort(),

            // TD::make('title', '標題')
            //     ->sort()
            //     ->filter(TD::FILTER_TEXT),

            TD::make('content', '內容')
                ->render(function ($schoolNotificationContents) {
                    return '<div>' . $schoolNotificationContents->content . '</div>';
                }),

            TD::make('created_at', '創建時間')
                ->sort()
                ->render(function ($schoolNotificationContents) {
                    return $schoolNotificationContents->created_at->toDateTimeString();
                }),
        ];
    }
}

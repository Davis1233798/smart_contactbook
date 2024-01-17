<?php

namespace App\Orchid\Layouts\ContactBook;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClassNotificationLayout extends Table
{
    protected $target = 'classNotifications';

    protected function columns(): array
    {
        return [

            // TD::make('title', '標題')
            //     ->sort()
            //     ->filter(TD::FILTER_TEXT),

            TD::make('content', '內容')
                ->render(function ($classNotifications) {
                    return '<div>' . $classNotifications->content . '</div>';
                }),

            TD::make('created_at', '創建時間')
                ->sort()
                ->render(function ($classNotifications) {
                    return $classNotifications->created_at->toDateTimeString();
                }),
        ];
    }
}

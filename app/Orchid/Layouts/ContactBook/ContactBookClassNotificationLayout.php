<?php

namespace App\Orchid\Layouts\ContactBook;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactBookClassNotificationLayout extends Table
{
    protected $target = 'classNotifications';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide(),

            TD::make('title', '標題')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('content', '內容')
                ->render(function ($notification) {
                    return '<div>'. $notification->content .'</div>';
                }),

            TD::make('created_at', '創建時間')
                ->sort()
                ->render(function ($notification) {
                    return $notification->created_at->toDateTimeString();
                }),
        ];
    }
}

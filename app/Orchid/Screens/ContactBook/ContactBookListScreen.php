<?php

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class ContactBookListScreen extends Screen
{
    public function query(): array
    {
        return [
            'contactBooks' => ContactBook::paginate(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('新增聯絡簿')
                ->icon('plus')
                ->route('platform.contactbook.create'),
            Link::make('發送聯絡簿')
                ->icon('arrow-up')
                ->method('sendContactBook'),

        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('contactBooks', [
                TD::make('id', 'ID')
                    ->sort()
                    ->cantHide(),

                TD::make('content', 'Content'),

                TD::make('remark', 'Remark'),
                TD::make('created_at', 'Created At')
                    ->sort()
                    ->render(function (ContactBook $contactBook) {
                        return $contactBook->created_at->toDateTimeString();
                    }),

            ]),
        ];
    }

    public function name(): string
    {
        return '聯絡簿列表';
    }

    public function description(): string
    {
        return '聯絡簿列表紀錄';
    }
    public function sendContactBook(ContactBook $contactBook)
    {
        $contactBook->sendContactBook();
        Toast::info('聯絡簿已發送');
    }
}

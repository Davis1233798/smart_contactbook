<?php

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Layouts\Row;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Orchid\Layouts\ContactBook\StudentNotificationLayout;
use App\Orchid\Layouts\ContactBook\ClassNotificationLayout;
use App\Orchid\Layouts\ContactBook\SchoolNotificationContentLayout;

class ContactBookShowScreen extends Screen
{
    private $contactBook;
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query($contactBookId): array
    {

        $contactBook = ContactBook::find($contactBookId);
        $contactBook->load('classNotifications', 'studentNotifications', 'schoolNotificationContents');
        $this->contactBook = $contactBook;
        Log::info($contactBook);
        return [
            'contactBook' => $contactBook,
            'classNotifications' => $contactBook->classNotifications,
            'studentNotifications' => $contactBook->studentNotifications,
            'schoolNotificationContents' => $contactBook->schoolNotificationContents,
        ];
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Label::make('contactBook.date')
                    ->title('日期'),
                Label::make('contactBook.content')
                    ->title('聯絡事項'),
                Label::make('contactBook.remark')
                    ->title('備註'),
                // 以下為新增的部分

            ]),
            Layout::block(ClassNotificationLayout::class)
                ->title('班級通知事項')
                ->vertical(true),
            Layout::block(SchoolNotificationContentLayout::class)
                ->title('學校通知內容')
                ->vertical(true),
            Layout::block(StudentNotificationLayout::class)
                ->title('學生通知事項')
                ->vertical(true),
        ];
    }
}

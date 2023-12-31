<?php

namespace App\Orchid\Screens\StudentNotification;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Models\StudentNotification;
use Orchid\Screen\Layout;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout as FacadesLayout;

class StudentNotificationListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = '學生通知列表';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '所有學生的通知';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'notifications' => StudentNotification::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('新增通知')
                ->icon('plus')
                ->route('platform.student-notification.create')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {

        return [

            FacadesLayout::table('notifications', [
                TD::make('id', 'ID')
                    ->sort()
                    ->cantHide(),
                TD::make('學生姓名', 'Student Name')
                    ->sort()
                    ->cantHide()
                    ->render(function (StudentNotification $notification) {
                        return $notification->student->name;
                    }),
                TD::make('content', 'Content'),




            ]),
        ];
    }
}

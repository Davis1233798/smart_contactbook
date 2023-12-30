<?php

namespace App\Orchid\Screens\StudentNotification;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Models\StudentNotification;

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
                ->route('platform.studentnotification.edit')
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

        ];
    }
}

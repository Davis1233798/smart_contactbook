<?php

namespace App\Orchid\Screens\StudentNotification;

use App\Models\Student;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use App\Models\StudentNotification;
use Illuminate\Http\Client\Request;

class StudentNotificationEditScreen extends Screen
{
    public $notification;

    public function query(StudentNotification $notification): array
    {
        $this->notification = $notification;

        return [
            'notification' => $notification
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('儲存')
                ->icon('check')
                ->method('save')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Relation::make('notification.student_id')
                    ->title('學生')
                    ->fromModel(Student::class, 'name'),

                Input::make('notification.contact_id')
                    ->title('聯絡簿ID'),

                TextArea::make('notification.content')
                    ->title('內容')
            ])
        ];
    }

    public function save(StudentNotification $notification, Request $request)
    {
        $notification->fill($request->get('notification'))->save();
        Alert::info('學生通知已成功儲存。');

        return redirect()->route('platform.studentnotification.list');
    }
}

<?php

namespace App\Orchid\Screens\Student;

use App\Actions\LineNotify\LineNotifySendAction;
use App\Models\ContactBook;
use App\Models\LineNotify;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class StudentListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */

    public function query(): array
    {

        return [
            'students' => Student::paginate(),
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
            Link::make('新增學生')
                ->icon('plus')
                ->route('platform.students.create'),

            Button::make('匯入學生')
                ->icon('cloud-upload')
                ->method('methodImportStudent'),

            Button::make('發送今日聯絡簿')
                ->icon('arrow-up')
                ->method('methodSendContactBook'),
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
            Layout::table(
                'students',
                array_merge(
                    [
                        TD::make('school_number', '學號')
                            ->sort(),
                        TD::make('seat_number', '座號')
                            ->sort(),
                        TD::make('name', '姓名')
                            ->sort(),
                        TD::make('contact_book', '聯絡簿')
                            ->sort()
                            ->render(function (Student $student) {
                                return $student->signed === 1 ? '<span class="text-success">已簽</span>' : '<span class="text-danger">未簽</span>';
                            }),
                        TD::make('actions', '編輯')
                            ->render(function (Student $student) {
                                return Link::make('')
                                    ->icon('note')
                                    ->route('platform.students.edit', $student->id)
                                    ->class('btn btn-sm btn-info');
                            }),
                        TD::make(__('QRcode'))
                            ->cantHide()
                            ->align(TD::ALIGN_CENTER)
                            ->render(function (Student $student) {
                                return Link::make('')
                                    ->icon('qr-code')
                                    ->route('platform.students.qrcode', $student->id)
                                    ->class('btn btn-sm btn-primary'); // Add this line to set the background color
                            }),
                    ],
                    $this->actionButtons(),
                )
            ),

        ];
    }
    public function methodRemove(): RedirectResponse
    {
        $id = request()->get('id');
        Log::info('刪除學生' . $id . '資料');
        try {
            $student = Student::find($id);
            // 刪除模型
            $student->parentInfo ? $student->parentInfo->delete() : '';
            $student->delete();

            // 顯示訊息
            Toast::info(__('刪除成功'));

            // 返回列表
            return redirect()->route('platform.students.list');
        } catch (\Exception $e) {
            Toast::error(__('發生錯誤') . $e->getMessage());

            throw $e;
        }
    }
    public function actionButtons(): array
    {
        return [

            TD::make(__('刪除'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->render(function (Student $student) {
                    return Button::make()
                        ->icon('trash')
                        ->confirm(__('確定刪除') . $student->name . __('此動作無法復原'))
                        ->method('methodRemove', [
                            'id' => $student->id,
                        ]);
                }),

        ];
    }
    public function methodSendContactBook(): RedirectResponse
    {
        // 查詢今日的ContactBook
        $contactBook = ContactBook::whereDate('created_at', now()->toDateString())->first();

        // 直接發送ContactBook
        $action = app()->make(LineNotifySendAction::class);
        $action->execute();

        // 將is_sent改為1
        if ($contactBook) {
            $contactBook->is_sent = 1;
            $contactBook->save();
        }

        // 返回列表
        return redirect()->route('platform.students.list');
    }
}

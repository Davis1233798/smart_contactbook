<?php

namespace App\Orchid\Screens\Student;

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
                    TD::make('id', 'ID')
                        ->sort()
                        ->cantHide(),
                    TD::make('seat_number', '座號')
                        ->sort(),
                    TD::make('school_number', '學號')
                        ->sort(),
                    TD::make('name', '姓名')
                        ->sort(),
                    TD::make('actions', '操作')
                        ->render(function (Student $student) {
                            return Link::make('編輯')
                                ->route('platform.students.edit', $student);
                        }),

                        TD::make(__('Qrcode'))
                        ->cantHide()
                        ->align(TD::ALIGN_CENTER)
                        ->render(function (Student $student) {
                            return Button::make()
                                ->icon('qrcode')
                                ->method('showQrcode', [
                                    'id' => $student->id,
                                ]);
                        }),



                    ],
                    $this->actionButtons(),
                )
            ),
            $this->modalLineQrcode(),
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
            Toast::info(__('translate.刪除成功'));

            // 返回列表
            return redirect()->route('platform.students.list');
        } catch (\Exception $e) {
            Toast::error(__('translate.發生錯誤') . $e->getMessage());

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
                        ->confirm(__('translate.確定刪除').$student->name.__('translate.此動作無法復原'))
                        ->method('methodRemove', [
                            'id' => $student->id,
                        ]);
                }),

        ];
    }
    public function methodSendContactBook(): RedirectResponse
    {
        Log::info(request());

        return redirect()->route('platform.students.list');
    }
    public function showQrcode(): RedirectResponse
    {
        $studentId = request()->get('id');
        // 這裡添加生成 QR 碼的邏輯
        // ...

        // 假設你有一個 route 用於顯示 QR 碼
        return redirect()->route('student.qrcode', ['id' => $studentId]);
    }


}

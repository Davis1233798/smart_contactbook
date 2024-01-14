<?php

namespace App\Orchid\Screens\Student;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\Student;
use App\Orchid\Fields\QrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class StudentQrcodeScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public ?Student $student = null;

    public function name(): ?string
    {

        return 'QRCode';
    }

    public function query(Student $student): array
    {
        Log::info(config('app.line_id'));

        $lineNotifyUrl = 'https://notify-bot.line.me/oauth/authorize?'.
          http_build_query([
              'response_type' => 'code',
              'scope' => 'notify',
              'response_mode' => 'form_post',
              'client_id' => config('app.line_id'),
              'redirect_uri' => config('app.url').'/api/callback',
              'state' => $student->parentInfos->first()->line_id,
          ]);
        Cache::set('lineNotifyUrl', $lineNotifyUrl);
        return [
            'url' => $lineNotifyUrl ,
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
            //回上一頁
            Link::make(__('回上一頁'))
                ->icon('action-undo')
                ->route('platform.students.list'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {

        $url = Cache::pull('lineNotifyUrl');
        return [
            Layout::rows([

                Link::make(__('請點擊此連結，或掃描下面 QR Code，進行綁定'))
                    ->href($url ? $url : '')
                    ->icon('link'),
                QrCode::make('url')
                    ->data($url ? $url : '')
                    ->generate(),

            ]),
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
                        ->confirm(__('確定刪除').$student->name.__('此動作無法復原'))
                        ->method('methodRemove', [
                            'id' => $student->id,
                        ]);
                }),
        ];
    }
    public function methodSendContactBook(): RedirectResponse
    {
        return redirect()->route('platform.students.list');
    }

}

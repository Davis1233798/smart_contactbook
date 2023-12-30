<?php

namespace App\Orchid\Screens\LineNotify;

use App\Orchid\Fields\QrCode;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class LineNotifyScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [

        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return __('menu.Line 通知助手');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */

    /**
     * @throws \Exception
     */
    public function layout(): iterable
    {
        $lineNotifyUrl = 'https://notify-bot.line.me/oauth/authorize?'.
            http_build_query([
                'response_type' => 'code',
                'scope' => 'notify',
                'response_mode' => 'form_post',
                'client_id' => env('LINE_NOTIFY_CLIENT_ID'),
                'redirect_uri' => env('APP_URL').'/api/callback',
                'state' => bin2hex(random_bytes(16)),
            ]);

        return [

            Layout::rows([
                Link::make(__('translate.請點擊此連結，或掃描下面 QR Code，進行綁定'))
                    ->href($lineNotifyUrl)
                    ->icon('link'),

                QrCode::make('url')
                    //->title('QR Code')
                    ->data($lineNotifyUrl)
                    ->generate(),

            ]),

        ];
    }
}

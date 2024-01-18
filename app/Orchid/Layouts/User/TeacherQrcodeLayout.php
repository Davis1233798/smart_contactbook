<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use App\Orchid\Fields\QrCode;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class TeacherQrcodeLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $url = Cache::pull('lineNotifyUrl');

        return [
            Link::make(__('請點擊此連結，或掃描下面 QR Code，進行綁定'))
                ->href($url ? $url : '')
                ->icon('link'),

            QrCode::make('url')
                ->data($url ? $url : '')
                ->generate(),
        ];
    }
}

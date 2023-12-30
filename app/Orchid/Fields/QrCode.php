<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

/**
 * @method Input help(string $value = null)
 */
class QrCode extends Field
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.qrcode';

    /**
     * Default attributes value
     *
     * @var array
     */
    protected $attributes = [
        'backend' => 'svg',
        'size' => 192,
        'margin' => 2,
        'data' => '',
        'qrcode' => '',
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            if (empty($this->get('data')) ||
                is_null($this->get('data')) ||
                is_bool($this->get('data'))) {
                return $this->set('qrcode', $this->emptyQrCode($this->get('size')));
            }

            $imageBackEnd = match ($this->get('backend', '')) {
                'imagick' => new ImagickImageBackEnd(),
                'eps' => new EpsImageBackEnd(),
                default => new SvgImageBackEnd(),
            };

            return $this->set('qrcode', (new Writer(
                new ImageRenderer(
                    new RendererStyle($this->get('size'), $this->get('margin')),
                    $imageBackEnd
                )
            ))->writeString((string) $this->get('data')));
        });
    }

    /**
     * @param  int  $size
     * @return string
     */
    public function emptyQrCode(int $size = 192)
    {
        return sprintf('<img width="%d" height="%d" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIxNzkyIiB2aWV3Qm94PSIwIDAgMTc5MiAxNzkyIiB3aWR0aD0iMTc5MiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNTc2IDExNTJ2MTI4aC0xMjh2LTEyOGgxMjh6bTAtNzY4djEyOGgtMTI4di0xMjhoMTI4em03NjggMHYxMjhoLTEyOHYtMTI4aDEyOHptLTEwMjQgMTAyM2gzODR2LTM4M2gtMzg0djM4M3ptMC03NjdoMzg0di0zODRoLTM4NHYzODR6bTc2OCAwaDM4NHYtMzg0aC0zODR2Mzg0em0tMjU2IDI1NnY2NDBoLTY0MHYtNjQwaDY0MHptNTEyIDUxMnYxMjhoLTEyOHYtMTI4aDEyOHptMjU2IDB2MTI4aC0xMjh2LTEyOGgxMjh6bTAtNTEydjM4NGgtMzg0di0xMjhoLTEyOHYzODRoLTEyOHYtNjQwaDM4NHYxMjhoMTI4di0xMjhoMTI4em0tNzY4LTc2OHY2NDBoLTY0MHYtNjQwaDY0MHptNzY4IDB2NjQwaC02NDB2LTY0MGg2NDB6Ii8+PC9zdmc+">', $size, $size);
    }
}

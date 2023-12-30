<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Fields\Picture;

/**
 * @method Thumbnail width(string $value = '48px')
 * @method Thumbnail height(string $value = '48px')
 * @method Thumbnail type(string $value = 'thumbnail')
 * @method Thumbnail rounded($value = true)
 * @method Thumbnail float($value = '')
 * @method Thumbnail alt($value = '')
 */
class Thumbnail extends Picture
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.thumbnail';

    /**
     * Default attributes value
     *
     * @var array
     */
    protected $attributes = [
        'value' => null,
        'target' => 'url',
        'url' => null,
        'width' => 'auto',
        'height' => '48px',
        'type' => 'thumbnail', // or fluid (This applies max-width: 100%; and height: auto;)
        'rounded' => true,
        'float' => '', // start or end
        'alt' => '',
        'isEmpty' => 'no',
        'wsrv' => false, // use wsrv.nl An image cache & resize service.
        'gallery' => '',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            if (empty($this->get('url')) && empty($this->get('value'))) {
                $this->set('isEmpty', 'yes');

                return $this->set('url', $this->emptyImageSrc());
            }

            return $this;
        });
    }

    /**
     * @return string
     */
    public function emptyImageSrc(): string
    {
        return 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZmlsbD0ibm9uZSIgaGVpZ2h0PSIyNCIgc3Ryb2tlLXdpZHRoPSIxLjUiIHZpZXdCb3g9IjAgMCAyNCAyNCIgd2lkdGg9IjI0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0zIDE2TDEwIDEzTDE0IDE0LjgxODIiIHN0cm9rZT0iY3VycmVudENvbG9yIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48cGF0aCBkPSJNMTYgMTBDMTQuODk1NCAxMCAxNCA5LjEwNDU3IDE0IDhDMTQgNi44OTU0MyAxNC44OTU0IDYgMTYgNkMxNy4xMDQ2IDYgMTggNi44OTU0MyAxOCA4QzE4IDkuMTA0NTcgMTcuMTA0NiAxMCAxNiAxMFoiIHN0cm9rZT0iY3VycmVudENvbG9yIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48cGF0aCBkPSJNMTYuODc4NiAyMS4xMjEzTDE5IDE5TTIxLjEyMTMgMTYuODc4N0wxOSAxOU0xOSAxOUwxNi44Nzg2IDE2Ljg3ODdNMTkgMTlMMjEuMTIxMyAyMS4xMjEzIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+PHBhdGggZD0iTTEzIDIxSDMuNkMzLjI2ODYzIDIxIDMgMjAuNzMxNCAzIDIwLjRWMy42QzMgMy4yNjg2MyAzLjI2ODYzIDMgMy42IDNIMjAuNEMyMC43MzE0IDMgMjEgMy4yNjg2MyAyMSAzLjZWMTMiIHN0cm9rZT0iY3VycmVudENvbG9yIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48L3N2Zz4=';
    }
}

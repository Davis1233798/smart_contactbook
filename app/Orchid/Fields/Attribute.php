<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Illuminate\Support\Facades\Route;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

/**
 * @method Input help(string $value = null)
 */
class Attribute extends Field
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.attribute';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'formMethod' => 'post',
        'formAction' => null,
    ];

    public function routeForAction(string $name, array $params = [], $method = 'post')
    {
        if (Route::has($name)) {
            $this->set('formAction', route($name, $params));
        }

        return $this->set('formMethod', $method);
    }
}

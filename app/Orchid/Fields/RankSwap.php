<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

/**
 * @method Input help(string $value = null)
 */
class RankSwap extends Field
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.rank-swap';

    /**
     * Default attributes value
     *
     * @var array
     */
    protected $attributes = [
        'formMethod' => 'post',
        'formAction' => null,
        'modelId' => null,
        'index' => null,
        'rank' => 0,
        'autoSubmit' => true,
    ];

    public function __construct()
    {
        $this->addBeforeRender(function () {
            return $this;
        });
    }

    public function autoSubmit(bool $value = true): Field|RankSwap
    {
        return $this->set('autoSubmit', $value);
    }

    public function targetModel(Model $model, string $rankField = 'rank'): Field|RankSwap
    {
        $primaryKey = $model->getKeyName();

        return $this
            ->set('modelId', $model->$primaryKey)
            ->set('rank', $model->$rankField);
    }

    public function routeForUpdate(string $name, array $params = [], $method = 'post'): Field|RankSwap
    {
        if (Route::has($name)) {
            $this->set('formAction', route($name, $params));
        }

        return $this->set('formMethod', $method);
    }
}

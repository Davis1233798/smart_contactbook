<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Illuminate\Support\Str;
use Orchid\Screen\Fields\Select;

/**
 * Class SelectEx.
 *
 * @method SelectEx readonly($value = true)
 * @method SelectEx disabledOptions($value = null)
 */
class SelectEx extends Select
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.select-ex';

    public function __construct()
    {
        parent::__construct();

        $this->attributes = array_merge($this->attributes, [
            'readonly' => false,
            'disabledOptions' => [],
            'lockedOptions' => [],
            'disabledClear' => false,
            'lockedMessage' => __('the option has been locked'),
            'filterableOptions' => [],
        ]);
    }

    public function touch($name)
    {
        $this->attributes['name'] = '#'.$name;

        return $this;
    }

    public function touchOptions($options, $parentLevelValue = null)
    {
        $this->attributes['filterableOptions'] = $options;
        $filterOptions = [];
        foreach ($options as $value => $label) {
            if (Str::startsWith($value, $parentLevelValue.'.')) {
                $key = explode('.', $value);
                array_shift($key);
                $key = implode('.', $key);
                $filterOptions[$key] = $label;
            }
        }
        $this->attributes['options'] = $filterOptions;

        return $this;
    }
}

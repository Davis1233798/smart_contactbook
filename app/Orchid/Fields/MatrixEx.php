<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\TextArea;

/**
 * Class MatrixEx
 *
 * @method MatrixEx columns(array $columns)
 * @method MatrixEx keyValue(bool $keyValue)
 * @method MatrixEx title(string $value = null)
 * @method MatrixEx help(string $value = null)
 * @method MatrixEx invisible(array $columns)
 * @method enabledAdd(false $false)
 */
class MatrixEx extends Matrix
{
    /**
     * @var string
     */
    protected $view = 'orchid.fields.matrix-ex';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'index' => 0,
        'removableRows' => true,
        'draggableRows' => false,
        'enabledAdd' => true,
        'idPrefix' => null,
        'maxRows' => 0,
        'initRows' => 0,
        'keyValue' => false,
        'fields' => [],
        'labels' => [],
        'invisible' => [],
        'columns' => [
            'key',
            'value',
        ],
    ];

    /**
     * Matrix constructor.
     */
    public function __construct()
    {
        $this
            ->addBeforeRender(function () {
                if ($this->get('value') === null) {
                    $this->set('value', []);
                }

                $value = collect($this->get('value'))
                    ->sortKeys()
                    ->toArray();

                $this->set('value', $value);
                $this->set(
                    'index',
                    empty($value) ? 0 : array_key_last($value)
                );
            })
            ->addBeforeRender(function () {
                $fields = $this->get('fields');
                $invisible = $this->get('invisible');

                foreach ($this->get('columns') as $key => $column) {
                    if (!isset($fields[$key])) {
                        $fields[$key] = TextArea::make();
                    }

                    if (!isset($fields[$column])) {
                        $fields[$column] = TextArea::make();
                    }

                    if (in_array($column, $invisible)) {
                        $fields[$column] = Input::make()->type('hidden');
                    }
                }

                $this->set('fields', $fields);
            })
            ->addBeforeRender(function () {
                $idPrefix = $this->getIdPrefix();

                $this->set('idPrefix', $idPrefix);
            });
    }

    /**
     * @param  int  $count
     * @return Field|MatrixEx
     */
    public function maxRows(int $count)
    {
        return $this->set('maxRows', $count);
    }

    /**
     * @param  int  $count
     * @return Field|MatrixEx
     */
    public function initRows(int $count)
    {
        return $this->set('initRows', $count);
    }

    /**
     * @param  bool  $value
     * @return Field|MatrixEx
     */
    public function draggableRows(bool $value = true)
    {
        return $this->set('draggableRows', $value);
    }

    /**
     * @param  bool  $value
     * @return Field|MatrixEx
     */
    public function removableRows(bool $value = true)
    {
        return $this->set('removableRows', $value);
    }

    /**
     * @param  Field[]  $fields
     * @return $this
     */
    public function fields(array $fields = []): self
    {
        return $this->set('fields', $fields);
    }

    /**
     * @return $this
     */
    public function labels(array $labels = []): self
    {
        return $this->set('labels', $labels);
    }

    /**
     * @return string
     */
    protected function getIdPrefix(): string
    {
        $idPrefix = $this->get('idPrefix');

        if ($idPrefix !== null) {
            return (string) $idPrefix;
        }

        $slug = str_replace('.', '-', $this->getOldName());

        return "matrix-field-$slug";
    }
}

<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use App\Models\FileLevel;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\TextArea;
use App\Http\Traits\FileUploadTrait;

/**
 * Class MatrixEx
 *
 * @method MatrixEx columns(array $columns)
 * @method MatrixEx keyValue(bool $keyValue)
 * @method MatrixEx title(string $value = null)
 * @method MatrixEx help(string $value = null)
 * @method MatrixEx invisible(array $columns)
 */
class FileUpload extends Matrix
{
    use FileUploadTrait;

    /**
     * @var string
     */
    protected $view = 'orchid.fields.file-upload';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'index' => 0,
        'removableRows' => true,
        'draggableRows' => true,
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

        // 檔案限制初始值
        'acceptedFiles' => 'all',
        'maxFileSize' => 2,
        'maxFiles' => 10,

        // routing
        'model' => null,
        'group' => null,
        'thisId' => null,

        // 密等欄位
        'noLevel' => false,
        'uploadLevel' => '',
        'editLevel' => '',
        'deleteLevel' => '',
        'levelName'  => '',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'formAction',
        'formMethod',
        'urlParameters',
        'elementName',
        'fileCount',
    ];

    /**
     * Matrix constructor.
     */
    public function __construct()
    {
        $this
            // --------------
            //   1 賦與 input 元素名稱 & 密等權限
            // ---------------
            ->addBeforeRender(function () {
                $this->set('elementName', $this->get('name'));

                $levelName = [];
                foreach (FileLevel::all() as $level) {
                    array_push($levelName, $level->id.$level->name);
                }
                $this->set('levelName', implode(',', $levelName));

                $this->set('uploadLevel', $this->attachmentPermissions('upload'));
                $this->set('editLevel', $this->attachmentPermissions('edit'));
                $this->set('deleteLevel', $this->attachmentPermissions('delete'));

                if ($this->get('noLevel') === false && $this->get('uploadLevel') === '') {
                    $this->set('enabledAdd', false);
                }
            })

            // --------------
            //   2 賦與 value 陣列型態值
            // ---------------
            ->addBeforeRender(function () {
                $attachments = $this->get('data');

                $files = [];
                if ($attachments->count() > 0) {
                    foreach ($attachments as $key => $attachment) {
                        $pieces = explode('.', $attachment->original_name);
                        $description = $pieces[0];

                        // debug($attachment->url);

                        $files[$key] = [
                            'id' => $attachment->id,
                            'photo' => $attachment->url,
                            'name' => $attachment->original_name,
                            'description' => is_null($attachment->description) ? $description : $attachment->description,
                            'date' => $attachment->created_at->toDateString(),
                        ];

                        if (!$this->get('noLevel')) {
                            $files[$key]['level'] = $attachment->level_id;
                        }
                    }
                }

                // debug($files);

                $this->set('fileCount', $attachments->count());
                $this->set('value', $files);
            })

            // --------------
            //   3 重新賦與 value 值
            // ---------------
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

            // --------------
            //   4 組裝 HTML 表單之 input 元素
            // ---------------
            ->addBeforeRender(function () {
                // column
                $columns = ['id', 'photo', 'name', 'description', 'date'];
                if (!$this->get('noLevel')) {
                    array_push($columns, 'level');
                }
                $this->set('columns', $columns);

                // label
                $labels = [
                    'id' => '識別碼',
                    'photo' => '檔案視圖',
                    'name' => '檔案檔名',
                    'description' => '檔案描述',
                    'date' => '檔案上傳日期'
                ];
                if (!$this->get('noLevel')) {
                    $labels['level'] = '密等';
                }
                $this->set('labels', $labels);

                // field
                $this->set('fields', [
                    'id' => Input::make()->type('hidden'),
                    'photo' => Thumbnail::make(),
                    'name' => Label::make(),
                    'date' => Label::make(),
                ]);
                $fields = $this->get('fields');

                $this->set('invisible', [
                    'id',
                ]);
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
            })

            // --------------
            //   5 賦與 routing 參數
            // ---------------
            ->addBeforeRender(function () {
                $name = 'platform.file.upload';

                $params = [];
                array_push($params, $this->get('model'));
                array_push($params, $this->get('group'));

                if ($this->get('thisId') === null) {
                    $this->set('thisId', 0);
                }
                array_push($params, $this->get('thisId'));

                $this->set('formAction', route($name, $params));
                $this->set('urlParameters', implode(', ', $params));
                $this->set('formMethod', 'post');
            });
    }

    /**
     * @return Field|MatrixEx
     */
    public function maxRows(int $count)
    {
        return $this->set('maxRows', $count);
    }

    /**
     * @return Field|MatrixEx
     */
    public function initRows(int $count)
    {
        return $this->set('initRows', $count);
    }

    /**
     * @return Field|MatrixEx
     */
    public function draggableRows(bool $value = true)
    {
        return $this->set('draggableRows', $value);
    }

    /**
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
    // public function fields(array $fields = []): self
    // {
    //     return $this->set('fields', $fields);
    // }

    /**
     * @return $this
     */
    // public function labels(array $labels = []): self
    // {
    //     return $this->set('labels', $labels);
    // }

    protected function getIdPrefix(): string
    {
        $idPrefix = $this->get('idPrefix');

        if ($idPrefix !== null) {
            return (string) $idPrefix;
        }

        $slug = str_replace('.', '-', $this->getOldName());

        return "matrix-field-$slug";
    }

    // public function route(string $name, array $params = [], $method = 'post')
    // {
    //     $name = 'platform.file.upload';
    //     array_push($params, $this->get('groups'));

    //     $this->set('formAction', route($name, $params));
    //     $this->set('urlParameters', implode(", ", $params));

    //     return $this->set('formMethod', $method);
    // }
}

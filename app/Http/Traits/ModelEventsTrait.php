<?php

namespace App\Http\Traits;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * Trait ModelEventsTrait.
 */
trait ModelEventsTrait
{
    /**
     * create log
     */


    /**
     * listen log
     */
    public function listenLog($activity, $model)
    {
        if ($model->exists === true) {
            // 註冊 saving 事件
            $array = static::bootModelEventsTrait($model);
            // debug(json_encode($array));
            $activity->properties = $array;
        } else {
            $activity->properties = ['info' => ['ip' => Request::clientIp()]];
        }

        return $activity;
    }

    /**
     * update log properties
     */
    public function updateLogProperties($activity, $model = null)
    {
        $info = [];
        $info['ip'] = Request::clientIp();

        if (!is_null($model)) {
            $info['code'] = $model->code;
            $info['name'] = $model->name;
        }

        $activity->properties = ['info' => $info];

        return $activity;
    }

    /**
     * update log
     */
    public function updateLog($activity, $result, $model = null)
    {
        if (!is_null($model)) {
            $activity->subject_id = $model->id;
        }

        $activity->result = $result;
        $activity->save();
    }

    /**
     * 註冊事件監聽器，用於執行存檔前後的操作
     */
    public static function bootModelEventsTrait($model)
    {
        // 取得異動前的屬性值
        $original = $model->getOriginal();
        // debug($original);

        // 取得異動後的屬性值
        $dirty = $model->getDirty();
        // debug($dirty);

        // 記錄異動前後的屬性值
        $beforeSave = [];
        $afterSave = [];
        foreach ($dirty as $field => $new) {
            $old = $original[$field];
            // 將 $field, $old, $new 紀錄到你所需要的地方，例如 activity_log
            // debug('欄位: ' . $field .', 舊值: ' . $old .', 新值: ' . $new);

            // 檢查字串是否符合指定的日期時間格式
            if (!is_array($old) && Carbon::hasFormat($old, 'Y-m-d H:i:s')) {
                $carbonDate = Carbon::parse($old);
                $old = $carbonDate->format('Y-m-d H:i:s');
            }

            $beforeSave[$field] = $old;
            $afterSave[$field] = $new;
        }

        $data = [
            'info' => ['ip' => Request::clientIp()],
            'attributes' => $afterSave,
            'old' => $beforeSave,
        ];

        return $data;
    }
}

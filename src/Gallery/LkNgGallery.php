<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 22.05.17
 * Time: 13:27
 */

namespace Larakit\Gallery;

use Illuminate\Support\Arr;
use Larakit\Thumb\Thumb;

class LkNgGallery {
    protected static $configs = [];

    static function registerModel($model_class, $config) {
        \Route::model(class_basename($model_class), $model_class);
        self::$configs[$model_class] = $config;
    }

    static function models() {
        return array_keys(self::$configs);
    }

    static function types($model) {
        $model_class = get_class($model);

        return Arr::get(self::$configs, $model_class);
    }

    /**
     * @param $model
     * @param $type
     *
     * @return Thumb
     */
    static function thumb($model, $type) {
        $model_class = get_class($model->galleriable);
        $thumb_class = Arr::get(self::$configs, $model_class . '.' . $type);

        return new $thumb_class($model->id);
    }

}

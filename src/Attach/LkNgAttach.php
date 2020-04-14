<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 22.05.17
 * Time: 13:27
 */

namespace Larakit\Attach;

use Illuminate\Support\Arr;

class LkNgAttach {
    protected static $configs = [];

    static function registerModel($model_class, $config) {
        self::$configs[$model_class] = $config;
    }

    static function models() {
        return array_keys(self::$configs);
    }

    static function types($model) {
        $model_class = get_class($model);

        return Arr::get(self::$configs, $model_class);
    }

    static function config($model_class, $type) {
        return Arr::get(self::$configs, $model_class . '.' . $type);
    }

}

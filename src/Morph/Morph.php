<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Morph;

/**
 * Class Morph
 * @package Larakit\Morph
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class Morph {
    static $model_classes = [];

    static function registerModelClass($model_class) {
        if(!in_array($model_class, self::$model_classes)){
            self::$model_classes[] = $model_class;
        }
    }

    static function reverseModel($hash) {
        return config('larakit-morph.' . $hash);
    }

    static function hashDecode($morph) {
        $morph       = explode('-', $morph);
        $model_class = self::reverseModel(\Illuminate\Support\Arr::get($morph, 0));
        $id          = \Illuminate\Support\Arr::get($morph, 1);
        $id          = hashids_decode($id);
        $id          = $id[0];
        if ($model_class && $id) {
            $d = new $model_class();

            return $model_class::find($id);

            return [
                'class' => $model_class,
                'id'    => $id,
            ];
        }

    }

    static function hashEncode($model_name, $model_id) {
        $hashes = config('larakit-morph');
        $hash   = array_search($model_name, $hashes);
        if (!$hash) {
            throw new \Exception('Неизвестная сущность');
        }

        return $hash . '-' . hashids_encode($model_id);
    }

    static function hashEncodeByModel($model) {
        $model_name = get_class($model);
        $model_id   = $model->id;

        return self::hashEncode($model_name, $model_id);
    }
}

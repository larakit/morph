<?php

namespace Larakit\Controllers;

use Illuminate\Support\Arr;
use Larakit\Gallery\LkNgGallery;
use Larakit\MorphGallery;
use Larakit\Resource\HelperThumbs;
use Larakit\Thumb\LkNgThumb;

class AppThumbController extends ApiController {
    function thumbs($model) {
        $model->is_thumb_hashed = true;
        $res                    = HelperThumbs::factory($model);
        if (get_class($model) == MorphGallery::class) {
            $config = Arr::only(LkNgGallery::types($model->galleriable), [$model->block]);
            $res->setThumbConfig($config);
        }

        return $this->apiResponseSuccess($res->toArray());
    }

    function thumbsTypeUpload($model, $type) {
        $model->touch();
        if (get_class($model) == MorphGallery::class) {
            $thumb = LkNgGallery::thumb($model, $type);
        } else {
            $thumb = LkNgThumb::thumb($model, $type);
        }
        try{
            $thumb->processing(\Request::file('file'));
            $model->is_thumb_hashed = true;
            $res                    = HelperThumbs::factory($model);
            if (get_class($model) == MorphGallery::class) {
                $config = Arr::only(LkNgGallery::types($model->galleriable), [$type]);
                $res->setThumbConfig($config)
                    ->setGateModel($model->galleriable);
                $model->galleriable->touch();
            }
            return $this->apiResponseSuccess($res->toArray(), __('vendor.gallery.toastr.thumbsTypeUpload'));
        } catch (\Exception $e){
            return $this->apiResponseWarning(null, $e->getMessage());
        }
    }

    function thumbsTypeClear($model, $type) {
        if (get_class($model) == MorphGallery::class) {
            $thumb = LkNgGallery::thumb($model, $type);
        } else {
            $thumb = LkNgThumb::thumb($model, $type);
        }
        $thumb->delete();

        return $this->apiResponseSuccess(null, __('vendor.gallery.toastr.thumbsTypeClear'));
    }

    function thumbsTypeSizeCrop($model, $type, $size) {
        if (get_class($model) == MorphGallery::class) {
            $thumb = LkNgGallery::thumb($model, $type);
        } else {
            $thumb = LkNgThumb::thumb($model, $type);
        }

        $file_original = $thumb->makePath();
        $crop          = \Image::make($file_original);
        $file_thumb    = $thumb->makePath($size);
        $x             = (int) \Request::input('x');
        $y             = (int) \Request::input('y');
        $crop_w        = (int) \Request::input('width');
        $crop_h        = (int) \Request::input('height');
        $rotate        = (int) \Request::input('rotate');
        $crop_x_left   = ($x < 0) ? 0 : $x;
        $crop_y_top    = ($y < 0) ? 0 : $y;
        $crop_x_right  = min($crop->width(), $crop_w + $x);
        $crop_y_bottom = min($crop->height(), $crop_h + $y);
        $thumb_w       = $crop_x_right - $crop_x_left;
        $thumb_h       = $crop_y_bottom - $crop_y_top;
        $crop->rotate(0 - $rotate)
             ->crop($thumb_w, $thumb_h, $crop_x_left, $crop_y_top);

        $bg       = \Image::canvas($crop_w, $crop_h, null);
        $offset_x = ($x < 0) ? abs($x) : 0;
        $offset_y = ($y < 0) ? abs($y) : 0;
        $bg->insert($crop, 'top-left', $offset_x, $offset_y);
        $bg->save($file_thumb);

        if ($thumb->processingSize($file_thumb, $size)) {
            return [
                'result'  => 'success',
                'message' => __('vendor.gallery.toastr.loaded'),
            ];
        }

        return $this->apiResponseSuccess(null, __('vendor.gallery.toastr.thumbsTypeSizeCrop'));
    }
}


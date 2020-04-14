<?php

namespace Larakit\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Larakit\MorphGallery;
use Larakit\Resource\HelperGallery;

class AppGalleryController extends ApiController {

    /**
     * Сортировка элементов галереи
     *
     * @param $model
     * @param $block
     *
     * @return array
     */
    function blockDnd($model, $block) {
        $ids           = \Request::input('ids');
        $ids           = array_map('intval', $ids);
        $ids           = array_flip($ids);
        $cnt           = count($ids) - 1;
        $gallery_items = MorphGallery::where('block', '=', $block)//            ->whereIn('ids', $ids)
                                         ->where('galleriable_type', '=', $model->getMorphClass())
                                         ->where('galleriable_id', '=', $model->id)
                                         ->get();
        foreach ($gallery_items as $gallery_item) {
            $gallery_item->priority = $cnt - Arr::get($ids, $gallery_item->id);
            $gallery_item->save();
        }
        $model_class = $model->getMorphClass();
        $model       = $model_class::find($model->id);

        return $this->apiResponseSuccess(HelperGallery::toArray($model), __('vendor.gallery.toastr.blockDnd'));
    }

    function blockClear($model, $block) {
        $gallery_items = MorphGallery::where('block', '=', $block)//            ->whereIn('ids', $ids)
                                         ->where('galleriable_type', '=', $model->getMorphClass())
                                         ->where('galleriable_id', '=', $model->id)
                                         ->get();
        foreach ($gallery_items as $gallery_item) {
            $gallery_item->delete();
        }

        return $this->apiResponseSuccess(HelperGallery::toArray($model), __('vendor.gallery.toastr.blockClear'));
    }

    function blockUpload($model, $block) {
        $model->touch();
        $cnt         = MorphGallery::where('galleriable_id', '=', $model->id)
                                       ->where('galleriable_type', '=', $model->getMorphClass())
                                       ->where('block', '=', $block)
                                       ->count();
        $o           = MorphGallery::create([
            'galleriable_id'   => $model->id,
            'galleriable_type' => $model->getMorphClass(),
            'block'            => $block,
            'priority'         => $cnt + 1,
        ]);
        $types       = \Larakit\Gallery\LkNgGallery::types($model);
        $thumb_class = \Illuminate\Support\Arr::get($types, $block);
        if (class_exists($thumb_class)) {
            $thumb = new $thumb_class($o->id);
            if (\Request::has('base64')) {
                $source = \Request::input('base64');
            } else {
                $source = \Request::file('file');
            }
            try {
                $thumb->processing($source);
                $model_class = $model->getMorphClass();
                $model       = $model_class::find($model->id);

                return $this->apiResponseSuccess(HelperGallery::toArray($model), __('vendor.gallery.toastr.blockUpload'));
            }
            catch (\Throwable $e) {
                $o->delete();

                return $this->apiResponseError(null, $e->getMessage());
            }
        }
    }

    function update($model) {
        $model->fill(\Request::only(['name', 'desc', 'priority']));
        $model->save();
        $galleriable = $model->galleriable;
        $model_class = get_class($galleriable);
        $galleriable = $model_class::with('morph_galleries')
                                   ->find($galleriable->id);

        return $this->apiResponseSuccess(HelperGallery::toArray($galleriable), __('vendor.gallery.toastr.update'));
    }

    function delete($model, Request $request) {
        $galleriable = $model->galleriable;
        $model_class = get_class($galleriable);
        //        dd($model_class);
        $model->delete();
        $galleriable = $model_class::with('morph_galleries')
                                   ->find($galleriable->id);

        return $this->apiResponseSuccess(HelperGallery::toArray($galleriable), __('vendor.gallery.toastr.delete'));
    }

}

<?php

namespace Larakit\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Larakit\Attach\Attach;
use Larakit\Attach\LkNgAttach;
use Larakit\MorphAttach;
use Larakit\MorphGallery;
use Larakit\Resource\HelperAttach;
use Larakit\Resource\HelperGallery;

class AppAttachController extends ApiController {

    /**
     * Сортировка элементов галереи
     *
     * @param $model
     * @param $block
     *
     * @return array
     */
    function blockDnd($model, $block) {
        $ids          = \Request::input('ids');
        $ids          = array_map('intval', $ids);
        $ids          = array_flip($ids);
        $cnt          = count($ids) - 1;
        $attach_items = MorphAttach::where('block', '=', $block)//            ->whereIn('ids', $ids)
                                       ->where('attachable_type', '=', $model->getMorphClass())
                                       ->where('attachable_id', '=', $model->id)
                                       ->get();
        foreach ($attach_items as $attach_item) {
            $attach_item->priority = $cnt - Arr::get($ids, $attach_item->id);
            $attach_item->save();
        }
        $model_class = $model->getMorphClass();
        $model       = $model_class::find($model->id);

        return $this->apiResponseSuccess(HelperAttach::toArray($model), __('vendor.attach.toastr.blockDnd'));
    }

    function blockUpload($model, $block) {
        $file   = \Request::file('file');
        $model->addMorphAttach($file, $block);
        return $this->apiResponseSuccess(HelperAttach::toArray($model), __('vendor.attach.toastr.blockUpload'));
    }

    function update($model) {
        $model->fill(\Request::only(['name', 'priority']));
        $model->save();
        $attachable  = $model->attachable;
        $model_class = get_class($attachable);
        $attachable  = $model_class::with('morph_attaches')
                                   ->find($attachable->id);

        return $this->apiResponseSuccess(HelperAttach::toArray($attachable), __('vendor.attach.toastr.update'));
    }

    function download($model) {
        $path = Attach::makePath($model);

        return \Response::download($path, $model->name . '.' . $model->ext);
    }

    function upload_max_filesize() {
        $value = min(
            return_bytes(ini_get('upload_max_filesize')),
            return_bytes(ini_get('post_max_size'))
        );
        return \Larakit\Helpers\HelperText::fileSize($value);
    }
    function delete($model, Request $request) {
        $attachable  = $model->attachable;
        $model_class = get_class($attachable);
        //        dd($model_class);
        $model->delete();
        $attachable = $model_class::with('morph_attaches')
                                  ->find($attachable->id);

        return $this->apiResponseSuccess(HelperAttach::toArray($attachable), __('vendor.attach.toastr.delete'));
    }

}

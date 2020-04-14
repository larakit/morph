<?php

namespace Larakit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Larakit\Attach\LkNgAttach;
use Larakit\Resource\HelperAttach;

trait TraitModelMorphAttach {

    public function morph_attaches() {
        return $this->morphMany(MorphAttach::class, 'attachable')
                    ->orderBy('priority', 'desc');
    }

    function addMorphAttach($file, $block) {
        if (is_string($file)) {
            $file = new UploadedFile($file, pathinfo($file, PATHINFO_BASENAME));
        }
        $config = LkNgAttach::config(get_class($this), $block);
        $max    = (int) Arr::get($config, 'max');
        //если указано максимальное количество
        if ($max) {
            $cnt = MorphAttach::where('attachable_id', '=', $this->id)
                              ->where('attachable_type', '=', $this->getMorphClass())
                              ->where('block', '=', $block)
                              ->count();
            if ($cnt >= $max) {
                throw new \Exception(__('vendor.attach.toastr.limit'));
            }
        }
        try {
            $o       = MorphAttach::create([
                'attachable_id'   => $this->id,
                'attachable_type' => $this->getMorphClass(),
                'block'           => $block,
                'priority'        => 0,
            ]);
            $ext     = $file->getClientOriginalExtension();
            $o->name = str_replace('.' . $ext, '', $file->getClientOriginalName());
            $o->ext  = $ext;
            $o->size = $file->getSize();
            $o->save();
            $path = $o->makePath();
            $dir  = dirname($path);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
        catch (\Exception $e) {
            $o->delete();
            throw new \Exception('Нет прав на запись в директорию вложений');
        }
        if(!copy($file->path(),$path)){
            throw new \Exception(__('vendor.attach.toastr.error'));
        }
    }

}

<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 14.06.17
 * Time: 14:10
 */

namespace Larakit;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait TraitModelMorphGallery {

    protected $is_gallery_hashed = false;

    function galleryHashed() {
        $this->is_gallery_hashed = true;
    }

    public function morph_galleries() {
        return $this->morphMany(MorphGallery::class, 'galleriable')
                    ->orderBy('priority', 'desc');
    }

}

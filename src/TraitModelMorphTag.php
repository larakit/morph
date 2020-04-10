<?php

namespace Larakit;

use Larakit\Tags\Tag;

/**
 * Class TraitModelMorphTag
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphTag {
    public function morph_tags() {
        return $this->morphToMany(Tag::class,
            'tagable',
            'morph_tags');
    }
}

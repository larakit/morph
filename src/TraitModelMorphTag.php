<?php

namespace Larakit;

use Larakit\Tag;

/**
 * Class TraitModelMorphTag
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphTag {
    public function morph_tags() {
        return $this->morphToMany(Tag::class, 'tagable', 'morph_tags');
    }

    function tagsRequest() {
        return (array) \Request::input('morph_tags');
    }

    function tagsSave($tags = []) {
        if (!$tags) {
            $tags = $this->tagsRequest();
        }
        $this->morph_tags()
             ->detach();
        $ids = [];
        foreach ($tags as $tag) {
            $tag = \Illuminate\Support\Arr::get($tag, 'toString');
            if ($tag) {
                $tag_model = \Larakit\Tag::firstOrCreate([
                    'name' => $tag,
                ]);
                $ids[]     = $tag_model->id;
            }
        }
        if (count($ids)) {
            $this->morph_tags()
                 ->sync($ids);
        }
    }
}

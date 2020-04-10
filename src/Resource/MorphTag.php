<?php

namespace Larakit\Resource;

use Larakit\Resource\JsonResource;

class MorphTag extends JsonResource {

    public function _toArray() {
        return [
            'id'            => $this->id,
            'taggable_id'   => (int) $this->taggable_id,
            'taggable_type' => $this->taggable_type,
            'tag'           => $this->tag ? $this->tag->name : '',
            'tag_id'        => (int) $this->tag_id,
        ];
    }
}

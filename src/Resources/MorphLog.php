<?php

namespace Larakit\Resources;

use Larakit\Resource\JsonResource;

class MorphLog extends JsonResource {

    public function _toArray() {
        $this->resource->load('user');

        return [
            'id'           => $this->id,
            'logable_id'   => (int) $this->logable_id,
            'logable_type' => $this->logable_type,
            'comment'      => $this->comment,
            'user_id'      => (int) $this->user_id,
            'user_name'    => $this->user ? $this->user->name : 'Robot',
        ];
    }
}

<?php

namespace Larakit\Resource;

use Larakit\Resource\JsonResource;

class MorphLog extends JsonResource {
    protected $except = ['_hash_'];

    public function _toArray() {
        $this->resource->load('user');

        return [
            'id'         => $this->id,
            //            'logable_id'   => (int) $this->logable_id,
            //            'logable_type' => $this->logable_type,
            'comment'    => $this->comment,
            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
            'time'       => $this->created_at->format('H:i:s'),
            'date'       => $this->created_at->format('d.m.Y'),
            'user_id'    => (int) $this->user_id,
            'user_name'  => $this->user ? $this->user->name : 'Robot',
        ];
    }
}

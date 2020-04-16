<?php

namespace Larakit\Resource;

use Larakit\Resource\JsonResource;

class MorphComment extends JsonResource {
    protected $except = ['_hash_'];

    public function _toArray() {
        $this->resource->load('author');

        return [
            'id'               => $this->id,
            'comment'          => $this->comment,
            'path'             => $this->path,
            'timestamp'        => $this->created_at->format('GMT'),
            'created_at'       => $this->created_at->format('d.m.Y H:i:s'),
            'time'             => $this->created_at->format('H:i:s'),
            'date'             => $this->created_at->format('d.m.Y'),
            'level'            => count(explode('.', $this->path)),
            'author_id'        => $this->author ? $this->author->id : null,
            'author_name'      => $this->author ? $this->author->name : 'Robot',
            'is_comment'       => false,
            'is_show_children' => true,
        ];
    }
}

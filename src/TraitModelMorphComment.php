<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphComment {
    public function morph_comments() {
        return $this->morphMany(MorphComment::class, 'logable')
                    ->orderBy('id', 'desc');
    }

    function addMorphComment($comment, $author_id = null) {
        if (!$author_id) {
            $author_id = me('id');
        }
        $log = new MorphComment([
            'comment'          => $comment,
            'author_id'        => $author_id,
            'parent_id'        => 0,
            'commentable_id'   => $this->id,
            'commentable_type' => $this->getMorphClass(),
            'path',
        ]);
        $model->morph_logs()
              ->save($log);

    }
}

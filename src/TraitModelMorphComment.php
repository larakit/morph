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

    function makePath($id, $parent_id = 0) {
    }

    function addMorphComment($comment, $parent_id = 0, $author_id = null) {
        $parent_id = 14;
        if (!$author_id) {
            $author_id = me('id');
        } else {
            $author_id = me('id') ? me('id') : 0;
        }
        $comment = MorphComment::create([
            'comment'          => $comment,
            'author_id'        => $author_id,
            'ip'               => $author_id ? null : \Request::ip(),
            'parent_id'        => 0,
            'commentable_id'   => $this->id,
            'commentable_type' => $this->getMorphClass(),
        ]);
        $path    = [];
        //проверяем что родительский коммент комментрирует ту же сущность
        $parent = MorphComment::find($parent_id);
        if($parent){
            if(($parent->commentable_id == $comment->commentable_id) && ($parent->commentable_type == $comment->commentable_type)){
                $path[]  = str_pad($parent->id, 10, '_',STR_PAD_LEFT);
            }
        }
        $path[]  = str_pad($comment->id, 10, '_', STR_PAD_LEFT);
        $comment->path  = implode('.', $path);
        $comment->save();

    }
}

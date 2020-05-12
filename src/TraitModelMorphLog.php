<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphLog {
    public function morph_logs() {
        return $this->morphMany(MorphLog::class, 'logable')
                    ->orderBy('id', 'desc')
            ;
    }

    function addMorphLog($comment, $user_id = null) {
        if (!$user_id) {
            $user_id = me('id');
        }
        $log = new MorphLog([
            'comment' => $comment,
            'user_id' => $user_id,
        ]);
        $this->morph_logs()
             ->save($log)
        ;

    }

}

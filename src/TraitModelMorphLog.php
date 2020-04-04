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
}

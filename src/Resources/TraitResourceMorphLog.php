<?php

namespace Larakit\Resources;


/**
 * Trait TraitResourceColorize
 * @package Larakit\Resource
 * @property integer $id
 */
trait TraitResourceMorphLog {

    function bootTraitResourceMorphLog($ret) {
        $ret['morph_logs'] = new MorphLogCollection($this->morph_logs);

        return $ret;
    }
}

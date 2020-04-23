<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphView {
    public function morph_view() {
        $q = $this->morphOne(MorphView::class, 'viewedable');
        if (me('id')) {
            $q->where('usr_id', '=', me('id'));
        } else {
            $q->where('ip', '=', \Request::ip());
        }

        return $q;
    }
}

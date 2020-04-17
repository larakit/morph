<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphPlusminus {
    public function morph_plusminus_me() {
        $q = $this->morphOne(MorphPlusminusItem::class, 'plusminusable');
        if (me('id')) {
            $q->where('usr_id', '=', me('id'));
        } else {
            $q->where('ip', '=', \Request::ip());
        }

        return $q;
    }

    public function morph_plusminus() {
        return $this->morphOne(MorphPlusminus::class, 'plusminusable');
    }

    function addMorphPlusminus($value) {
        $value = (float) $value;
        $value = min($value, 1);
        $value = max($value, -1);
        $item  = MorphPlusminusItem::firstOrCreate([
            'plusminusable_id'   => $this->id,
            'plusminusable_type' => $this->getMorphClass(),
            'usr_id'             => me('id') ? me('id') : 0,
            'ip'                 => me('id') ? null : \Request::ip(),
        ]);
        if ($value == $item->rate) {
            $item->delete();
            $result = 'Оценка удалена';
        } else {
            $item->rate = $value;
            $item->save();
            $result = 'Оценка записана';
        }
        $rate_sum_minus       = MorphPlusminusItem::where('plusminusable_id', '=', $this->id)
                                                  ->where('plusminusable_type', '=', $this->getMorphClass())
                                                  ->where('rate', '=', -1)
                                                  ->sum('rate');
        $rate_sum_plus        = MorphPlusminusItem::where('plusminusable_id', '=', $this->id)
                                                  ->where('plusminusable_type', '=', $this->getMorphClass())
                                                  ->where('rate', '=', 1)
                                                  ->sum('rate');
        $rate                 = MorphPlusminus::firstOrCreate([
            'plusminusable_id'   => $this->id,
            'plusminusable_type' => $this->getMorphClass(),
        ]);
        $rate->rate_sum_plus  = (float) $rate_sum_plus;
        $rate->rate_sum_minus = (float) $rate_sum_minus;
        $rate->save();

        return $result;

    }

}

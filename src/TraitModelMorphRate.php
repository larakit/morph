<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphRate {
    public function morph_rate_me() {
        $q = $this->morphOne(MorphRateItem::class, 'rateable');
        if (me('id')) {
            $q->where('usr_id', '=', me('id'));
        } else {
            $q->where('ip', '=', \Request::ip());
        }

        return $q;
    }

    public function morph_rate() {
        return $this->morphOne(MorphRate::class, 'rateable');
    }

    function addMorphRate($value) {
        $value = (float) $value;
        $value = min($value, 5);
        $value = max($value, 0);
        $item  = MorphRateItem::firstOrCreate([
            'rateable_id'   => $this->id,
            'rateable_type' => $this->getMorphClass(),
            'usr_id'        => me('id') ? me('id') : 0,
            'ip'            => me('id') ? null : \Request::ip(),
        ]);
        if ($value) {
            $item->rate = $value;
            $item->save();
            $result = 'Оценка записана';
        } else {
            $item->delete();
            $result = 'Оценка удалена';
        }
        $rate_avg       = MorphRateItem::where('rateable_id', '=', $this->id)
                                       ->where('rateable_type', '=', $this->getMorphClass())
                                       ->avg('rate');
        $rate           = MorphRate::firstOrCreate([
            'rateable_id'   => $this->id,
            'rateable_type' => $this->getMorphClass(),
        ]);
        $rate->rate_avg = (float)$rate_avg;
        $rate->save();

        return $result;
    }
}

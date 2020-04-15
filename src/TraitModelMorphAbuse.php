<?php

namespace Larakit;

/**
 * Class TraitModelMorphLog
 *
 * @package Larakit
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
trait TraitModelMorphAbuse {

    public function morph_moderate() {
        return $this->morphOne(MorphModerate::class, 'moderateable');
    }

    public function morph_abuse_me() {
        $q = $this->morphOne(MorphAbuse::class, 'abuseable');
        if (me('id')) {
            $q->where('usr_id', '=', me('id'));
        } else {
            $q->where('ip', '=', \Request::ip());
        }

        return $q;
    }

    public function morph_abuses() {
        return $this->morphMany(MorphAbuse::class, 'abuseable');
    }

    function addMorphAbuse() {
        $item = MorphAbuse::firstOrNew([
            'abuseable_id'   => $this->id,
            'abuseable_type' => $this->getMorphClass(),
            'usr_id'         => me('id') ? me('id') : 0,
            'ip'             => me('id') ? null : \Request::ip(),
        ]);
        if ($item->id) {
            $item->delete();
            $result = 'Ваша жалоба удалена';
        } else {
            $item->save();
            $result = 'Ваша жалоба зарегистрирована';
        }
        MorphModerate::firstOrCreate([
            'moderateable_id'   => $this->id,
            'moderateable_type' => $this->getMorphClass(),
        ]);

        return $result;
    }

}

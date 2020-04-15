<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphAbuse extends Model {
    protected $table    = 'morph_abuses';
    protected $fillable = [
        'ip',
        'usr_id',
        'abuseable_id',
        'abuseable_type',
    ];

    public function abuseable() {
        return $this->morphTo();
    }

}

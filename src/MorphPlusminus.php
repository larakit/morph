<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphPlusminus extends Model {
    protected $table    = 'morph_plusminuses';
    protected $fillable = [
        'rate_sum',
        'plusminusable_id',
        'plusminusable_type',
    ];

    public function plusminusable() {
        return $this->morphToMany();
    }

}

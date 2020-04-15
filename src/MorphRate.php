<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphRate extends Model {
    protected $table    = 'morph_rates';
    protected $fillable = [
        'rate_avg',
        'rateable_id',
        'rateable_type',
    ];

    public function rateable() {
        return $this->morphToMany();
    }

}

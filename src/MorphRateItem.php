<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphRateItem extends Model {
    protected $table = 'morph_rate_items';

    protected $fillable = [
        'ip',
        'usr_id',
        'rate',
        'rateable_id',
        'rateable_type',
    ];

    public function rateable() {
        return $this->morphToMany();
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

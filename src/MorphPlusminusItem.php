<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphPlusminusItem extends Model {
    protected $table = 'morph_plusminus_items';

    protected $fillable = [
        'ip',
        'usr_id',
        'rate',
        'plusminusable_id',
        'plusminusable_type',
    ];

    public function plusminusable() {
        return $this->morphToMany();
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

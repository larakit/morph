<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphLog extends Model {
    protected $table    = 'morph_logs';
    protected $fillable = [
        'logable_id',
        'logable_type',
        'comment',
        'user_id',
    ];

    public function logable() {
        return $this->morphTo();
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

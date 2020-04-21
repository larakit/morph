<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphView extends Model {
    protected $table    = 'morph_views';
    protected $fillable = [
        'viewedable_id',
        'viewedable_type',
    ];

    public function viewedable() {
        return $this->morphTo();
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

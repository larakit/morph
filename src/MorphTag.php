<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphTag extends Model {
    protected $table    = 'morph_tags';
    protected $fillable = [
        'tag_id',
        'tagable_id',
        'tagable_type',
    ];

    public function taggable() {
        return $this->morphToMany();
    }

    function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

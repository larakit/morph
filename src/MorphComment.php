<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphComment extends Model {
    protected $table    = 'morph_comments';
    protected $fillable = [
        'comment',
        'author_id',
        'ip',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'path',
    ];

    public function commentable() {
        return $this->morphTo();
    }

    function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

}

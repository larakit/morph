<?php

namespace Larakit;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MorphModerate extends Model {
    protected $table    = 'morph_moderates';
    protected $fillable = [
        'result',
        'moderateable_id',
        'moderateable_type',
    ];

    public function moderateable() {
        return $this->morphTo();
    }

}

<?php

namespace Larakit;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    protected $table    = 'tags';
    protected $fillable = [
        'name',
    ];

    public $tagable_class;

    static function forModel($model_class_name) {
        $ret                = new Tag();
        $ret->tagable_class = $model_class_name;

        return $ret;
    }

    public function models() {
        return $this->morphedByMany($this->tagable_class, 'tagable', 'morph_tags');
    }

}

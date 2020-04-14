<?php
/**
 * Created by PhpStorm.
 * User: aberdnikov
 * Date: 29.08.2017
 * Time: 16:42
 */

namespace Larakit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Larakit\Thumb\TraitModelThumb;

class MorphGallery extends Model {

    use TraitModelThumb;

    protected $connection = 'mysql';

    protected $table = 'morph_galleries';

    protected $fillable = [
        'galleriable_id',
        'galleriable_type',
        'block',
        'name',
        'priority',
        'desc',
    ];

    public function galleriable() {
        return $this->morphTo()->withTrashed();
    }
}

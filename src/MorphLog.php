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

    static function addLog($model, $comment, $user_id = null) {
        if (!$user_id) {
            $user_id = me('id');
        }
        $log = new MorphLog([
            'comment' => $comment,
            'user_id' => $user_id,
        ]);
        $model->morph_logs()
              ->save($log)
        ;

    }
}

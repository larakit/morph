<?php

namespace Larakit\Controllers;

use App\Http\Resources\User;
use Illuminate\Support\Arr;
use Larakit\Resource\MorphComment;

class AppMorphCommentController extends ApiController {
    function dropKey($arr) {
        $ret = [];
        foreach ($arr as $k => $v) {
            if ('items' != $k) {
                $ret[$k] = $v;
            } else {
                foreach ($v as $v_item) {
                    $ret['items'][] = $this->dropKey($v_item);
                }
            }
        }

        return $ret;
    }

    function response($morph, $message = null) {
        try {
            $morph->loadCount('morph_comments');
            $comments = [];
            foreach ($morph->morph_comments as $morph_comment) {
                $path          = $morph_comment->path;
                $path          = 'items.' . str_replace('.', '.items.', $path);
                $morph_comment = new MorphComment($morph_comment);
                $morph_comment = resource_to_array($morph_comment);
                Arr::set($comments, $path, $morph_comment);
            }

            return [
                'data'    => [
                    'comments' => $comments ? $this->dropKey($comments) : ['items' => []],
                    'me'       => new User(me()),
                ],
                'result'  => 'success',
                'message' => $message,
            ];
        }
        catch (\Exception $e) {
            return [
                'result'  => 'error',
                'data'    => [
                    'me'  => 0,
                    'all' => 0,
                ],
                'message' => $e->getMessage(),
            ];
        }
    }

    function get($morph) {
        return $this->response($morph);
    }

    function set($morph) {
        $comment   = \Request::input('comment');
        $parent_id = (int) \Request::input('parent_id');
        if (!$comment) {
            throw new \Exception('Нет текста комментария');
        }
        $model = $morph->addMorphComment($comment, $parent_id);

        return [
            'data'    => new MorphComment($model),
            'result'  => 'success',
            'message' => 'Комментарий успешно добавлен',
        ];
    }

}

<?php

namespace Larakit\Controllers;

use Illuminate\Support\Arr;
use Larakit\Resource\MorphComment;

class AppMorphCommentController extends ApiController {
    function response($morph, $message = null) {
        try {

            $morph->loadCount('morph_comments');
            $comments = [];
            foreach ($morph->morph_comments as $morph_comment) {
                $path = $morph_comment->path;
                $path = 'items.'.str_replace('.', '.items.', $path);
                $morph_comment = new MorphComment($morph_comment);
                Arr::set($comments, $path,resource_to_array($morph_comment));
            }
            return [
                'data'    => [
                    'comments' => $comments,
                    'me'       => me(),
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
        $result = $morph->addMorphComment();
        $morph->refresh();

        return $this->response($morph, $result);
    }

}

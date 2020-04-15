<?php

namespace Larakit\Controllers;

class AppMorphAbuseController extends ApiController {
    function response($morph, $message = null) {
        try {

            $morph->loadCount('morph_abuses')
                  ->load('morph_abuse_me')
                  ->load('morph_moderate');

            return [
                'data'    => [
                    'morph_moderate'     => $morph->morph_moderate ? $morph->morph_moderate->result : 0,
                    'morph_abuse_me'     => $morph->morph_abuse_me ? true : false,
                    'morph_abuses_count' => $morph->morph_abuses_count ? $morph->morph_abuses_count : 0,
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
        $result = $morph->addMorphAbuse();
        $morph->refresh();

        return $this->response($morph, $result);
    }

}

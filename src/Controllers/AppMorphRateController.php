<?php

namespace Larakit\Controllers;

class AppMorphRateController extends ApiController {
    function response($morph) {
        try {
            $morph->load('morph_rate_me');
            $morph->load('morph_rate');

            return [
                'data'   => [
                    'me'  => $morph->morph_rate_me ? $morph->morph_rate_me->rate : 0,
                    'all' => $morph->morph_rate ? $morph->morph_rate->rate_avg : 0,
                ],
                'result' => 'success',
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
        $value = \Request::input('rate');
        $morph->addMorphRate($value);
        $morph->refresh($value);
        return $this->response($morph);
    }

}

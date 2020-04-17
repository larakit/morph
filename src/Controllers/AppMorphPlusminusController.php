<?php

namespace Larakit\Controllers;

class AppMorphPlusminusController extends ApiController {
    function response($morph, $message = null) {
        try {
            $morph->load('morph_plusminus_me');
            $morph->load('morph_plusminus');
            $minus = abs($morph->morph_plusminus ? $morph->morph_plusminus->rate_sum_minus : 0);
            $plus  = abs($morph->morph_plusminus ? $morph->morph_plusminus->rate_sum_plus : 0);

            return [
                'data'    => [
                    'me'    => $morph->morph_plusminus_me ? $morph->morph_plusminus_me->rate : 0,
                    'minus' => $minus,
                    'plus'  => $plus,
                    'all'   => $plus - $minus,
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
        $value  = \Request::input('rate');
        $result = $morph->addMorphPlusminus($value);
        $morph->refresh();

        return $this->response($morph, $result);
    }

}

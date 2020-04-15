<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\Morph\Morph;
use Larakit\TraitModelMorphRate;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphRate extends ResourcePlugin {

    public function appendData($ret) {

        if (in_array(TraitModelMorphRate::class, $this->model_traits)) {
            $this->model->load('morph_rate_me');
            $ret['morph_rate_me']  = $this->model->morph_rate_me ? $this->model->morph_rate_me->rate : 0;
            $ret['morph_rate']     = $this->model->morph_rate ? $this->model->morph_rate->rate_avg : 0;
            $ret['morph_rate_url'] = route('api.morph_rate', [
                'Morph' => Morph::hashEncodeByModel($this->model),
            ], false);
        }

        return $ret;
    }

}

<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\Morph\Morph;
use Larakit\TraitModelMorphPlusminus;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphPlusminus extends ResourcePlugin {

    public function appendData($ret) {

        if (in_array(TraitModelMorphPlusminus::class, $this->model_traits)) {
            $ret['morph_plusminus_url'] = route('api.morph_plusminus', [
                'Morph' => Morph::hashEncodeByModel($this->model),
            ], false);
        }

        return $ret;
    }

}

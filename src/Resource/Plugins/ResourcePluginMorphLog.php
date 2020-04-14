<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\TraitModelMorphLog;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphLog extends ResourcePlugin {

    public function appendData($ret) {
        if (in_array(TraitModelMorphLog::class, $this->model_traits)) {
//            $this->model->load('morph_logs');
            if ($this->model->relationLoaded('morph_logs')) {
                $ret['morph_logs'] = \Larakit\Resource\MorphLog::collection($this->model->morph_logs);
            }
            //            $ret['morph_logs'] = \Larakit\Resource\MorphLog::collection($this->model->morph_logs()->paginate());
        }

        return $ret;
    }

}

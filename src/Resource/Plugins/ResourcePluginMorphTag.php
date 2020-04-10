<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\TraitModelMorphTag;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphTag extends ResourcePlugin {

    public function appendData($ret) {
        if (in_array(TraitModelMorphTag::class, $this->model_traits)) {
            $ret['morph_tags'] = [];
            foreach ($this->model->morph_tags as $tag) {
                $ret['morph_tags'][] = [
                    'id'       => $tag->id,
                    'toString' => $tag->name,
                ];
            }

        }

        return $ret;
    }

}

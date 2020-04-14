<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\Resource\HelperAttach;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphAttach extends ResourcePlugin {

    public function appendData($ret) {
        if (LkNgAttach::types($this->model)) {
            if ($this->model->relationLoaded('morph_attaches')) {
                $ret['morph_attaches'] = HelperAttach::toArray($this->model);
            }
        }

        return $ret;
    }

}

<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Gallery\LkNgGallery;
use Larakit\Resource\HelperGallery;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphGallery extends ResourcePlugin {

    public function appendData($ret) {
        if (LkNgGallery::types($this->model)) {
            if ($this->model->relationLoaded('morph_galleries')) {
                $ret['morph_galleries'] = HelperGallery::toArray($this->model);
                $ret['!']['galleries']  = HelperGallery::toArray($this->model, true);
            }
        }

        return $ret;
    }

}

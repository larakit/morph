<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\FormFilter\Plugins;

use Larakit\TraitModelMorphAttach;
use Larakit\TraitModelMorphGallery;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class FormFilterPluginMorphAttach extends FormFilterPlugin {

    public function before() {
        if (in_array(TraitModelMorphAttach::class, $this->model_traits)) {
            $this->formfilter->model->with('morph_attaches');
        }
    }

}

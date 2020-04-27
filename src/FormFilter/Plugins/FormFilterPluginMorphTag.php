<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\FormFilter\Plugins;

use Larakit\TraitModelMorphGallery;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class FormFilterPluginMorphTag extends FormFilterPlugin {

    public function before() {
        if (in_array(TraitModelMorphGallery::class, $this->model_traits)) {
            $this->formfilter->model->with('morph_tags');
        }
    }

    public function after() {
        if (in_array(TraitModelMorphGallery::class, $this->model_traits)) {
            $this->formfilter->addFilterTags();
        }
    }

}

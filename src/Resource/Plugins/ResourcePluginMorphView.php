<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */

namespace Larakit\Resource\Plugins;

use Larakit\Attach\LkNgAttach;
use Larakit\Morph\Morph;
use Larakit\MorphView;
use Larakit\TraitModelMorphRate;
use Larakit\TraitModelMorphView;

/**
 * Class ResourcePluginThumbs
 * @package Larakit\Resource\Plugins
 *
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
class ResourcePluginMorphView extends ResourcePlugin {

    public function appendData($ret) {

        if (in_array(TraitModelMorphView::class, $this->model_traits)) {
            $this->model->load('morph_view');
            $ret['morph_view'] = $this->model->morph_rate_me ? $this->model->morph_rate_me->update_at : null;
        }

        return $ret;
    }

    function addMorphView() {
        $item = MorphView::firstOrNew([
            'viewedable_id'   => $this->id,
            'viewedable_type' => $this->getMorphClass(),
            'usr_id'          => me('id') ? me('id') : 0,
            'ip'              => me('id') ? null : \Request::ip(),
        ]);
        $item->cnt++;
        $item->save();
        $item->touch();

    }

}

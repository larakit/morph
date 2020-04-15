<?php
\Larakit\Resource\JsonResource::registerPlugins([
    \Larakit\Resource\Plugins\ResourcePluginMorphTag::class,
    \Larakit\Resource\Plugins\ResourcePluginMorphLog::class,
    \Larakit\Resource\Plugins\ResourcePluginMorphGallery::class,
    \Larakit\Resource\Plugins\ResourcePluginMorphAttach::class,
    \Larakit\Resource\Plugins\ResourcePluginMorphRate::class,
]);

<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
\Route::bind('Morph', function ($morph)
{
    $morph = explode('-', $morph);

    $model_class = Larakit\Morph\Morph::reverseModel(\Illuminate\Support\Arr::get($morph, 0));
    $id          = (int) \Illuminate\Support\Arr::get($morph, 1);
    if ($model_class && $id) {
        return $model_class::find($id) ?? abort(404);
    } else {
        abort(404);
    }
});
Route::namespace('\Larakit\Controllers')
     ->middleware('api')
     ->group(function ()
     {
         \Route::any('/{Morph}/rate/{val}', 'AppMorphRateController@set')
               ->where('val', '(' . implode('|', range(1, 5)) . ')')
               ->where('morph', '([0-9a-z]{32}\-\d)')
               ->name('api.morph_rate.set')
         ;
     })
;


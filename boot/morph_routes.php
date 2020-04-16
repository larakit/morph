<?php
/*
 * @author  Alexey Berdnikov <aberdnikov@gmail.com>
 */
\Route::bind('Morph', function ($morph) {
    $morph = Larakit\Morph\Morph::hashDecode($morph);
    if($morph){
        return $morph;
    }
    abort(404);
});
Route::group([
    'middleware' => 'api',
    'namespace'  => '\Larakit\Controllers',
    'prefix'     => 'api/morph/{Morph}',
    'where'      => [
        'Morph' => '([0-9a-z]{32}\-[0-9a-zA-Z]{2,32})',
    ],
], function () {
    \Route::get('/rate', 'AppMorphRateController@get')
          ->name('api.morph_rate');
    \Route::post('/rate', 'AppMorphRateController@set')
          ->name('api.morph_rate');
    \Route::get('/abuse', 'AppMorphAbuseController@get')
          ->name('api.morph_abuse');
    \Route::post('/abuse', 'AppMorphAbuseController@set')
          ->name('api.morph_abuse');
    \Route::get('/comment', 'AppMorphCommentController@get')
          ->name('api.morph_comment');
    \Route::post('/comment', 'AppMorphCommentController@set')
          ->name('api.morph_comment');
});

//dump(Larakit\Morph\Morph::hashEncode(\App\Product::class, 1));
//dd(Larakit\Morph\Morph::hashDecode('e2aeb0e8fdc39d622670243138a3620e-jR'));

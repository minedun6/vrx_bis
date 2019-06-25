<?php

Route::group([
    'namespace' => 'Box',
], function () {
    Route::group([
        'middleware' => 'access.routeNeedsPermission:manage-boxes',
    ], function () {
        Route::resource('box', 'BoxController');
    });
});

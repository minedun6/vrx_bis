<?php

Route::group([
    'namespace' => 'Customer',
], function () {
    Route::group([
        'middleware' => 'access.routeNeedsPermission:manage-customers',
    ], function () {
        Route::resource('customer', 'CustomerController');
    });
});

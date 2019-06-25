<?php

Route::group([
    'namespace' => 'Worker',
], function () {

    /**
     * worker Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:manage-workers',
    ], function () {

        /**
         * worker CRUD
         */
        Route::resource('worker', 'workerController');
    });
});
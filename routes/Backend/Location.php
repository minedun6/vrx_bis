<?php

Route::group([
    'namespace' => 'Location',
], function () {

    /**
     * Game Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:manage-locations',
    ], function () {

        /**
         * location CRUD
         */
        Route::resource('location', 'LocationController');

        /**
         * Deleted location
         */
        Route::group(['prefix' => 'location/{deletedLocation}'], function() {
            Route::get('delete', 'LocationStatusController@delete')->name('location.delete-permanently');
            Route::get('restore', 'LocationStatusController@restore')->name('location.restore');
        });
    });
});
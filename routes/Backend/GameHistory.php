<?php

Route::group([
    'namespace' => 'GameHistory',
], function () {

    /**
     * Game Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:view-game-history',
    ], function () {

        Route::get('gaming/history', 'GameHistoryController@index')->name('gaming.history');

    });
});
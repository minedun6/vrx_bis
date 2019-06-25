<?php

Route::group([
    'namespace' => 'Game',
], function () {

    /**
     * Game Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsPermission:manage-games',
    ], function () {
        /**
         * Game CRUD
         */
        Route::resource('game', 'GameController');

        /**
         * Deleted Game
         */
        Route::group(['prefix' => 'game/{deletedGame}'], function() {
            Route::get('delete', 'GameStatusController@delete')->name('game.delete-permanently');
            Route::get('restore', 'GameStatusController@restore')->name('game.restore');
        });
    });
});
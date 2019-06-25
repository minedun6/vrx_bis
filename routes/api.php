<?php

// JWT Auth route
Route::post('auth', 'Api\ApiController@authenticate');

// Api Game History
Route::post('/v1/games/history', 'Api\ApiController@saveGameHistory')->middleware('jwt.auth')->name('api.store');
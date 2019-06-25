<?php

Route::group([
    'namespace' => 'Notification',
], function () {
    Route::put('notifications/{notification}', 'NotificationController@markAsRead')->name('notification.read');
});

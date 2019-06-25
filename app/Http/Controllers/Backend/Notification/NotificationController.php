<?php

namespace App\Http\Controllers\Backend\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return back();
    }

}

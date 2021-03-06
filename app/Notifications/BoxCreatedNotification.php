<?php

namespace App\Notifications;

use App\Models\Box\Box;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BoxCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Box
     */
    protected $box;

    /**
     * Create a new notification instance.
     *
     * @param Box $box
     */
    public function __construct(Box $box)
    {
        //
        $this->box = $box;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->box->toArray();
    }
}

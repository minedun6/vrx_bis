<?php

namespace App\Notifications;

use App\Models\Box\Box;
use App\Models\Game\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GameCreatedNotification extends Notification
{
    use Queueable;

    protected $game;

    /**
     * Create a new notification instance.
     *
     * @param Box $box
     */
    public function __construct(Game $game)
    {
        //
        $this->game = $game;
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
        return $this->game->toArray();
    }
}

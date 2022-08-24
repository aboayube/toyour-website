<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WasfaStatusUserNotification extends Notification
{
    use Queueable;
    protected $wasfa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($wasfa)
    {
        $this->wasfa = $wasfa;

        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('تم موافقه علي طلبك من طباخ' . $this->wasfa->wasfa->name)
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'تم موافقه علي طلبك من طباخ' . $this->wasfa->name,
            'action' => route('admin.wasfas.index'),
            'image' => $this->wasfa->image,
            'icon' => '<i class="fas fa-user"></i>'
            //
        ];
    }
}

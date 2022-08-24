<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WasfaUserCreateNotification extends Notification
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
        return ['database', 'mail'];
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
            ->line('The introduction to the notification.')
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
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->wasfa->user->name . 'من قبل طباخ' . $this->wasfa->name . 'تم طلب وصفة بنجاح بانتظار الموافقه',

            'action' => route('admin.wasfas.index'),
            'image' => $this->wasfa->image,
            'icon' => '<i class="fas fa-user"></i>'
            //
        ];
    }
}

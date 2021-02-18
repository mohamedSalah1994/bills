<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillPaid extends Notification
{
    use Queueable;
    private $bill_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bill_id)
    {
        $this->bill_id = $bill_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://127.0.0.1:8000/billsDetails/'.$this->bill_id;
        return (new MailMessage)
                    ->subject(' فاتوره جديده')
                    ->greeting('مرحبابك')
                    ->line('تم اضافة فاتوره جديده')
                    ->action('عرض االفاتوره', $url)
                    ->line('شكرا لاستخدامك نظام ادارة الفواتير');
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
}

<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactSubmited extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Liên hệ mới từ website')
            ->greeting('Xin chào quản trị viên,')
            ->line('Bạn vừa nhận được một liên hệ mới:')
            ->line('Họ tên: ' . $this->contact['last_name'] . ' ' . $this->contact['first_name'])
            ->line('Email: ' . $this->contact['email'])
            ->line('Subscribe: ' . ($this->contact['subscribe'] ? 'Có' : 'Không'))
            ->line('IP: ' . $this->contact['ip_address'])
            ->line('Vui lòng xử lý yêu cầu này nếu cần.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

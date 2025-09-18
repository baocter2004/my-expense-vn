<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'auth.client.verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return $url;
    }

    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Xác minh email của bạn')
            ->greeting('Xin chào ' . ($notifiable->fullName ?? $notifiable->email))
            ->line('Nhấn nút dưới đây để xác minh email của bạn.')
            ->action('Xác minh ngay', $url)
            ->line('Nếu bạn không tạo tài khoản, vui lòng bỏ qua.');
    }
}

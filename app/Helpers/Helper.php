<?php

namespace App\Helpers;

class Helper
{
    public static function getGreetingMessage(int $hour): string
    {
        $messages = [
            'morning' => [
                'Chúc bạn một buổi sáng tràn đầy năng lượng nhé!',
                'Buổi sáng vui vẻ và nhiều may mắn nhé!',
                'Chúc buổi sáng của bạn thật tuyệt vời và hiệu quả!'
            ],
            'noon' => [
                'Chúc bạn buổi trưa nghỉ ngơi thật thoải mái!',
                'Buổi trưa ngon miệng và dễ chịu nhé!',
                'Chúc bạn có buổi trưa thư giãn và nhiều niềm vui!'
            ],
            'afternoon' => [
                'Chúc bạn buổi chiều làm việc thật hiệu quả!',
                'Buổi chiều thật năng suất và tràn đầy ý tưởng nhé!',
                'Chúc bạn một buổi chiều nhẹ nhàng và vui vẻ!'
            ],
            'evening' => [
                'Chúc bạn buổi tối ấm áp bên gia đình hoặc bạn bè!',
                'Buổi tối thật thư giãn và dễ chịu nhé!',
                'Chúc bạn có một buổi tối bình yên và vui vẻ!'
            ],
            'night' => [
                'Chúc bạn ngủ ngon và mơ những giấc mơ đẹp!',
                'Khuya rồi, nhớ giữ sức khỏe và nghỉ ngơi sớm nhé!',
                'Chúc bạn một đêm thật yên bình và dễ chịu!'
            ],
        ];

        if ($hour >= 5 && $hour < 11) {
            $greetings = $messages['morning'];
        } elseif ($hour >= 11 && $hour < 13) {
            $greetings = $messages['noon'];
        } elseif ($hour >= 13 && $hour < 18) {
            $greetings = $messages['afternoon'];
        } elseif ($hour >= 18 && $hour < 22) {
            $greetings = $messages['evening'];
        } else {
            $greetings = $messages['night'];
        }

        return $greetings[array_rand($greetings)];
    }

    public static function getMenuItems(): array
    {
        return [
            [
                'label' => 'Danh Mục',
                'route' => 'client.categories.index',
            ],
            [
                'label' => 'Ví',
                'route' => 'client.wallets.index'
            ],
            [
                'label' => 'Giao Dịch',
                'route' => 'client.transactions.index'
            ]
        ];
    }

    public static function formatPrice($amount, string $suffix = 'VND', int $decimals = 0): string
    {
        if (!is_numeric($amount)) {
            return '0 ' . $suffix;
        }
        return number_format($amount, $decimals, ',', '.') . ' ' . $suffix;
    }
}

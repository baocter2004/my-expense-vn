<?php

namespace App\Consts;

class GlobalConst
{
    const ACTIVE = 1;
    const UNACTIVE = 2;

    const STATUS = [
        self::ACTIVE => "Hoạt Động",
        self::UNACTIVE => "Không Hoạt Động"
    ];

    const CURRENCY_VND = 1;
    const CURRENCY_USD = 2;
    const CURRENCY_EUR = 3;

    const CURRENCIES = [
        self::CURRENCY_VND => 'VND',
        self::CURRENCY_USD => 'USD',
        self::CURRENCY_EUR => 'EUR',
    ];

    const EXCHANGE_RATES_TO_VND = [
        self::CURRENCY_VND => 1,      // 1 VND = 1 VND
        self::CURRENCY_USD => 24000,  // 1 USD = 24,000 VND
        self::CURRENCY_EUR => 27000,  // 1 EUR = 27,000 VND
    ];

    const SORT_OPTIONS = [
        '' => 'Mặc định',
        'desc' => 'Mới nhất',
        'asc' => 'Cũ nhất',
    ];

    const DEFAULT_LIMIT = 10;
}

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

    const DEFAULT_LIMIT = 10;
}

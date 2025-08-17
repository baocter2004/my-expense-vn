<?php

namespace App\Consts;

class TransactionConst
{
    const INCOME = 1;
    const EXPENSE = 2;

    const TRANSACTION_TYPE = [
        self::INCOME => "Thu Nhập",
        self::EXPENSE => "Chi Tiêu"
    ];

    public const STATUS_PENDING   = 0;
    public const STATUS_COMPLETED = 1;
    public const STATUS_REVERSED  = 2;
    public const STATUS_CANCELLED = 3;
    public const STATUS_LABELS = [
        self::STATUS_PENDING   => 'Đang xử lý',
        self::STATUS_COMPLETED => 'Hoàn thành',
        self::STATUS_REVERSED  => 'Đã hoàn tác',
        self::STATUS_CANCELLED => 'Đã hủy',
    ];
}

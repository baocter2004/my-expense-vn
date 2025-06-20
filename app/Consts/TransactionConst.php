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
}
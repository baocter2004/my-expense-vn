<?php 

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    function modelName(): string
    {
        return Transaction::class;
    }
}
<?php 

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    function modelName(): string
    {
        return Wallet::class;
    }
}
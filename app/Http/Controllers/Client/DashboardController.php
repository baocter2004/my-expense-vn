<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CategoryService;
use App\Services\Client\TransactionService;
use App\Services\Client\UserService;
use App\Services\Client\WalletService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CategoryService $categoryService,
        protected UserService $userService
    ) {}

    public function dashboard()
    {
        
    }
}

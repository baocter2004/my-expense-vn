<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CategoryService;
use App\Services\Client\TransactionService;
use App\Services\Client\UserService;
use App\Services\Client\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CategoryService $categoryService,
        protected UserService $userService
    ) {}

    public function index()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $wallets = $this->walletService->getWalletSummaryByUser($userId);
            return view('client.pages.index', [
                'wallets' => $wallets
            ]);
        }
        return view('client.pages.landing-page');
    }

    public function introduce()
    {
        return view('client.pages.introduce');
    }
}

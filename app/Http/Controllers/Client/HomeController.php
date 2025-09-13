<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CategoryService;
use App\Services\Client\HomeService;
use App\Services\Client\TransactionService;
use App\Services\Client\UserService;
use App\Services\Client\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        protected HomeService $homeService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CategoryService $categoryService,
        protected UserService $userService
    ) {}

    public function index(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $dashboard = $this->walletService->getDashboardSummaryByUser($userId);
            $charts = $this->homeService->getDashboardCharts($userId);
            $transactionsToday = $this->transactionService->filter([
                'wheres' => [
                    'user_id' => $userId,
                    ['occurred_at', '>=', Carbon::today()->startOfDay()],
                    ['occurred_at', '<=', Carbon::today()->endOfDay()],
                ],
            ])->get();

            return view('client.pages.index', [
                'dashboard' => $dashboard,
                'charts' => $charts,
                'transactionsToday' => $transactionsToday
            ]);
        }
        return view('client.pages.landing-page');
    }


    public function introduce()
    {
        return view('client.pages.introduce');
    }
}

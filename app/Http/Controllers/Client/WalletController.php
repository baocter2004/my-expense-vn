<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallets\GetWalletRequest;
use App\Http\Requests\Wallets\PostWalletRequest;
use App\Services\Client\WalletService;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct(public WalletService $walletService) {}
    public function index(GetWalletRequest $getWalletRequest)
    {
        $id = Auth::id();
        $items = $this->walletService->getList($id, $getWalletRequest->validated());
        return view('client.pages.wallets.index', $items);
    }

    public function update(PostWalletRequest $postWalletRequest) {

    }
}

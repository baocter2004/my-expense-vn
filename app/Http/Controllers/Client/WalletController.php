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
        return view('client.pages.wallets.index', compact('items'));
    }

    public function update($id, PostWalletRequest $postWalletRequest)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('auth.client.showFormLogin')->with('error', 'Bạn không có quyền truy cập !');
        }

        $params = $postWalletRequest->all();
        $params['user_id'] = $userId;

        $result = $this->walletService->update($id, $params);
        if ($result) {
            return redirect()->route('client.wallets.index')->with('success', 'Thay đổi thông tin thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy xa , Vui lòng thử lại !!!');
        }
    }
}

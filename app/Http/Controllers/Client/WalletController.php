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

    public function create()
    {
        return view('client.pages.wallets.create');
    }

    public function store(PostWalletRequest $postWalletRequest)
    {
        $params = $this->prepareParams($postWalletRequest);
        $result = $this->walletService->create($params);

        if ($result) {
            return redirect()->route('client.wallets.index')->with('success', 'Thêm mới thông tin thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy xa , Vui lòng thử lại !!!');
        }
    }

    public function update($id, PostWalletRequest $postWalletRequest)
    {
        $params = $this->prepareParams($postWalletRequest);
        $result = $this->walletService->update($id, $params);

        if ($result) {
            return redirect()->route('client.wallets.index')->with('success', 'Thay đổi thông tin thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy xa , Vui lòng thử lại !!!');
        }
    }

    public function trash(GetWalletRequest $getWalletRequest)
    {
        $id = Auth::id();
        $items = $this->walletService->getListTrashed($id, $getWalletRequest->validated());
        return view('client.pages.wallets.trash', compact('items'));
    }

    public function delete($id)
    {
        $result = $this->walletService->delete($id);

        if ($result['status']) {
            return redirect()->route('client.wallets.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function restore($id)
    {
        $result = $this->walletService->restore($id);

        if ($result) {
            return redirect()->route('client.wallets.index')
                ->with('success', 'Khôi phục ví tiền thành công!');
        } else {
            return back()->with('error', 'Có lỗi khi khôi phục. Vui lòng thử lại.');
        }
    }

    private function prepareParams($request): array
    {
        $params = $request->all();
        $params['user_id'] = Auth::id();
        return $params;
    }
}

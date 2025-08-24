<?php

namespace App\Http\Controllers\Client;

use App\Consts\GlobalConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\GetTransactionRequest;
use App\Http\Requests\Transactions\PostTransactionRequest;
use App\Http\Requests\Transactions\UpdateTransactionRequest;
use App\Services\Client\CategoryService;
use App\Services\Client\TransactionService;
use App\Services\Client\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService,
        private CategoryService $categoryService,
        private WalletService $walletService
    ) {}

    public function index(GetTransactionRequest $request)
    {
        $params = array_merge(
            $request->validated(),
            ['user_id' => Auth::guard('user')->id()]
        );

        $items = $this->transactionService->search($params);
        session()->forget('transaction_items');

        return view('client.pages.transactions.index', compact('items'));
    }

    public function create()
    {
        $formData = $this->transactionService->prepareFormData();

        return view('client.pages.transactions.create', $formData);
    }

    public function store()
    {
        $items = session('transaction_items');

        if (!$items) {
            return redirect()->route('client.transactions.create')->with('error', 'Không có dữ liệu để lưu.');
        }

        $params = array_merge(
            ['user_id' => Auth::guard('user')->id()],
            $items
        );

        $result = $this->transactionService->store($params);
        session()->forget('transaction_items');

        if ($result['status']) {
            return redirect()->route('client.transactions.index')
                ->with('success', 'Thêm mới giao dịch thành công!');
        } else {
            return redirect()->route('client.transactions.create')->with('error', $result['message']);
        }
    }

    public function show(int|string $code)
    {
        $item = $this->transactionService->show($code);
        return view('client.pages.transactions.show', compact('item'));
    }

    public function edit(int|string $code)
    {
        $transaction = $this->transactionService->show($code);
        $oldItems = $transaction ? $transaction->toArray() : session('transaction_items', []);

        $formData = $this->transactionService->prepareFormData([
            'oldItems' => $oldItems,
        ]);

        return view('client.pages.transactions.edit', $formData);
    }

    public function update(int|string $code)
    {
        $items = session('transaction_items');

        if (!$items) {
            return redirect()->route('client.transactions.create')->with('error', 'Không có dữ liệu để lưu.');
        }

        $params = array_merge(
            ['user_id' => Auth::guard('user')->id()],
            $items
        );

        $result = $this->transactionService->updateTransaction($code,$params);
        session()->forget('transaction_items');

        if ($result['status']) {
            return redirect()->route('client.transactions.index')
                ->with('success', 'Thay đổi giao dịch thành công!');
        } else {
            return redirect()->route('client.transactions.create')->with('error', $result['message']);
        }
    }

    public function confirm(PostTransactionRequest $request)
    {
        $items = $this->transactionService->prepareParams($request);
        session(['transaction_items' => $items]);

        return view('client.pages.transactions.confirm', compact('items'));
    }

    public function editConfirm(UpdateTransactionRequest $request, string|int $code)
    {
        $items = $this->transactionService->prepareParams($request, $code);
        session(['transaction_items' => $items]);

        return view('client.pages.transactions.confirm', compact('items'));
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\GetTransactionRequest;
use App\Http\Requests\Transactions\PostTransactionRequest;
use App\Services\Client\CategoryService;
use App\Services\Client\TransactionService;
use App\Services\Client\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('client.pages.transactions.index', compact('items'));
    }

    public function create()
    {
        $categories = $this->categoryService
            ->getFields(['id', 'name'], ['where' => ['is_active' => 1]])
            ->pluck('name', 'id')
            ->toArray();

        $wallets = $this->walletService
            ->getFields(['id', 'name'])
            ->pluck('name', 'id')
            ->toArray();

        return view('client.pages.transactions.create', compact('categories', 'wallets'));
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

        $transaction = $this->transactionService->create($params);

        session()->forget('transaction_items');

        return redirect()->route('client.transactions.show', $transaction->code)
            ->with('success', 'Tạo giao dịch thành công!');
    }

    public function show(int|string $id)
    {
        $item = $this->transactionService->show($id);
        return view('client.pages.transactions.show', compact('item'));
    }

    public function edit(int|string $code)
    {
        $item = $this->transactionService->show($code);
        return view('client.pages.transactions.edit', compact('item'));
    }

    public function update(int|string $code) {}

    public function confirm(PostTransactionRequest $request)
    {
        $items = $request->validated();

        if ($request->hasFile('receipt_image')) {
            $items['receipt_image'] = $request->file('receipt_image')->store('transactions/temp', 'public');
        }

        session(['transaction_items' => $items]);

        return view('client.pages.transactions.confirm', compact('items'));
    }
}

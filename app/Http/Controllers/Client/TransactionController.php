<?php

namespace App\Http\Controllers\Client;

use App\Consts\GlobalConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\GetTransactionRequest;
use App\Http\Requests\Transactions\PostTransactionRequest;
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

        return view('client.pages.transactions.index', compact('items'));
    }

    public function create()
    {
        $categories = $this->categoryService
            ->getFields(['id', 'name'], ['where' => ['is_active' => GlobalConst::ACTIVE]])
            ->pluck('name', 'id')
            ->toArray();

        $walletData = $this->walletService->getWalletForTransactions();
        $byCurrency = $walletData['by_currency'] ?? [];

        $oldItems = session('transaction_items', []);

        $initialCurrency = old('currency', $oldItems['currency'] ?? null);

        if (empty($initialCurrency)) {
            $defaultCurrency = null;
            foreach ($byCurrency as $currencyKey => $meta) {
                if (!empty($meta['default'])) {
                    $defaultCurrency = $currencyKey;
                    break;
                }
            }
            $initialCurrency = $defaultCurrency ?? array_key_first($byCurrency) ?? GlobalConst::CURRENCY_VND;
        }

        $walletsForInitialCurrency = $byCurrency[$initialCurrency]['items'] ?? [];

        $defaultWalletId = old('wallet_id', $oldItems['wallet_id'] ?? ($byCurrency[$initialCurrency]['default'] ?? null));

        $walletBalances = collect($walletData['wallets'] ?? [])->pluck('balance_vnd', 'id')->toArray();

        return view('client.pages.transactions.create', [
            'categories' => $categories,
            'wallets' => $walletsForInitialCurrency,
            'defaultWalletId' => $defaultWalletId,
            'walletByCurrency' => $byCurrency,
            'walletBalances' => $walletBalances,
            'initialCurrency' => $initialCurrency,
            'oldItems' => $oldItems,
        ]);
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
            $items['receipt_image'] = $request->file('receipt_image')
                ->store('transactions/temp', 'public');
        }

        if (!empty($items['category_id'])) {
            $category = $this->categoryService
                ->getFields(['id', 'name'], ['where' => ['id' => $items['category_id']]])
                ->first();
            $items['category_name'] = $category->name ?? null;
        }

        if (!empty($items['wallet_id'])) {
            $wallet = $this->walletService
                ->getFields(['id', 'name'], ['where' => ['id' => $items['wallet_id']]])
                ->first();
            $items['wallet_name'] = $wallet->name ?? null;
        }

        session(['transaction_items' => $items]);

        return view('client.pages.transactions.confirm', compact('items'));
    }
}

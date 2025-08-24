<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Consts\TransactionConst;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Services\BaseCRUDService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransactionService extends BaseCRUDService
{
    protected $walletService;
    protected $categoryService;
    protected function getRepository(): TransactionRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(TransactionRepository::class);
        }
        return $this->repository;
    }

    protected function getWalletService(): WalletService
    {
        if (empty($this->walletService)) {
            $this->walletService = app()->make(WalletService::class);
        }
        return $this->walletService;
    }

    protected function getCategoryService(): CategoryService
    {
        if (empty($this->categoryService)) {
            $this->categoryService = app()->make(CategoryService::class);
        }
        return $this->categoryService;
    }

    protected function buildFilterParams(array $params): array
    {
        $wheres     = Arr::get($params, 'wheres', []);
        $whereLikes = Arr::get($params, 'likes', []);
        $order = Arr::get($params, 'sort') ?: 'desc';
        $sort  = 'id';
        $relates    = Arr::get($params, 'relates', []);

        $relates = [
            'wallet',
            'category'
        ];

        if (!empty($params['created_from'])) {
            $wheres[] = ['transactions.occurred_at', '>=', $params['created_from']];
        }

        if (!empty($params['created_to'])) {
            $wheres[] = ['transactions.occurred_at', '<=', $params['created_to']];
        }

        if (!empty($params['keyword'])) {
            $keyword = $params['keyword'];

            $wheres[] = [
                function ($query) use ($keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('transactions.code', 'like', '%' . $keyword . '%');

                        if (is_numeric($keyword)) {
                            $q->orWhereBetween('transactions.amount', [0, (float) $keyword]);
                        }
                    });
                }
            ];
        }

        return [
            'wheres' => $wheres,
            'likes'  => $whereLikes,
            'sort'   => $sort . ':' . $order,
            'relates' => $relates,
        ];
    }

    public function search(array $params = [], $limit = 6): LengthAwarePaginator
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }

        $query = $this->filter($params);

        return $query->paginate($limit)->appends(request()->query());
    }

    public function show(int|string $code)
    {
        $item = $this->repository->with(['wallet', 'category'], $code, 'code');
        return $item;
    }

    public function store(array $params = [])
    {
        try {
            DB::beginTransaction();

            $params['status'] = $params['status'] ?? TransactionConst::STATUS_COMPLETED;

            if (!empty($params['wallet_id'])) {
                $wallet = $this->getWalletService()->find($params['wallet_id']);
            }

            if (($params['transaction_type'] ?? null) == TransactionConst::EXPENSE) {
                if ($wallet->balance < $params['amount']) {
                    return [
                        'status' => false,
                        'message' => 'Số dư không đủ để thực hiện giao dịch !'
                    ];
                }
            }

            $transaction = parent::create($params);

            if (!empty($params['receipt_image']) && str_contains($params['receipt_image'], 'transactions/temp')) {
                $oldPath = $params['receipt_image'];

                $userId = $transaction->user_id ?? ($params['user_id'] ?? Auth::id());

                $originalName = basename($oldPath);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
                $newFileName = time() . '_' . Str::random(6) . '_' . Str::slug($nameOnly) . ($ext ? '.' . $ext : '');

                $newDir = "users/transactions/{$userId}";

                if (!Storage::disk('public')->exists($newDir)) {
                    Storage::disk('public')->makeDirectory($newDir);
                }

                $newPath = $newDir . '/' . $newFileName;

                if (Storage::disk('public')->exists($oldPath)) {
                    try {
                        Storage::disk('public')->move($oldPath, $newPath);
                        $transaction->update(['receipt_image' => $newPath]);
                    } catch (\Throwable $e) {
                        Log::error('Failed to move receipt image', [
                            'error' => $e->getMessage(),
                            'from' => $oldPath,
                            'to' => $newPath,
                        ]);
                        return [
                            'status' => false,
                            'message' => 'Có lỗi khi di chuyển ảnh!'
                        ];
                    }
                } else {
                    Log::warning('Receipt temp file not found', [
                        'path' => $oldPath,
                        'transaction_id' => $transaction->id
                    ]);
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy ảnh!'
                    ];
                }
            }
            if (!empty($wallet)) {
                $amount = (float) $transaction->amount;
                if ($transaction->transaction_type == TransactionConst::EXPENSE) {
                    $wallet->decrement('balance', $amount);
                } elseif ($transaction->transaction_type == TransactionConst::INCOME) {
                    $wallet->increment('balance', $amount);
                }
            }
            DB::commit();
            return [
                'status' => true,
                'data' => $transaction,
                'message' => 'Thêm mới thành công giao dịch : ' . $transaction->code,
            ];
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if (isset($newPath) && Storage::disk('public')->exists($newPath)) {
                Storage::disk('public')->delete($newPath);
            }

            DB::rollBack();
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra , vui lòng thử lại !'
            ];
        }
    }
    public function updateTransaction(int|string $code, array $params = [])
    {
        try {
            DB::beginTransaction();

            $transaction = $this->show($code);
            if (!$transaction) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy giao dịch!'
                ];
            }

            $params['status'] = $params['status'] ?? TransactionConst::STATUS_COMPLETED;

            $oldWalletId = $transaction->wallet_id;
            $oldAmount   = $transaction->amount;
            $oldType     = $transaction->transaction_type;

            $oldWallet = $this->getWalletService()->find($oldWalletId);

            if (!empty($params['receipt_image']) && str_contains($params['receipt_image'], 'transactions/temp')) {
                $oldPath = $params['receipt_image'];
                $userId = $transaction->user_id ?? ($params['user_id'] ?? Auth::id());

                $originalName = basename($oldPath);
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
                $newFileName = time() . '_' . Str::random(6) . '_' . Str::slug($nameOnly) . ($ext ? '.' . $ext : '');

                $newDir = "users/transactions/{$userId}";
                if (!Storage::disk('public')->exists($newDir)) {
                    Storage::disk('public')->makeDirectory($newDir);
                }

                $newPath = $newDir . '/' . $newFileName;

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->move($oldPath, $newPath);
                    $params['receipt_image'] = $newPath;
                } else {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy ảnh!'
                    ];
                }
            } else {
                unset($params['receipt_image']);
            }

            if ($oldWallet) {
                if ($oldType == TransactionConst::EXPENSE) {
                    $oldWallet->increment('balance', $oldAmount);
                } elseif ($oldType == TransactionConst::INCOME) {
                    $oldWallet->decrement('balance', $oldAmount);
                }
            }

            $transaction->update($params);
    
            $newWalletId = $params['wallet_id'] ?? $oldWalletId;
            $newWallet   = $this->getWalletService()->find($newWalletId);

            if ($newWallet) {
                $newAmount = $transaction->amount;
                $newType   = $transaction->transaction_type;

                if ($newType == TransactionConst::EXPENSE) {
                    if ($newWallet->balance < $newAmount) {
                        DB::rollBack();
                        return [
                            'status' => false,
                            'message' => 'Số dư không đủ để thực hiện giao dịch!'
                        ];
                    }
                    $newWallet->decrement('balance', $newAmount);
                } elseif ($newType == TransactionConst::INCOME) {
                    $newWallet->increment('balance', $newAmount);
                }
            }

            DB::commit();

            return [
                'status' => true,
                'data' => $transaction,
                'message' => 'Cập nhật giao dịch thành công: ' . $transaction->code,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__, [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }


    public function prepareParams($request, ?string $code = null): array
    {
        $items = $request->validated();

        if ($request->hasFile('receipt_image')) {
            $items['receipt_image'] = $request->file('receipt_image')
                ->store('transactions/temp', 'public');
        } elseif ($code) {
            $old = $this->show($code);
            if ($old && $old->receipt_image) {
                $items['receipt_image'] = $old->receipt_image;
            }
        }

        if (!empty($items['category_id'])) {
            $category = $this->getCategoryService()
                ->getFields(['id', 'name'], ['where' => ['id' => $items['category_id']]])
                ->first();
            $items['category_name'] = $category->name ?? null;
        }

        if (!empty($items['wallet_id'])) {
            $wallet = $this->getWalletService()
                ->getFields(['id', 'name'], ['where' => ['id' => $items['wallet_id']]])
                ->first();
            $items['wallet_name'] = $wallet->name ?? null;
        }

        if ($code) {
            $items['code'] = $code;
        }

        return $items;
    }

    public function prepareFormData(array $params = []): array
    {
        $categories = $this->getCategoryService()
            ->getFields(['id', 'name'], ['where' => ['is_active' => GlobalConst::ACTIVE]])
            ->pluck('name', 'id')
            ->toArray();

        $walletData = $this->getWalletService()->getWalletForTransactions();
        $byCurrency = $walletData['by_currency'] ?? [];

        $oldItems = $params['oldItems'] ?? session('transaction_items', []);

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

        return [
            'categories' => $categories,
            'wallets' => $walletsForInitialCurrency,
            'defaultWalletId' => $defaultWalletId,
            'walletByCurrency' => $byCurrency,
            'walletBalances' => $walletBalances,
            'initialCurrency' => $initialCurrency,
            'oldItems' => $oldItems,
        ];
    }
}

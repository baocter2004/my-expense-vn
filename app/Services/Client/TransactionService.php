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

    protected function buildFilterParams(array $params): array
    {
        $wheres     = Arr::get($params, 'wheres', []);
        $whereLikes = Arr::get($params, 'likes', []);
        $order = Arr::get($params, 'sort') ?: 'desc';
        $sort  = 'occurred_at';
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

            $params['status'] = $params['status'] ?? TransactionConst::STATUS_PENDING;

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

                $newDir = "users/{$userId}/transactions/{$transaction->id}";

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
                    }
                } else {
                    Log::warning('Receipt temp file not found', ['path' => $oldPath, 'transaction_id' => $transaction->id]);
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
}

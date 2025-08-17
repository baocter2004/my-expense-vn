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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function create(array $params = []): Transaction
    {
        try {
            DB::beginTransaction();

            $params['status'] = $params['status'] ?? TransactionConst::STATUS_PENDING;

            if (!empty($params['wallet_id'])) {
                $wallet = $this->getWalletService()->find($params['wallet_id']);
            }

            if (($params['transaction_type'] ?? null) == TransactionConst::EXPENSE) {
                if ($wallet->balance < $params['amount']) {
                    throw new \Exception('Số dư không đủ để thực hiện giao dịch');
                }
            }

            $transaction = parent::create($params);

            if (!empty($params['receipt_image']) && str_contains($params['receipt_image'], 'transactions/temp')) {
                $newPath = str_replace('transactions/temp', "transactions/{$transaction->id}", $params['receipt_image']);
                Storage::disk('public')->move($params['receipt_image'], $newPath);

                $transaction->update(['receipt_image' => $newPath]);
            }
            DB::commit();
            return $transaction;
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
            throw $th;
        }
    }
}

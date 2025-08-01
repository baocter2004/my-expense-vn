<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use App\Services\BaseCRUDService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletService extends BaseCRUDService
{
    public function getRepository(): WalletRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(WalletRepository::class);
        }

        return $this->repository;
    }

    protected function buildFilterParams(array $params): array
    {
        $wheres     = Arr::get($params, 'wheres', []);
        $whereLikes = Arr::get($params, 'likes', []);
        $sort       = Arr::get($params, 'sort', 'created_at');
        $order      = Arr::get($params, 'order', 'desc');
        $relates    = Arr::get($params, 'relates', []);

        $relates = [
            'user',
            'transactions'
        ];

        if (!empty($params['keyword'])) {
            $keyword = $params['keyword'];

            $wheres[] = [
                function ($query) use ($keyword) {
                    $query->where('wallets.id', $keyword)
                        ->orWhere('wallets.name', 'like', '%' . $keyword . '%')
                        ->orWhere('wallets.note', 'like', '%' . $keyword . '%')
                        ->orWhere('wallets.balance', $keyword)
                        ->orWhere('wallets.currency', $keyword);
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

    public function getList(int|string $id, array $params, $limit = 6)
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }

        $params['wheres'][] = ['wallets.user_id', '=', $id];

        $query = $this->filter($params);

        $query->leftJoin('transactions as t', function (JoinClause $join) {
            $join->on('t.wallet_id', '=', 'wallets.id')
                ->whereDate('t.created_at', now()->toDateString());
        });
        $query->select([
            'wallets.*',
            DB::raw('(SELECT COUNT(*) 
              FROM transactions t 
              WHERE t.wallet_id = wallets.id 
              AND DATE(t.created_at) = CURDATE()) as total_transactions'),
        ]);

        return $query->paginate($limit)->appends(request()->query());
    }

    public function create(array $params = []): Wallet
    {
        try {
            DB::beginTransaction();

            $params['is_default'] = !empty($params['is_default']) ? 1 : 0;
            $params['balance_vnd'] = str_replace('.', '', $params['balance_vnd']);

            if ($params['is_default']) {
                $this->repository->getModel()
                    ->where('user_id', $params['user_id'] ?? auth()->guard('user')->user()?->id)
                    ->update(['is_default' => 0]);
            }

            $wallet = $this->repository->create($params);
            
            DB::commit();
            return $wallet;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }

    public function update(int|string $id, array $params = []): Wallet
    {
        try {
            DB::beginTransaction();

            $wallet      = $this->repository->with([], $id);
            $oldCurrency = $wallet->currency;

            $params['is_default'] = !empty($params['is_default']) ? 1 : 0;
            if ($params['is_default']) {
                $this->repository->getModel()
                    ->where('user_id', $wallet->user_id)
                    ->where('id', '!=', $wallet->id)
                    ->update(['is_default' => 0]);
            }

            if (isset($params['currency']) && $params['currency'] != $oldCurrency) {
                $newCurrency = $params['currency'];
                $rates = GlobalConst::EXCHANGE_RATES_TO_VND;

                if (empty($wallet->balance_vnd)) {
                    $wallet->balance_vnd = $wallet->balance * ($rates[$oldCurrency] ?? 1);
                    $wallet->save();
                }

                $newRate = $rates[$newCurrency] ?? 1;
                $params['balance'] = round($wallet->balance_vnd / $newRate, 2);
            }

            $wallet->update($params);

            DB::commit();
            return $wallet;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th;
        }
    }
}

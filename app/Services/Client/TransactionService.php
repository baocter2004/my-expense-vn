<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Repositories\TransactionRepository;
use App\Services\BaseCRUDService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class TransactionService extends BaseCRUDService
{
    protected function getRepository(): TransactionRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(TransactionRepository::class);
        }
        return $this->repository;
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

    public function show(int|string $id)
    {
        $item = $this->repository->with(['wallet','category'], $id,'code');
        return $item;
    }
}

<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Repositories\TransactionRepository;
use App\Services\BaseCRUDService;
use Carbon\Carbon;
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
        $sort       = Arr::get($params, 'sort', 'created_at');
        $order      = Arr::get($params, 'order', 'desc');
        $relates    = Arr::get($params, 'relates', []);

        return [
            'wheres' => $wheres,
            'likes'  => $whereLikes,
            'sort'   => $sort . ':' . $order,
            'relates' => $relates,
        ];
    }
}

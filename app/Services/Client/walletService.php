<?php

namespace App\Services\Client;

use App\Repositories\WalletRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;

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
            'user'
        ];

        if (!empty($params['keyword'])) {
            $keyword = $params['keyword'];

            $wheres[] = [
                function ($query) use ($keyword) {
                    $query->where('wallets.id', $keyword)
                        ->orWhere('wallets.name', 'like', '%' . $keyword . '%')
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

        $params['wheres'][] = ['user_id', '=', $id];

        $items = $this->filter($params)->paginate($limit)->appends(request()->query());
        return [
            'items' => $items
        ];
    }
}

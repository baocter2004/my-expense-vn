<?php

namespace App\Services\Client;

use App\Consts\GlobalConst;
use App\Repositories\CategoryRepository;
use App\Services\BaseCRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryService extends BaseCRUDService
{
    protected function getRepository(): CategoryRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(CategoryRepository::class);
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

    public function getList(int|string $id, array $params, $limit = GlobalConst::DEFAULT_LIMIT)
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }

        $params['wheres'][] = ['user_id', '=', $id];
        $params['wheres'][] = ['is_active', '=', 1];

        $query = $this->filter($params);

        return $query->paginate($limit)->appends(request()->query());
    }
}

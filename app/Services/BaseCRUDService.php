<?php

namespace App\Services;

use App\Consts\GlobalConst;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseCRUDService extends BaseService
{
    public function search(array $params = [], $limit = GlobalConst::DEFAULT_LIMIT): LengthAwarePaginator
    {
        return $this->paginate($params, $limit)->appends(request()->query());
    }

    public function searchFilter(array $params = [], $limit = GlobalConst::DEFAULT_LIMIT): LengthAwarePaginator
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }
        $query = $this->filter($params);
        if (!empty($params['with_count'])) {
            $withCount = is_array($params['with_count']) ? $params['with_count'] : [$params['with_count']];
            $query->withCount($withCount);
        }

        return $query->paginate($limit)->appends(request()->query());
    }

    public function all(array $params): Collection
    {
        return $this->get($params);
    }

    public function prepareExportData($params)
    {
        return $params;
    }
}

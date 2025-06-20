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

    public function all(array $params): Collection
    {
        return $this->get($params);
    }

    public function prepareExportData($params)
    {
        return $params;
    }
}

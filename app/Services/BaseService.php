<?php

namespace App\Services;

use App\Consts\GlobalConst;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

abstract class BaseService
{
    protected BaseRepository|null $repository = null;

    abstract protected function getRepository(): BaseRepository;

    abstract protected function buildFilterParams(array $params): array;

    public function __construct()
    {
        $this->setRepository();
    }

    private function setRepository()
    {
        $repository = $this->getRepository();
        if (!($repository instanceof BaseRepository)) {
            throw new \Exception('Repository not found');
        }
        $this->repository = $repository;
    }

    public function get(array $params = []): Collection
    {
        return $this->filter($params)->get();
    }

    public function paginate(array $params = [], $limit = GlobalConst::DEFAULT_LIMIT): LengthAwarePaginator
    {
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }

        return $this->filter($params)->paginate($limit);
    }

    public function filter(array $params = []): Builder
    {
        return $this->getRepository()->filter($this->buildFilterParams($params));
    }

    public function find(int|string $id): ?Model
    {
        return $this->getRepository()->find($id);
    }

    public function findBy(array $params = []): ?Model
    {
        return $this->filter($params)->first();
    }

    public function create(array $params = []): Model
    {
        $params = $this->hashPassword($params);
        $item = $this->getRepository()->create($params);

        return $item;
    }

    public function insert(array $params = [])
    {
        $item = $this->getRepository()->insert($params);

        return $item;
    }

    public function update(int|string $id, array $params = []): Model
    {
        $params = $this->hashPassword($params);

        $item = $this->getRepository()->update($id, $params);

        return $item;
    }

    public function delete($id)
    {
        return $this->getRepository()->delete($id);
    }


    public function deleteAll(array $ids)
    {
        return $this->getRepository()->deleteAll($ids);
    }

    public function next($id, array $params = [])
    {
        $params['wheres'] = $params['wheres'] ?? [];
        $params['wheres'][] = ['id', '>', $id];
        $params['sort'] = 'id:asc';

        return $this->getRepository()->filter($params)->first();
    }

    public function prev($id, array $params = [])
    {
        $params['wheres'] = $params['wheres'] ?? [];
        $params['wheres'][] = ['id', '<', $id];
        $params['sort'] = 'id:desc';

        return $this->getRepository()->filter($params)->first();
    }

    protected function hashPassword($params)
    {
        if (!empty($value = Arr::get($params, 'password'))) {
            if ($salt = Arr::get($params, 'password_salt')) {
                $params['password'] = Hash::make($value, ['salt' => $salt]);
            } else {
                $params['password'] = Hash::make($value);
            }
        } else {
            unset($params['password']);
            unset($params['password_salt']);
        }

        return $params;
    }

    public function createOrUpdate($params, $instance = null)
    {
        return $this->getRepository()->updateOrCreate($params, $instance);
    }

    public function getPaginateForPage($data, int $total, ?int $perPage, int $currentPage)
    {
        return new PaginationLengthAwarePaginator($data, $total, $perPage, $currentPage, [
            'path' => PaginationLengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function updateOrCreate(array $values, array $attributes = [])
    {
        return $this->getRepository()->updateOrCreate($values, $attributes);
    }

    public function getFields(array $fields, array $params = [])
    {
        return $this->repository->getFields($fields, $params);
    }
}

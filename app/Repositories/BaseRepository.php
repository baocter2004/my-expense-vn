<?php

namespace App\Repositories;

use App\Consts\GlobalConst;
use App\Traits\HasQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    use HasQuery;

    protected Model $model;

    abstract function modelName(): string;

    public function __construct()
    {
        $this->setModel();
    }

    private function setModel()
    {
        $modelName = $this->modelName();
        $model = new $modelName;
        if (!($model instanceof Model)) {
            throw new \Exception('MODEL NOT FOUND');
        }
        $this->model = $model;
    }

    function getModel(): Model
    {
        return $this->model;
    }

    public function find(int|string $id): ?Model
    {
        return $this->findBy($id);
    }

    public function with($with, $value, $column = 'id')
    {
        return $this->getModel()->with($with)->where($column, $value)->first();
    }

    /**
     * Supported keys in $params:
     * - where_equals:  ['col' => value, …]
     * - wheres:        same as where_equals
     * - where_likes:   ['col' => 'substring', …]
     * - likes:         same as where_likes
     * - where_ins:     ['col' => [val1,val2,…] or 'val1,val2,…', …]
     * - where_between:['col' => [from,to] or 'from,to', …]
     * - where_null:    ['col1','col2',…]   (WHERE col IS NULL OR col = '')
     * - ins:           alias for where_ins
     * - where_has:     ['relation' => [[col,op,val],…], …]
     * - or_wheres:     [[col,op,val],…]
     * - sort:          'column:direction'
     * - sorts:         ['col1:dir1','col2:dir2',…]
     * - relates:       ['relation1','relation2',…]
     *
     * @param  array  $params
     * @return Builder
     */

    public function filter(array $params): Builder
    {
        $query = $this->getModel()->query();

        // query common field
        $whereEquals = $this->buildWhereEqual(array_merge($params['where_equals'] ?? [], $params['wheres'] ?? []));
        $whereLikes = $this->buildWhereLike(array_merge($params['where_likes'] ?? [], $params['likes'] ?? []));
        $whereIns = $this->buildWhereIn($params['where_ins'] ?? []);
        $whereNull = $this->cleanValueNull($params['where_null'] ?? []);
        $ins = $params['ins'] ?? null;
        $whereHas = $this->cleanValueNull($params['where_has'] ?? []);
        $orWheres = $this->cleanValueNull($params['or_wheres'] ?? []);
        $sort = $this->buildSort($params['sort'] ?? '');
        $relates = $params['relates'] ?? null;

        $sorts = [];
        $sortsParam = ($params['sorts'] ?? []);
        if (is_array($sortsParam)) {
            foreach ($sortsParam as $sortParam) {
                $sorts[] = $this->buildSort($sortParam);
            }
        }

        $query
            ->when($whereEquals, function ($query) use ($whereEquals) {
                $query->where($whereEquals);
            })
            ->when($whereIns, function ($query) use ($whereIns) {
                foreach ($whereIns as $key => $in) {
                    $query->whereIn($key, $in);
                }
            })
            ->when($whereNull, function ($query) use ($whereNull) {
                foreach ($whereNull as $name) {
                    if ($name) {
                        $query->where(function ($query) use ($whereNull, $name) {
                            $query->whereNull($name);
                            $query->orWhere($name, '');
                        });
                    }
                }
            })
            ->when($ins, function ($query) use ($ins) {
                foreach ($ins as $key => $in)
                    $query->whereIn($key, $in);
            })
            ->when($whereLikes, function ($query) use ($whereLikes) {
                $query->where($whereLikes);
            })
            ->when(!empty($whereHas), function ($query) use ($whereHas) {
                foreach ($whereHas as $relateName => $conditions) {
                    if (!empty($conditions)) {
                        $query->whereHas($relateName, function ($subQuery) use ($conditions) {
                            foreach ($conditions as $condition) {
                                if (($condition[0] ?? false) && ($condition[2] ?? false) && strtoupper($condition[1] ?? false) === 'IN') {
                                    $subQuery->whereIn($condition[0], $condition[2]);
                                } else {
                                    $subQuery->where([$condition]);
                                }
                            }
                        });
                    }
                }
            })
            ->when(!empty($orWheres), function ($query) use ($orWheres) {
                $query->where(function ($query) use ($orWheres) {
                    foreach ($orWheres as $orWhere) {
                        $query->orWhere($orWhere);
                    }
                });
            })
            ->when(!empty($sorts), function ($query) use ($sorts) {
                foreach ($sorts as $sort) {
                    if (!empty($sort)) {
                        if (str_contains($sort['column'], 'raw|')) {
                            $sort['column'] = str_replace('raw|', '', $sort['column']);
                            $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                        } else {
                            $query->orderBy($sort['column'], $sort['direction']);
                        }
                    }
                }
            })
            ->when(!empty($sort), function ($query) use ($sort) {
                if (str_contains($sort['column'], 'raw|')) {
                    $sort['column'] = str_replace('raw|', '', $sort['column']);
                    $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                } else {
                    $query->orderBy($sort['column'], $sort['direction']);
                }
            })
            ->when(!empty($relates), function ($query) use ($relates) {
                $query->with($relates);
            });

        return $query;
    }

    public function findBy($value, $column = 'id'): ?Model
    {
        return $this->getModel()->where($column, $value)->first();
    }

    public function get(array $params = []): Collection
    {
        return $this->filter($params)->get();
    }
    public function paginate(array $params = [], $limit = GlobalConst::DEFAULT_LIMIT)
    {
        return $this->filter($params)->paginate($limit);
    }

    public function create(array $params)
    {
        return $this->getModel()->create($params);
    }

    public function update($id, array $params)
    {
        $item = $this->getModel()->find($id);
        if (! $item) {
            return null;
        }
        return $item->update($params) ? $item : null;
    }

    public function updateWithTimestamp($id, array $params, $timestamps  = true)
    {
        $item = $this->getModel()->find($id);
        if (! $item) {
            return null;
        }
        return $item->update($params) ? $item : null;
    }

    public function updateOrCreate(array $values, array $attributes = [])
    {
        return $this->getModel()->updateOrCreate($attributes, $values);
    }

    public function upsert(array $params, array $uniqueByColumns, array $updatedColumns = null)
    {
        return $this->getModel()->upsert($params, $uniqueByColumns, $updatedColumns);
    }

    public function delete(int $id)
    {
        return $this->getModel()->where('id', $id)->delete();
    }

    public function forceDelete(int $id)
    {
        return $this->getModel()->where('id', $id)->forceDelete();
    }

    public function deleteAll(array $ids)
    {
        return $this->getModel()->whereIn('id', $ids)->delete();
    }

    public function insert(array $params)
    {
        return $this->getModel()->insert($params);
    }

    public function deleteBy($value, $column = 'id')
    {
        return $this->getModel()->where($column, $value)->delete();
    }

    public function restore(int $id)
    {
        return $this->getModel()->onlyTrashed()->where('id', $id)->restore();
    }

    public function findTrashed(int $id)
    {
        return $this->getModel()->onlyTrashed()->where('id', $id)->first();
    }

    public function findWithTrashed(int $id)
    {
        return $this->getModel()->withTrashed()->where('id', $id)->first();
    }

    public function countOnlyTrashed(array $conditions = []): int
    {
        $query = $this->model->onlyTrashed();

        foreach ($conditions as $condition) {
            $query->where(...$condition);
        }

        return $query->count();
    }
}

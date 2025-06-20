<?php

namespace App\Traits;

trait HasQuery
{
    protected function buildWhereBetween(array $params): array
    {
        $data = [];
        foreach ($params as $key => $params) {
            if (empty($params)) continue;
            $data[$key] = is_string($params) ? explode(',', $params) : $params;
        }
        return $data;
    }

    protected function buildWhereEqual(array $params): array
    {
        return $this->cleanValueNull($params);
    }

    protected function buildWhereIn(array $params): array
    {
        return array_filter($params, function ($value) {
            return !empty($value);
        });
    }

    protected function buildWhereLike(array $params): array
    {
        $wheres = [];
        $params = $this->cleanValueNull($params);
        foreach ($params as $key => $value) {
            $wheres[] = [$key, 'LIKE', '%' . (is_array($value) ? $value[0] : $value) . '%'];
        }
        return $wheres;
    }

    protected function buildSort($sort)
    {
        if (empty($sort) || !str_contains($sort, ':')) return [];
        $sorts = explode(':', $sort);

        if (count($sorts) !== 2) {
            return [];
        }
        return [
            'column'    => $sorts[0],
            'direction' => $sorts[1],
        ];
    }


    protected function cleanValueNull($params)
    {
        return array_filter($params, function ($value) {
            return !is_null($value) && $value !== '';
        });
    }
}

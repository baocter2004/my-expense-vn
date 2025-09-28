<?php

namespace App\Services\Admin;

use App\Repositories\UserRepository;
use App\Services\BaseCRUDService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class UserService extends BaseCRUDService
{
    public function getRepository(): UserRepository
    {
        if (empty($this->repository)) {
            $this->repository = app()->make(UserRepository::class);
        }
        return $this->repository;
    }

    protected function buildFilterParams(array $params): array
    {
        $whereEquals = Arr::get($params, 'where_likes', []);
        $whereLikes  = Arr::get($params, 'where_equals', []);
        $wheres      = Arr::get($params, 'wheres', []);
        $sort        = Arr::get($params, 'sort', 'created_at');
        $order       = Arr::get($params, 'order', 'desc');
        $relates     = Arr::get($params, 'relates', [
            'admin',
            'transactions'
        ]);

        if (!empty($params['from_date'])) {
            $whereEquals[] = ['users.created_at', '>=', $params['from_date']];
        }

        if (!empty($params['to_date'])) {
            $whereEquals[] = ['users.created_at', '<=', $params['to_date']];
        }

        if (!empty($params['first_name'])) {
            $whereLikes['users.first_name'] = $params['first_name'];
        }

        if (!empty($params['last_name'])) {
            $whereLikes['users.last_name'] = $params['last_name'];
        }

        if (!empty($params['email'])) {
            $whereLikes['users.email'] = $params['email'];
        }

        if (!empty($params['is_active'])) {
            $whereEquals['users.is_active'] = $params['is_active'];
        }

        if (!empty($params['gender'])) {
            $whereEquals['users.gender'] = $params['gender'];
        }

        return [
            'wheres'        => $wheres,
            'where_equals' => $whereEquals,
            'where_likes'  => $whereLikes,
            'sort'         => $sort . ':' . $order,
            'relates'      => $relates,
        ];
    }

    public function totalUser(): int
    {
        return $this->repository->count();
    }

    public function getNewUsersWithChange(string $type = 'day'): array
    {
        switch ($type) {
            case 'day':
                $currentStart = now()->startOfDay();
                $currentEnd   = now()->endOfDay();
                $prevStart    = now()->subDay()->startOfDay();
                $prevEnd      = now()->subDay()->endOfDay();
                break;

            case 'month':
                $currentStart = now()->startOfMonth();
                $currentEnd   = now()->endOfMonth();
                $prevStart    = now()->subMonth()->startOfMonth();
                $prevEnd      = now()->subMonth()->endOfMonth();
                break;

            case 'year':
                $currentStart = now()->startOfYear();
                $currentEnd   = now()->endOfYear();
                $prevStart    = now()->subYear()->startOfYear();
                $prevEnd      = now()->subYear()->endOfYear();
                break;

            default:
                return [];
        }

        $current = $this->repository->count([
            'wheres' => [
                ['created_at', '>=', $currentStart],
                ['created_at', '<=', $currentEnd],
            ]
        ]);

        $previous = $this->repository->count([
            'wheres' => [
                ['created_at', '>=', $prevStart],
                ['created_at', '<=', $prevEnd],
            ]
        ]);

        $percent = $previous > 0
            ? (($current - $previous) / $previous) * 100
            : ($current > 0 ? 100 : 0);

        return [
            'value'  => $current,
            'change' => round($percent, 1),
        ];
    }
}

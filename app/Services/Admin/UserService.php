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

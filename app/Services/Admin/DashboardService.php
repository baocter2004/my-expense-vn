<?php

namespace App\Services\Admin;

use App\Repositories\BaseRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;

class DashboardService
{
    public function __construct(protected UserService $userService) {}

    public function dashboard()
    {
        $totalUserCount = $this->userService->totalUser();
        $today = $this->userService->getNewUsersWithChange('day');
        $month = $this->userService->getNewUsersWithChange('month');
        $year  = $this->userService->getNewUsersWithChange('year');

        return [
            'totalUserCount' => $totalUserCount,
            'newUsers' => [
                'today' => $today,
                'month' => $month,
                'year'  => $year,
            ]
        ];
    }
}

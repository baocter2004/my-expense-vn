<?php

namespace App\Services\Admin;

use App\Repositories\BaseRepository;
use App\Services\BaseCRUDService;
use Illuminate\Support\Arr;

class DashboardService {
    public function __construct(protected UserService $userService){}

    public function dashboard()
    {
        $totalUserCount = $this->userService->totalUser();

        return [
            'totalUserCount' => $totalUserCount
        ];
    }
}

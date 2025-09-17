<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(protected DashboardService $dashboardService){}

    public function dashboard() {
        return view('admin.pages.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\GetUserRequest;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function index(GetUserRequest $getUserRequest)
    {
        $items = $this->userService->searchFilter($getUserRequest->validated(),10);

        return view('admin.pages.users.index', compact('items'));
    }
}

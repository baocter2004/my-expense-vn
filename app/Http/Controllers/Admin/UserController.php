<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\GetUserRequest;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(GetUserRequest $getUserRequest)
    {
        $params = $getUserRequest->validated();
        $params['with_count'] = ['transactions'];

        $items = $this->userService->searchFilter($params, 10);

        return view('admin.pages.users.index', compact('items'));
    }

    public function show($userId)
    {
        $params = [
            'relates' => [
                'admin',
                'transactions',
                'categories',
                'wallets'
            ],
            'wheres' => [
                'id' => $userId
            ]
        ];

        $user = $this->userService->filter($params)->withCount([
            'transactions',
            'categories',
            'wallets'
        ])->first();

        return view('admin.pages.users.show', compact('user'));
    }
}

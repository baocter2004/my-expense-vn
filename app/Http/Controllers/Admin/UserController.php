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

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Không tìm thấy người dùng');
        }

        return view('admin.pages.users.show', compact('user'));
    }

    public function lockUser(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = $this->userService->find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng'], 404);
        }

        $user->update([
            'is_active' => 2,
            'locked_reason' => $request->reason,
        ]);

        return response()->json([
            'message' => 'Người dùng đã bị khóa thành công!',
        ], 200);
    }

    public function softDelete($id)
    {
        $user = $this->userService->find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng'], 404);
        }

        $user->delete();
        $user->update([
            'is_active' => 2,
        ]);

        return response()->json([
            'message' => 'Người dùng đã bị xóa thành công!',
        ], 200);
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }
}

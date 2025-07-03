<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\Client\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}
    public function index()
    {
        $id = Auth::id();

        $items = $this->userService->show($id, [
            'categories_limit' => 10,
            'categories_page' => request('categories_page', 1),

            'wallets_limit' => 10,
            'wallets_page' => request('wallets_page', 1),

            'transactions_limit' => 5,
            'transactions_page' => request('transactions_page', 1),
        ]);

        $items['greeting'] = Helper::getGreetingMessage(now()->hour);

        return view('client.pages.profile.index', $items);
    }

    public function update(UpdateUserRequest $updateUserRequest)
    {
        $id = Auth::id();
        $result = $this->userService->update($id, $updateUserRequest->validated());
        if ($result) {
            return redirect()->route('client.profile')->with('success', 'Thay đổi thông tin thành công!');
        } else {
            return back()->with('error', 'Có lỗi xảy xa , Vui lòng thử lại !!!');
        }
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $id = Auth::id();
        $avatarPath = $this->userService->updateAvatar($id, $request->file('avatar'));

        if ($avatarPath) {
            return redirect()->route('client.profile')->with('success', 'Ảnh đại diện đã được cập nhật!');
        }

        return back()->with('error', 'Cập nhật ảnh thất bại, vui lòng thử lại.');
    }

    public function updatePassword(Request $request)
    {
        $id = Auth::id();

        if (!$id) {
            return redirect()->route('auth.client.showFormLogin')->with('error', 'Bạn không có quyền truy cập !');
        }

        $this->userService->handleChangePassword($id, $request->all());
        Auth::logout();

        return redirect()->route('auth.client.showFormLogin')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}

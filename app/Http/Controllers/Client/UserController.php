<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\Client\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}
    public function index()
    {
        $id = Auth::id();
        $items = $this->userService->show($id);
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
}

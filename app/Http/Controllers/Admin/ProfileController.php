<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostPasswordRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show() {
        return view('admin.pages.profile.profile');
    }

    public function showFormChangePassword()
    {
        return view('admin.pages.profile.change-password');
    }

    public function changePassword(PostPasswordRequest $postPasswordRequest)
    {
        $idAdmin = Auth::guard('admin')->id();
        $admin = Admin::findOrFail($idAdmin);
        $admin->update([
            'password' => Hash::make($postPasswordRequest->new_password),
        ]);
        Auth::guard('admin')->logout();

        return redirect()->route('auth.admin.showFormLogin')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostPasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.pages.profile.profile');
    }

    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        DB::beginTransaction();
        try {
            $idAdmin = Auth::guard('admin')->id();
            $admin = Admin::findOrFail($idAdmin);
            $admin->update($updateProfileRequest->validated());
            DB::commit();
            return  redirect()->route('admin.profile.show')->with('success', "Thay đổi thông tin thành công !");
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            DB::rollBack();
            throw $th;
        }
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

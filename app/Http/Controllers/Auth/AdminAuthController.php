<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showFormLogin()
    {
        return view('admin.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')->with('success', 'Đăng Nhập Quản Trị Viên Thành Công');
        }

        return back()->with('error', 'Đăng Nhập Không Thành Công')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $message = 'Đăng Xuất Thành Công';

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.index')
            ->with('success', $message);
    }
}

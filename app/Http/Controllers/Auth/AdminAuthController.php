<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\MailToAcceptAdmin;
use Carbon\Carbon;
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

        if (Auth::guard('admin')->validate($credentials)) {
            $admin = Admin::where('email', $credentials['email'])->first();
            $otp = rand(100000, 999999);
            $otp_expires_at = Carbon::now()->addMinutes(5);

            $admin->update([
                'otp_code' => $otp,
                'otp_expires_at' => $otp_expires_at,
            ]);

            $request->session()->put('pending_admin_email', $admin->email);
            $admin->notify(new MailToAcceptAdmin($otp, $otp_expires_at));

            return redirect()->route('auth.admin.otp.form')
                ->with('success', 'Mã xác nhận đã được gửi đến email của bạn');
        }

        return back()->with('error', 'Đăng Nhập Không Thành Công')->withInput();
    }

    public function showOtpForm()
    {
        return view('admin.pages.auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $otp = is_array($request->otp) ? implode('', $request->otp) : $request->otp;

        $request->merge([
            'otp' => $otp
        ]);

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $admin = Admin::where('email', session('pending_admin_email'))->first();

        if (!$admin) {
            return redirect()->route('auth.admin.showFormLogin')->with('error', 'Phiên đăng nhập không hợp lệ.');
        }

        if ($admin->otp_code !== $request->otp) {
            return back()->with('error', 'Mã OTP không đúng.');
        }

        if (Carbon::now()->greaterThan($admin->otp_expires_at)) {
            return back()->with('error', 'Mã OTP đã hết hạn.');
        }

        Auth::guard('admin')->login($admin);
        $request->session()->forget('pending_admin_email');

        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công.');
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

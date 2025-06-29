<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\PostUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class ClientAuthController extends Controller
{
    public function showFormRegister()
    {
        return view('client.pages.auth.register');
    }

    public function register(PostUserRequest $postUserRequest)
    {
        try {
            $data = $postUserRequest->validated();

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            if ($user) {
                Auth::login($user);
            }

            return redirect()->route('client.index')->with('success', 'Đăng Ký Thành Công !');
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return back()->with('error', 'Có Lỗi Khi Đăng Ký , Vui Lòng Thử Lại !');
        }
    }

    public function showFormLogin()
    {
        return view('client.pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('client.index')->with('success', 'Đăng Nhập Thành Công');
        }

        return back()->with('error', 'Đăng Nhập Không Thành Công')->withInput();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            $fullName = $googleUser->getName();
            $nameParts = explode(' ', $fullName);

            $firstName = array_pop($nameParts);
            $lastName = implode(' ', $nameParts);

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'google_id' => $googleUser->getId(),
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email'      => $email,
                    'password'   => bcrypt(Str::random(16)),
                ]);
            }

            Auth::login($user);

            return redirect()->route('client.index')
                ->with('success', 'Đăng nhập thành công!');
        } catch (\Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
            return redirect()->route('auth.client.showFormLogin')
                ->with('error', 'Không thể đăng nhập với Google. Vui lòng thử lại.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $message = 'Đăng Xuất Thành Công';

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.index')
            ->with('success', $message);
    }

    public function showFormForgotPassword() {
        return view('client.pages.auth.forgot-password');
    }
}

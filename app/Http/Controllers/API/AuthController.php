<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $data = $request->validate(rules: [
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $status = Password::sendResetLink([
                'email' => $data['email'],
            ]);

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã gửi link khôi phục mật khẩu. Vui lòng kiểm tra email.',
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => trans($status),
            ], 422);
        } catch (Throwable $th) {
            Log::error('Error in ' . __CLASS__ . '::' . __FUNCTION__ . ' => ' . $th->getMessage(), [
                'file'  => $th->getFile(),
                'line'  => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi email. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    /**
     * Xử lý reset mật khẩu.
     */
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token'    => 'required|string',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $data,
            function ($user, $newPassword) {
                $user->forceFill([
                    'password'       => bcrypt($newPassword),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => 'Đặt lại mật khẩu thành công.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => trans($status),
        ], 422);
    }
}

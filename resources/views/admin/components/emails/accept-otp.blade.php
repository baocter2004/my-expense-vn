@extends('client.components.emails.master-blank')

@section('title', 'xác nhận otp')
@section('heading', '🔐 xác nhận otp tài khoản')

@section('content')
    <p>Xin chào <strong>{{ $user->name ?? 'Quản trị viên' }}</strong>,</p>

    <p>Bạn vừa yêu cầu xác nhận otp cho tài khoản <strong>MyExpenseVn</strong>.</p>

    <p>Vui lòng nhập mã otp bên dưới vào khung otp :</p>

    <div class="otp-box">
        {{ $otp }}
    </div>

    <div class="highlight-box">
        Mã otp sẽ có hiệu lực đến : {{ $otp_expires_at }}
    </div>

    <p>Nếu bạn không yêu cầu đăng nhập admin , vui lòng bỏ qua email này.
        Tài khoản của bạn sẽ không bị ảnh hưởng.</p>
@endsection

@extends('client.components.emails.master-blank')

@section('title', 'Đặt lại mật khẩu')
@section('heading', '🔐 Đặt lại mật khẩu tài khoản')

@section('content')
    <p>Xin chào {{ $user->name ?? 'bạn' }},</p>

    <p>Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản MyExpenseVn.</p>

    <p>Nhấn vào nút dưới đây để tiếp tục:</p>

    <a href="{{ $resetUrl }}" class="btn">Đặt lại mật khẩu ngay</a>

    <p>Liên kết sẽ hết hạn sau 60 phút.</p>

    <p>Nếu bạn không yêu cầu điều này, vui lòng bỏ qua email.</p>
@endsection

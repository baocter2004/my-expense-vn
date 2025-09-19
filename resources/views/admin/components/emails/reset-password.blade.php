@extends('client.components.emails.master-blank')

@section('title', 'Đặt lại mật khẩu')
@section('heading', '🔐 Đặt lại mật khẩu tài khoản')

@section('content')
    <p>Xin chào <strong>{{ $user->name ?? 'Quản trị viên' }}</strong>,</p>

    <p>Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản <strong>MyExpenseVn</strong>.</p>

    <p>Nhấn vào nút dưới đây để tiếp tục quá trình:</p>

    <p style="text-align: center; margin: 24px 0;">
        <a href="{{ $resetUrl }}" class="btn">Đặt lại mật khẩu ngay</a>
    </p>

    <div class="highlight-box">
        Liên kết sẽ hết hạn sau 60 phút
    </div>

    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.
        Tài khoản của bạn sẽ không bị ảnh hưởng.</p>
@endsection

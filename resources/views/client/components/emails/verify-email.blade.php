@extends('client.components.emails.master-blank')

@section('title', 'Xác Minh Tài Khoản')
@section('heading', 'Xác Minh Email Tài Khoản')

@section('content')
    <p>Xin chào {{ $user->name ?? 'bạn' }},</p>

    <p>Cảm ơn bạn đã đăng ký tài khoản MyExpenseVn.</p>

    <p>Vui lòng nhấn vào nút dưới đây để xác minh địa chỉ email của bạn:</p>

    <a href="{{ $verificationUrl }}" class="btn">Xác minh ngay</a>

    <p>Liên kết sẽ hết hạn sau 60 phút.</p>

    <p>Nếu bạn không thực hiện đăng ký, vui lòng bỏ qua email này.</p>
@endsection

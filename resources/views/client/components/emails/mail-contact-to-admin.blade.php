@extends('client.components.emails.master-blank')

@section('title', 'Liên hệ mới từ website')
@section('heading', '📩 Bạn có liên hệ mới từ MyExpenseVn')

@section('content')
    <p>Xin chào quản trị viên,</p>

    <p>Bạn vừa nhận được một liên hệ mới từ website MyExpenseVn với các thông tin sau:</p>

    <ul style="list-style: none; padding-left: 0; text-align: left;">
        <li><strong>Họ tên:</strong> {{ $contact->last_name }} {{ $contact->first_name }}</li>
        <li><strong>Email:</strong> {{ $contact->email }}</li>
        <li><strong>Subscribe:</strong> {{ $contact->subscribe ? 'Có' : 'Không' }}</li>
        <li><strong>IP gửi:</strong> {{ $contact->ip_address }}</li>
        @if (!empty($contact->message))
            <li><strong>Lời nhắn:</strong> {{ $contact->message }}</li>
        @endif
    </ul>

    <p>Vui lòng kiểm tra và xử lý yêu cầu này nếu cần thiết.</p>

    <p>Trân trọng,<br>Đội ngũ MyExpenseVn</p>
@endsection

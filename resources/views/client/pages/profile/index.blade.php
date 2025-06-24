@extends('client.layouts.master')

@section('title')
    Trang Thông Tin Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Thông tin cá nhân'],
    ];
@endphp

@section('content')
    <div
        class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4">
        <div class="text-center mb-8">
            <h1
                class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                <i class="fa-solid fa-wallet"></i> MyExpenseVn
            </h1>
            <div class="my-2 flex justify-center">
                <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
            </div>
            <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">Thông Tin Trang Cá Nhân</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-5xl w-full">
            <div class="col-span-1 flex flex-col items-center p-4 bg-white shadow-md rounded-xl">
                <div class="relative mb-4">
                    <img id="avatarPreview" src="{{ asset('/images/default.png') }}" alt="Ảnh cá nhân"
                        class="w-48 h-48 rounded-xl border-2 border-teal-300 object-cover">
                    <label
                        class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-teal-100 transition">
                        <input id="avatarInput" type="file" class="hidden" accept="image/*" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z"></path>
                        </svg>
                    </label>
                </div>

                <ul class="flex flex-col w-full text-center gap-2 mt-2 text-gray-800" id="menu-tabs">
                    <li><a href="#wallet"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Ví</a>
                    </li>
                    <li><a href="#transaction"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Giao
                            dịch</a></li>
                    <li><a href="#profile"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Thông tin
                            cá nhân</a></li>
                </ul>
            </div>

            <div class="col-span-2 flex flex-col justify-center p-6 bg-white shadow-md rounded-xl">
                <div id="wallet" class="tab-content">
                    <h2 class="text-2xl font-bold text-teal-600 mb-4">Ví của bạn</h2>
                    <p>Số dư: 1.500.000 VND</p>
                    <p>Loại tiền tệ: VND</p>
                </div>

                <div id="transaction" class="tab-content hidden">
                    <h2 class="text-2xl font-bold text-teal-600 mb-4">Lịch sử Giao Dịch</h2>
                    <ul class="list-disc list-inside">
                        <li>Chi tiêu cà phê -50.000 VND (24/06/2025)</li>
                        <li>Nhận lương +10.000.000 VND (01/06/2025)</li>
                    </ul>
                </div>

                <div id="profile" class="tab-content hidden">
                    <h2 class="text-2xl font-bold text-teal-600 mb-4">Thông Tin Cá Nhân</h2>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Họ tên:</span> Nguyễn Văn A</p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Chức vụ:</span> Lập trình viên Web</p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Kỹ năng:</span> PHP, Laravel, Tailwind CSS, JS
                    </p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Mô tả:</span> Tôi có kinh nghiệm làm việc với
                        các dự án web, tích hợp API và tối ưu giao diện người dùng.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.tab-content').hide();
            $('#wallet').show();
            $('#menu-tabs .tab-link[href="#wallet"]')
                .removeClass('hover:bg-teal-50 border border-teal-300')
                .addClass('bg-teal-500 text-white');

            $('#menu-tabs').on('click', '.tab-link', function(e) {
                e.preventDefault();
                var target = $(this).attr('href');

                $('.tab-content').hide();
                $(target).fadeIn(200);

                $('#menu-tabs .tab-link').removeClass('bg-teal-500 text-white').addClass(
                    'hover:bg-teal-50 border border-teal-300');
                $(this).removeClass('hover:bg-teal-50 border border-teal-300').addClass(
                    'bg-teal-500 text-white');
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'OK'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush

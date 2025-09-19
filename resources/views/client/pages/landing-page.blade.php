@extends('client.layouts.master')

@section('title', 'Quản Lý Chi Tiêu')

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
    ];
@endphp

@section('content')
    <div class="w-full space-y-10">
        <div
            class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-3 rounded-custom-sides">
            <div class="text-center mb-8">
                <h1
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-teal-500 flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-wallet"></i> MyExpenseVn
                </h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-teal-500 opacity-50"></div>
                </div>
                <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">
                    Kiểm soát tài chính cá nhân thật đơn giản.
                </h2>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full max-w-sm mb-10">
                <a href="{{ route('auth.client.showFormRegister') }}"
                    class="w-full sm:w-auto bg-teal-500 text-white font-semibold py-3 px-8 rounded-full shadow-md hover:scale-105 transition transform text-center"
                    data-aos="fade-right">
                    Đăng ký ngay
                </a>
                <a href="{{ route('auth.client.showFormLogin') }}"
                    class="w-full sm:w-auto border border-teal-500 text-teal-500 font-semibold py-3 px-8 rounded-full hover:bg-teal-50 hover:scale-105 transition transform text-center"
                    data-aos="fade-left">
                    Đăng nhập
                </a>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center gap-8 w-full max-w-4xl mb-12"
                data-aos="zoom-in">
                <div class="w-full md:w-1/3 flex justify-center">
                    <img class="w-full object-contain max-h-64" src="{{ asset('images/register.png') }}"
                        alt="Hình minh họa trang" loading="lazy">
                </div>
                <div class="w-full md:w-1/3 flex justify-center">
                    <ul class="max-w-xs mx-auto space-y-2 text-left">
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Quản lý chi tiêu dễ dàng
                        </li>
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Thống kê thông minh
                        </li>
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Hoàn toàn miễn phí
                        </li>
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Giao diện trực quan
                        </li>
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Hỗ trợ đa thiết bị
                        </li>
                        <li class="flex items-center gap-x-2">
                            <i class="fa-solid fa-check text-teal-500"></i> Bảo mật tuyệt đối
                        </li>
                    </ul>
                </div>
                <div class="w-full md:w-1/3 flex justify-center">
                    <img class="w-full object-contain max-h-64" src="{{ asset('images/lp.png') }}" alt="Hình minh họa trang"
                        loading="lazy">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-4 max-w-3xl text-center mb-8">
                @foreach ([['icon' => 'fa-chart-line', 'title' => 'Thống kê thông minh'], ['icon' => 'fa-lock', 'title' => 'Bảo mật tuyệt đối'], ['icon' => 'fa-wallet', 'title' => 'Quản lý dễ dàng']] as $feature)
                    <div
                        class="bg-white p-3 shadow hover:shadow-xl transform hover:scale-105 border border-teal-500 transition [border-radius:30px_0_30px_0]">
                        <i class="fa-solid {{ $feature['icon'] }} text-3xl text-teal-500 mb-3"></i>
                        <h3 class="font-medium">{{ $feature['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>

        <div
            class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-3 rounded-custom-sides">

            <div class="text-center mb-8">
                <h2
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-teal-500 flex items-center justify-center">
                    Cách sử dụng & Tính năng hệ thống</h2>
                <div class="w-24 h-1 bg-primary mx-auto rounded-full opacity-50"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full max-w-6xl">
                <div class="bg-gradient-to-br from-white to-teal-50 p-4 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02] duration-200 space-y-6 border border-teal-100"
                    data-aos="fade-right">
                    <h3 class="text-2xl font-extrabold text-teal-500 flex items-center gap-x-3">
                        <i class="fa-solid fa-lightbulb text-3xl text-teal-500 hover:rotate-12 transition"></i>
                        Cách sử dụng
                    </h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Chỉ với vài bước đơn giản, My Expense Vn sẽ giúp bạn quản lý chi tiêu một cách dễ dàng:
                    </p>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start gap-x-3">
                            <i class="fa-solid fa-user-plus text-teal-500 mt-1 text-xl"></i>
                            <span><strong>Tạo tài khoản:</strong> Bạn có thể đăng ký bằng e-mail hoặc tài khoản
                                Google.</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <i class="fa-solid fa-users text-teal-500 mt-1 text-xl"></i>
                            <span><strong>Tạo phòng:</strong> Dễ dàng tạo phòng và mời bạn bè tham gia qua mã mời.</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <i class="fa-solid fa-coins text-teal-500 mt-1 text-xl"></i>
                            <span><strong>Nạp tiền & Ghi chép:</strong> Nạp tiền và ghi chép chi tiêu, hệ thống tự xử lý và
                                chia
                                sẻ công bằng.</span>
                        </li>
                        <li class="flex items-start gap-x-3">
                            <i class="fa-solid fa-chart-pie text-teal-500 mt-1 text-xl"></i>
                            <span><strong>Thống kê:</strong> Xem chi tiết thống kê chi tiêu của cả phòng bất kỳ lúc
                                nào.</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-white to-cyan-50 p-4 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02] duration-200 space-y-6 border border-cyan-100"
                    data-aos="fade-left">
                    <h3 class="text-2xl font-extrabold text-teal-500 flex items-center gap-x-3">
                        <i class="fa-solid fa-cogs text-3xl text-teal-500 hover:rotate-12 transition"></i>
                        Tính năng hệ thống
                    </h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        MyExpenseVn cung cấp đầy đủ công cụ để bạn quản lý chi tiêu hiệu quả mỗi ngày.
                    </p>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-eye text-teal-500 text-xl"></i>
                            Kiểm soát chi tiêu thông minh, dễ hiểu
                        </li>
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-qrcode text-teal-500 text-xl"></i>
                            Quản lý nhóm, phòng và phân quyền
                        </li>
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-file-invoice text-teal-500 text-xl"></i>
                            Ghi chép giao dịch minh bạch, dễ tra cứu
                        </li>
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-tags text-teal-500 text-xl"></i>
                            Phân loại giao dịch và danh mục đa dạng
                        </li>
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-chart-bar text-teal-500 text-xl"></i>
                            Thống kê chi tiêu chi tiết theo thời gian, thành viên, danh mục
                        </li>
                        <li class="flex items-center gap-x-3">
                            <i class="fa-solid fa-shield-alt text-teal-500 text-xl"></i>
                            Bảo mật tuyệt đối, hỗ trợ đa thiết bị
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-3 rounded-custom-sides"
            data-aos="zoom-in">
            <div class="w-full flex flex-col justify-center items-center p-4 space-y-6">
                <h2 class="text-3xl font-extrabold text-teal-500">Câu hỏi thường gặp</h2>
                <p class="text-base text-gray-600 max-w-lg leading-relaxed text-center">
                    Bạn có thể tìm thấy câu trả lời cho các câu hỏi thường gặp bên dưới. Nếu bạn cần thêm hỗ trợ, vui lòng
                    liên
                    hệ đội ngũ của chúng tôi.
                </p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full max-w-2xl text-teal-500 font-medium items-start">
                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="no-fee">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-circle-question text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Ứng dụng có mất phí không?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            MyExpenseVn hoàn toàn miễn phí cho cá nhân. Bạn không cần trả bất kỳ khoản phí nào để sử dụng.
                        </div>
                    </li>

                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="security">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-shield-alt text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Liệu dữ liệu có an toàn không?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            Mọi dữ liệu được mã hóa SSL và bảo mật tuyệt đối. Chỉ bạn và thành viên được mời vào nhóm mới
                            xem
                            được.
                        </div>
                    </li>

                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="friends">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-user-friends text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Làm sao để mời bạn bè vào phòng?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            Sau khi tạo phòng, bạn vào phần "Quản lý phòng" và chọn "Chia sẻ mã mời" để gửi QR code hoặc
                            link
                            mời bạn bè.
                        </div>
                    </li>

                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="can-delete">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-edit text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Giao dịch có chỉnh sửa được không?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            Có, bạn vào danh sách giao dịch, chọn giao dịch cần chỉnh sửa hoặc xóa, sau đó nhấn nút tương
                            ứng.
                        </div>
                    </li>

                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="platform">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-mobile-alt text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Ứng dụng hỗ trợ nền tảng nào?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            MyExpenseVn hiện hỗ trợ web trên mọi trình duyệt desktop và di động. Phiên bản app di động
                            (iOS/Android) đang được phát triển.
                        </div>
                    </li>

                    <li class="flex flex-col p-3 rounded-lg border border-teal-200 hover:bg-teal-50 transition shadow-sm cursor-pointer"
                        id="groups">
                        <div class="flex items-center gap-x-2 w-full">
                            <i class="fa-solid fa-users text-teal-500"></i>
                            <span class="hover:text-teal-600 underline">Hội nhóm sẽ hoạt động thế nào?</span>
                        </div>
                        <div
                            class="faq-content p-4 mt-2 border-t border-teal-100 hidden text-gray-600 text-sm leading-relaxed">
                            Mỗi hội nhóm là một không gian chia sẻ thu chi giữa các thành viên. Các thành viên có thể thêm,
                            chỉnh sửa và xem báo cáo chung.
                        </div>
                    </li>
                </ul>
                <div class="w-full flex justify-center gap-4">
                    <img class="w-full md:w-1/3 object-contain max-h-64" src="{{ asset('images/faq-1.png') }}"
                        alt="FAQ 1">
                    <img class="hidden md:block w-1/3 object-contain max-h-64" src="{{ asset('images/faq.png') }}"
                        alt="FAQ 2">
                    <img class="hidden md:block w-1/3 object-contain max-h-64" src="{{ asset('images/faq-2.png') }}"
                        alt="FAQ 3">
                </div>
            </div>
        </div>

        <div class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-3 rounded-custom-sides"
            data-aos="fade-down">
            <div class="w-full flex flex-col justify-center items-center p-4 space-y-6">
                <h2 class="text-3xl font-extrabold text-teal-500">Đăng Ký Ngay</h2>
                <p class="text-base text-gray-600 max-w-lg leading-relaxed text-center">
                    Đăng ký thành viên của MyExpenseVn để trải nghiệm những tính năng mới nhất từ chúng tôi
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <form id="register-form" action="{{ route('auth.client.register') }}" method="POST"
                            class="space-y-5">
                            @csrf
                            @include('client.components.forms.input', [
                                'icon' => 'user',
                                'label' => trans('auth.registers.first_name'),
                                'name' => 'first_name',
                                'placeholder' => 'Vui Lòng Nhập Tên',
                                'required' => true,
                            ])
                            @include('client.components.forms.input', [
                                'icon' => 'user',
                                'label' => trans('auth.registers.last_name'),
                                'name' => 'last_name',
                                'placeholder' => 'Vui Lòng Nhập Họ',
                                'required' => true,
                            ])
                            @include('client.components.forms.input', [
                                'icon' => 'envelope',
                                'label' => 'Email',
                                'name' => 'email',
                                'placeholder' => 'Vui Lòng Nhập Email',
                                'required' => true,
                            ])
                            @include('client.components.forms.input', [
                                'icon' => 'lock',
                                'label' => trans('auth.registers.password'),
                                'name' => 'password',
                                'placeholder' => 'Vui Lòng Nhập Mật Khẩu',
                                'type' => 'password',
                                'required' => true,
                            ])
                            @include('client.components.forms.input', [
                                'icon' => 'lock',
                                'label' => trans('auth.registers.password_confirmation'),
                                'name' => 'password_confirmation',
                                'placeholder' => 'Vui Lòng Nhập Lại Mật Khẩu',
                                'type' => 'password',
                                'required' => true,
                            ])
                        </form>
                    </div>

                    <div class="flex flex-col justify-center space-y-4">
                        <div class="w-full">
                            <img class="w-full object-contain max-h-64" src="{{ asset('images/register.png') }}"
                                alt="Hình minh họa trang đăng ký">
                        </div>

                        <ul class="mt-4 text-sm text-gray-600 hidden md:grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Quản lý
                                chi
                                tiêu dễ dàng</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Thống kê
                                thông minh</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Hoàn
                                toàn
                                miễn phí</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Giao
                                diện
                                trực quan</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Hỗ trợ
                                đa
                                thiết bị</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-check text-teal-500"></i> Bảo mật
                                tuyệt
                                đối</li>
                        </ul>

                        <button type="submit" form="register-form"
                            class="w-full bg-teal-500 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Đăng Ký
                        </button>

                        <p class="text-center mt-4 text-xs text-gray-500">
                            Đã có tài khoản? <a href="{{ route('auth.client.showFormLogin') }}"
                                class="text-teal-500 hover:underline">Đăng
                                nhập
                                ngay</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('/js/faq-modal.js') }}"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush

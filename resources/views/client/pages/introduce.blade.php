@extends('client.layouts.master')

@section('title', 'Giới Thiệu')

@section('content')
    <div class="w-full space-y-10">
        <div
            class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-6 rounded-custom-sides">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-cyan-500">Giới Thiệu MyExpenseVn</h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
                </div>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    MyExpenseVn là nền tảng quản lý chi tiêu cá nhân và nhóm hoàn toàn miễn phí, giúp bạn kiểm soát tài
                    chính một cách thông minh, dễ dàng và bảo mật tuyệt đối.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl w-full mx-auto">
                <div class="bg-gradient-to-br from-white to-teal-50 p-8 rounded-2xl shadow-lg space-y-5 border border-teal-100"
                    data-aos="fade-right">
                    <h2 class="text-2xl font-bold text-teal-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.761 0 5.304.838 7.379 2.27M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Tác Giả
                    </h2>
                    <p class="text-gray-700 leading-relaxed">
                        <strong class="text-gray-900">Chu Văn Thái Bảo</strong><br>
                        <span class="text-sm text-gray-600">Ngày sinh: 10/04/2004</span><br>
                        <span>Là người sáng lập và phát triển hệ thống <strong>MyExpenseVn</strong> với mục tiêu mang lại
                            một công cụ quản lý tài chính cá nhân hiệu quả, dễ dùng và phù hợp với người Việt.</span>
                    </p>
                </div>

                <div class="bg-gradient-to-br from-white to-teal-50 p-8 rounded-2xl shadow-lg space-y-5 border border-teal-100"
                    data-aos="fade-left">
                    <h2 class="text-2xl font-bold text-teal-600 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m2 0a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2m2-4a4 4 0 018 0v4H7v-4a4 4 0 014-4z" />
                        </svg>
                        Tầm Nhìn & Sứ Mệnh
                    </h2>
                    <ul class="text-gray-700 list-disc pl-5 space-y-2 leading-relaxed">
                        <li>Hình thành thói quen quản lý chi tiêu một cách khoa học, rõ ràng.</li>
                        <li>Đảm bảo sự minh bạch, công bằng khi chia sẻ tài chính nhóm.</li>
                        <li>Liên tục cập nhật công nghệ nhằm tối ưu hóa trải nghiệm người dùng.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('auth.client.showFormRegister') }}"
                    class="bg-teal-500 text-white px-6 py-3 rounded-full font-semibold shadow hover:shadow-lg hover:scale-105 transition">
                    Trải nghiệm ngay
                </a>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach (['faq-1.png', 'faq.png', 'faq-2.png'] as $index => $image)
                    <div class="w-full flex justify-center items-center bg-white rounded-2xl shadow-sm p-4 hover:shadow-md transition"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" data-aos-duration="600">
                        <img class="w-full max-w-xs h-auto object-contain aspect-square" loading="lazy"
                            src="{{ asset('images/' . $image) }}" alt="FAQ {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div
            class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-6 rounded-custom-sides">

            <div class="text-center mb-8">
                <h2
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center">
                    Cách sử dụng & Tính năng hệ thống</h2>
                <div class="w-24 h-1 bg-primary mx-auto rounded-full opacity-50"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full max-w-6xl">
                <div class="bg-gradient-to-br from-white to-teal-50 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02] duration-200 space-y-6 border border-teal-100"
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

                <div class="bg-gradient-to-br from-white to-cyan-50 p-8 rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:scale-[1.02] duration-200 space-y-6 border border-cyan-100"
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
    </div>
@endsection

@push('js')
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

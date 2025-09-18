@extends('client.layouts.master')

@section('title', 'Xác minh Email')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-teal-600">Xác minh Email của bạn</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Trước khi tiếp tục, vui lòng kiểm tra email của bạn và nhấp vào liên kết xác minh.
                </p>
            </div>

            <div class="bg-teal-50 p-4 rounded-lg border border-teal-100 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-700">
                            @auth
                                Chúng tôi đã gửi một liên kết xác minh tới:
                                <strong class="block mt-1 text-teal-700">{{ auth()->user()->email }}</strong>
                            @else
                                Bạn chưa đăng nhập. Hãy <a href="{{ route('auth.client.showFormLogin') }}"
                                    class="text-teal-600 hover:underline">đăng nhập</a> hoặc <a
                                    href="{{ route('auth.client.showFormRegister') }}"
                                    class="text-teal-600 hover:underline">đăng ký</a>.
                            @endauth
                        </p>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-teal-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @auth
                    <form method="POST" action="{{ route('auth.client.verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-teal-500 hover:bg-teal-600">
                            Gửi lại email xác minh
                        </button>
                    </form>

                    <form method="POST" action="{{ route('auth.client.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-teal-200 rounded-md shadow-sm text-base font-medium text-teal-700 bg-white hover:bg-teal-50 mt-2">
                            Đăng xuất
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('auth.client.showFormRegister') }}"
                            class="block text-center px-4 py-2 rounded-md bg-teal-500 text-white">Đăng ký mới</a>
                        <a href="{{ route('auth.client.showFormLogin') }}"
                            class="block text-center px-4 py-2 rounded-md border border-teal-200 text-teal-700">Đăng nhập</a>
                    </div>
                @endauth
            </div>

            <div class="mt-8 pt-6 border-t border-slate-200/50">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></div>
                        <div class="w-2 h-2 rounded-full bg-teal-500 animate-pulse delay-100"></div>
                        <div class="w-2 h-2 rounded-full bg-teal-600 animate-pulse delay-200"></div>
                    </div>
                </div>

                <div class="bg-slate-50/50 rounded-xl p-4 text-center">
                    <p class="text-sm text-slate-600 leading-relaxed">
                        <span class="font-medium text-slate-700">💡 Mẹo:</span> Nếu bạn không
                        thấy email, hãy kiểm tra hộp thư rác (spam) hoặc chờ vài phút.
                    </p>
                    <p class="text-xs text-slate-500 mt-2">
                        Nếu vẫn không có, bạn có thể thử gửi lại email xác minh ở trên.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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

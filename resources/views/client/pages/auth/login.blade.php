@extends('client.layouts.master-blank')

@section('title')
    Đăng Nhập
@endsection

@push('css')
    <style>
        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 5s infinite ease-in-out;
        }

        .animate-spin-slow {
            animation: spin 10s linear infinite;
        }
    </style>
@endpush

@section('content')
    <div class="relative min-h-screen w-full flex items-center justify-center bg-gray-100 p-4 overflow-hidden">
        
        @include('client.pages.auth.elements.background')

        <div class="bg-white rounded-2xl shadow-xl w-full p-8 relative z-10 max-w-md">
            <div class="text-center mb-8">
                <h1
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-wallet"></i> MyExpenseVn
                </h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
                </div>
                <h2 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">Đăng Nhập Thành Viên
                </h2>
            </div>

            <div>
                <form id="login-form" action="{{ route('auth.client.login') }}" method="POST" class="space-y-5">
                    @csrf
                    @include('client.components.forms.input', [
                        'icon' => 'envelope',
                        'label' => 'Email',
                        'name' => 'email',
                        'placeholder' => 'Vui Lòng Nhập Email',
                        'required' => true
                    ])
                    @include('client.components.forms.input', [
                        'icon' => 'lock',
                        'label' => trans('auth.registers.password'),
                        'name' => 'password',
                        'placeholder' => 'Vui Lòng Nhập Mật Khẩu',
                        'type' => 'password',
                        'required' => true
                    ])

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-teal-500 to-cyan-400 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Đăng Nhập
                    </button>
                </form>

                <a href="{{ route('auth.client.redirectToGoogle') }}"
                    class="mt-4 w-full border border-gray-300 rounded-full flex items-center justify-center gap-x-2 py-2 px-4 hover:bg-gray-100 transition">
                    <i class="fa-brands fa-google text-red-500"></i> Đăng Nhập Bằng Google
                </a>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-500 text-center">
                    <p>
                        Chưa có tài khoản?
                        <a href="{{ route('auth.client.showFormRegister') }}" class="text-teal-500 hover:underline">Đăng Ký
                            Ngay</a>
                    </p>
                    <p>
                        <a href="{{ route('auth.client.showFormForgotPassword') }}"
                            class="text-teal-500 hover:underline">Quên
                            mật khẩu?</a>
                    </p>
                </div>

            </div>
            <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">© {{ date('Y') }} MyExpenseVn</p>
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

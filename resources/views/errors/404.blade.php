@extends('client.layouts.master-blank')

@section('title')
    404
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

        <div class="bg-white rounded-2xl shadow-xl w-full p-8 relative z-10 max-w-2xl">
            <div class="w-full flex flex-col justify-center items-center">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/404.png') }}" alt="404 Not Found" class="w-64 h-auto animate-float" />
                </div>

                <h1
                    class="text-4xl font-extrabold text-transparent bg-clip-text bg-teal-500 mb-4 p-2">
                    Oops! Không tìm thấy trang
                </h1>

                <p class="text-gray-600 mb-6">Trang bạn đang cố truy cập không tồn tại hoặc đã bị di chuyển.</p>

                <a href="{{ route('client.index') }}"
                    class="w-full sm:w-auto border border-teal-500 text-teal-500 font-semibold py-3 px-8 rounded-full hover:bg-teal-50 hover:scale-105 transition transform text-center">
                    <i class="fa-solid fa-house"></i> Quay về Trang Chủ
                </a>

                <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">© {{ date('Y') }} MyExpenseVn</p>
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

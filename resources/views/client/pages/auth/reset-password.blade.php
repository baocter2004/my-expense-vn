@extends('client.layouts.master-blank')

@section('title', 'Cập Nhật Mật Khẩu')

@push('css')
@endpush

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
        <i class="fa-solid fa-wallet text-teal-200 absolute top-10 left-10 text-6xl animate-bounce hidden sm:block"></i>
        <i
            class="fa-solid fa-coins text-emerald-200 absolute top-32 right-16 text-5xl animate-spin-slow hidden sm:block"></i>
        <i
            class="fa-solid fa-credit-card text-cyan-200 absolute bottom-16 left-24 text-4xl animate-pulse hidden md:block"></i>
        <i
            class="fa-solid fa-receipt text-cyan-100 absolute bottom-24 right-32 text-7xl animate-bounce-slow hidden md:block"></i>
        <i class="fa-solid fa-piggy-bank text-pink-200 absolute top-20 right-48 text-4xl animate-pulse hidden lg:block"></i>
        <i
            class="fa-solid fa-chart-line text-blue-200 absolute bottom-40 left-10 text-6xl animate-bounce-slow hidden lg:block"></i>
        <i
            class="fa-solid fa-money-bill-wave text-teal-200 absolute top-40 left-40 text-5xl animate-spin-slow hidden lg:block"></i>
        <i
            class="fa-solid fa-hand-holding-dollar text-violet-200 absolute top-24 right-8 text-4xl animate-bounce hidden lg:block"></i>
        <i
            class="fa-solid fa-file-invoice-dollar text-rose-200 absolute bottom-32 left-1/2 text-5xl animate-pulse hidden lg:block"></i>
        <i
            class="fa-solid fa-calculator text-indigo-200 absolute bottom-48 right-48 text-6xl animate-spin-slow hidden lg:block"></i>

        <div class="bg-white rounded-2xl shadow-xl w-full p-8 relative z-10 max-w-md">
            <div class="text-center mb-8">
                <h1
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-wallet"></i> MyExpenseVn
                </h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
                </div>
                <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">
                    Thay Đổi Mật Khẩu
                </h2>
            </div>

            <div>
                <form id="reset-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ request('token') }}">
                    <input type="hidden" name="email" value="{{ request('email') }}">

                    @include('client.components.forms.input', [
                        'icon' => 'lock',
                        'label' => 'Mật khẩu mới',
                        'name' => 'password',
                        'type' => 'password',
                        'placeholder' => 'Nhập mật khẩu mới',
                    ])

                    @include('client.components.forms.input', [
                        'icon' => 'lock',
                        'label' => 'Xác nhận mật khẩu',
                        'name' => 'password_confirmation',
                        'type' => 'password',
                        'placeholder' => 'Nhập lại mật khẩu',
                    ])

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-teal-500 to-cyan-400 text-white font-semibold py-2 rounded-full">
                        Cập nhật mật khẩu
                    </button>
                </form>
            </div>
            <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">© {{ date('Y') }} MyExpenseVn</p>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#reset-form').on('submit', function(e) {
                e.preventDefault();
                const data = $(this).serialize();

                $.post('/api/password/reset', data)
                    .done(res => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: res.message ||
                                'Mật khẩu đã được cập nhật. Vui lòng đăng nhập lại!',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    })
                    .fail(xhr => {
                        let msg = 'Có lỗi xảy ra, vui lòng thử lại.';
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            msg = Object.values(errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            html: msg,
                            confirmButtonText: 'OK'
                        });
                    });
            });
        });
    </script>
@endpush

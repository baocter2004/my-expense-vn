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
                <h2 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">
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
                        'required' => true
                    ])

                    @include('client.components.forms.input', [
                        'icon' => 'lock',
                        'label' => 'Xác nhận mật khẩu',
                        'name' => 'password_confirmation',
                        'type' => 'password',
                        'placeholder' => 'Nhập lại mật khẩu',
                        'required' => true
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

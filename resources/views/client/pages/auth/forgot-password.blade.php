@extends('client.layouts.master-blank')

@section('title')
    Quên Mật Khẩu
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
                <h2 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">
                    Quên Mật Khẩu
                </h2>
            </div>

            <div>

                <form id="forgot-form" class="space-y-5">
                    @csrf
                    @include('client.components.forms.input', [
                        'icon' => 'envelope',
                        'label' => 'Email',
                        'name' => 'email',
                        'placeholder' => 'Vui Lòng Nhập Email',
                        'required' => true
                    ])

                    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button type="submit"
                            class="w-full gap-x-2 bg-gradient-to-r from-teal-500 to-cyan-400 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center shadow hover:shadow-lg transition">
                            <i class="fa-solid fa-paper-plane"></i> Gửi Mail
                        </button>
                        <a href="{{ route('auth.client.showFormLogin') }}"
                            class="w-full gap-x-2 py-2 px-4 border border-teal-500 text-teal-500 font-semibold rounded-full flex items-center justify-center shadow hover:shadow-lg transition">
                            <i class="fa-solid fa-arrow-left"></i> Quay Lại
                        </a>
                    </div>
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

            $('#forgot-form').on('submit', function(e) {
                e.preventDefault();

                let email = $(this).find('input[name="email"]').val().trim();
                if (!email) {
                    return Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Vui lòng nhập email.',
                        confirmButtonText: 'OK'
                    });
                }

                $.post('/api/password/email', {
                        email: email
                    })
                    .done(function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: res.message ||
                                'Link khôi phục đã được gửi vào email của bạn.',
                            confirmButtonText: 'OK'
                        });
                        $('#forgot-form')[0].reset();
                    })
                    .fail(function(xhr) {
                        let msg = 'Có lỗi xảy ra, vui lòng thử lại.';
                        if (xhr.status === 422 && xhr.responseJSON.errors && xhr.responseJSON.errors
                            .email) {
                            msg = xhr.responseJSON.errors.email[0];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            text: msg,
                            confirmButtonText: 'OK'
                        });
                    });
            });
        });
    </script>
@endpush

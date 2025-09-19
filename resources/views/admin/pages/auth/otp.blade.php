@extends('admin.layouts.master-blank')

@section('title')
    Xác Nhận OTP Quản Trị Viên
@endsection

@section('content')
    <div class="relative min-h-screen w-full flex items-center justify-center bg-gray-100 p-4 overflow-hidden">

        @include('admin.components.elements.back-ground-auth')

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative z-10">
            <div class="text-center mb-8">
                <h1
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-teal-500 flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-shield-halved"></i> MyExpenseVn
                </h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-teal-500 opacity-50"></div>
                </div>
                <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">
                    Nhập mã OTP đã gửi qua email
                </h2>
                <p class="text-xs text-gray-500 mt-2">Mã OTP có hiệu lực trong 5 phút</p>
            </div>

            <form action="{{ route('auth.admin.otp.verify') }}" method="POST" class="space-y-6">
                @csrf
                <div class="flex justify-center gap-2">
                    @for ($i = 1; $i <= 6; $i++)
                        <input type="text" name="otp[]"
                            maxlength="1"
                            class="w-10 h-12 border rounded-lg text-center text-lg font-bold focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none" />
                    @endfor
                </div>

                @include('admin.components.elements.button', [
                    'type' => 'submit',
                    'text' => 'Xác Nhận OTP',
                    'icon' => 'key',
                ])
            </form>

            <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">© {{ date('Y') }} MyExpenseVn</p>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const inputs = document.querySelectorAll('input[name="otp[]"]');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
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
    </script>
@endpush

@extends('admin.layouts.master-blank')

@section('title')
    Đăng Nhập Quản Trị Viên
@endsection

@section('content')
    <div class="relative min-h-screen w-full flex items-center justify-center bg-gray-100 p-4 overflow-hidden">

        @include('admin.components.elements.back-ground-auth')

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative z-10">
            <div class="text-center mb-8">
                <h1
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-teal-500 flex items-center justify-center gap-x-2">
                    <i class="fa-solid fa-wallet"></i> MyExpenseVn
                </h1>
                <div class="my-2 flex justify-center">
                    <div class="w-20 h-1 rounded-full bg-teal-500 opacity-50"></div>
                </div>
                <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">Đăng Nhập Quản Trị</h2>
            </div>

            <form action="{{ route('auth.admin.login') }}" method="POST" class="space-y-5">
                @csrf
                @include('admin.components.forms.input', [
                    'icon' => 'wallet',
                    'label' => 'Email',
                    'name' => 'email',
                    'placeholder' => 'Vui Lòng Nhập Email',
                    'required' => true
                ])
                @include('admin.components.forms.input', [
                    'icon' => 'lock',
                    'label' => 'Password',
                    'name' => 'password',
                    'placeholder' => 'Vui Lòng Nhập Mật Khẩu',
                    'type' => 'password',
                    'required' => true
                ])
                @include('admin.components.elements.button', [
                    'type' => 'submit',
                    'text' => 'Đăng Nhập',
                    'icon' => 'arrow-right-to-bracket',
                ])
            </form>

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

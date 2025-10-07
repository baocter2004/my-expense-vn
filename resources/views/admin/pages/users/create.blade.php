@extends('admin.layouts.master')

@section('title')
    My Expense VN - Thêm mới người dùng
@endsection

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Users', 'url' => route('admin.users.index')],
        ['label' => 'Create'],
    ];
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Tạo mới Người Dùng</h1>
                <p class="text-sm text-slate-500 mt-1">Thêm mới người dùng vào hệ thống</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6" id="userForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('client.components.forms.input', [
                        'name' => 'first_name',
                        'label' => 'Tên',
                        'icon' => 'user',
                        'placeholder' => 'Nhập tên',
                        'value' => old('first_name'),
                        'required' => true,
                    ])

                    @include('client.components.forms.input', [
                        'name' => 'last_name',
                        'label' => 'Họ',
                        'icon' => 'user',
                        'placeholder' => 'Nhập họ',
                        'value' => old('last_name'),
                        'required' => true,
                    ])
                </div>

                @include('client.components.forms.input', [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Email',
                    'icon' => 'envelope',
                    'placeholder' => 'Nhập email',
                    'value' => old('email'),
                    'required' => true,
                ])

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('client.components.forms.input', [
                        'name' => 'password',
                        'type' => 'password',
                        'label' => 'Mật khẩu',
                        'icon' => 'lock',
                        'placeholder' => 'Nhập mật khẩu',
                        'required' => true,
                    ])

                    @include('client.components.forms.input', [
                        'name' => 'password_confirmation',
                        'type' => 'password',
                        'label' => 'Xác nhận mật khẩu',
                        'icon' => 'lock',
                        'placeholder' => 'Nhập lại mật khẩu',
                        'required' => true,
                    ])
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('client.components.forms.select', [
                        'name' => 'gender',
                        'label' => 'Giới tính',
                        'icon' => 'venus-mars',
                        'placeholder' => 'Chọn giới tính',
                        'options' => \App\Consts\UserConst::GENDER,
                        'value' => old('gender'),
                    ])

                    @include('client.components.forms.date', [
                        'name' => 'birth_date',
                        'label' => 'Ngày sinh',
                        'icon' => 'calendar',
                        'placeholder' => 'Chọn ngày sinh',
                        'value' => old('birth_date'),
                    ])
                </div>

                @include('client.components.forms.input', [
                    'name' => 'avatar',
                    'type' => 'file',
                    'label' => 'Ảnh đại diện',
                    'icon' => 'image',
                ])

                @include('client.components.forms.select', [
                    'name' => 'is_active',
                    'label' => 'Trạng thái',
                    'icon' => 'toggle-on',
                    'placeholder' => 'Chọn trạng thái',
                    'options' => [
                        1 => 'Hoạt động',
                        2 => 'Không hoạt động'
                    ],
                    'value' => old('is_active', 1),
                ])

                @include('client.components.forms.text-area', [
                    'name' => 'reason_for_unactive',
                    'label' => 'Lý do không hoạt động',
                    'icon' => 'comment',
                    'placeholder' => 'Nhập lý do (nếu có)',
                    'value' => old('reason_for_unactive'),
                    'rows' => 3,
                ])
            </form>
        </div>

        <div class="w-full bg-white p-4 md:p-6  rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <button form="userForm" type="submit"
                class="w-full bg-teal-500 text-white py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                <i class="fa-solid fa-save"></i>
                Tạo người dùng
            </button>

            <a href="{{ route('admin.users.index') }}"
                class="bg-white border border-teal-500 text-teal-500 hover:bg-teal-50 hover:border-teal-600 py-3 px-4 rounded-xl text-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-list text-lg"></i>
                <span class="hidden sm:inline">Quay lại</span>
            </a>
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

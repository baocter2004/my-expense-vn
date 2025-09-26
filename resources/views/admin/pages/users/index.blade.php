@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    My Expense VN - Admin Dashboard
@endsection

@php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Users']];
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Danh Sách Người Dùng</h1>
                <p class="text-sm text-slate-500 mt-1">Quản lý danh sách người dùng</p>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.forms.input', [
                    'label' => 'Họ',
                    'name' => 'last_name',
                    'placeholder' => 'Nhập họ người dùng...',
                ])

                @include('admin.components.forms.input', [
                    'label' => 'Tên',
                    'name' => 'first_name',
                    'placeholder' => 'Nhập tên người dùng...',
                ])
            </div>

            @include('admin.components.forms.input', [
                'label' => 'Email',
                'name' => 'email',
                'placeholder' => 'Nhập email...',
            ])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.forms.select', [
                    'label' => 'Giới tính',
                    'name' => 'gender',
                    'placeholder' => 'Vui lòng chọn',
                    'options' => \App\Consts\UserConst::GENDER,
                ])

                @include('admin.components.forms.select', [
                    'label' => 'Trạng thái',
                    'name' => 'is_active',
                    'options' => \App\Consts\GlobalConst::STATUS,
                ])
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.forms.date', [
                    'label' => 'Ngày tạo từ',
                    'name' => 'from_date',
                ])

                @include('admin.components.forms.date', [
                    'label' => 'Ngày tạo đến',
                    'name' => 'to_date',
                ])
            </div>
            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="px-5 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 transition">
                    Lọc
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                    Xóa lọc
                </a>
            </div>
        </form>


        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition my-4 h-full flex flex-col justify-between">

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

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

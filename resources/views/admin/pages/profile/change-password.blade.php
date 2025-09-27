@extends('admin.layouts.master')

@section('title')
    Đổi mật khẩu
@endsection

@php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Đổi Mật Khẩu']];
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Đổi Mật Khẩu</h1>
                <p class="text-sm text-slate-500 mt-1">Thay đổi mật khẩu của bạn</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
            <form action="{{ route('admin.profile.change-password') }}" method="POST" class="space-y-5">
                @csrf
                @include('admin.components.forms.input', [
                    'icon' => 'lock',
                    'label' => __('label.password'),
                    'name' => 'password',
                    'placeholder' => 'Vui Lòng Nhập Mật Khẩu',
                    'type' => 'password',
                    'required' => true,
                ])
                @include('admin.components.forms.input', [
                    'icon' => 'lock',
                    'label' => __('label.new_password'),
                    'name' => 'new_password',
                    'placeholder' => 'Vui Lòng Nhập Mật Khẩu Mới',
                    'type' => 'password',
                    'required' => true,
                ])
                @include('admin.components.forms.input', [
                    'icon' => 'lock',
                    'label' => __('label.again_new_password'),
                    'name' => 'again_new_password',
                    'placeholder' => 'Vui Lòng Nhập Lại Mật Khẩu Mới',
                    'type' => 'password',
                    'required' => true,
                ])
                <div class="w-40">
                    @include('admin.components.elements.button', [
                        'type' => 'submit',
                        'text' => 'Đổi Mật Khẩu',
                        'icon' => 'arrow-right-to-bracket',
                    ])
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
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

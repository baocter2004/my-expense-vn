@extends('admin.layouts.master')

@section('title', 'Trang Cá Nhân')

@php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Trang Cá Nhân']];
    $admin = Auth::guard('admin')->user();
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-center">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Trang Cá Nhân</h1>
                <p class="text-sm text-slate-500 mt-1">Thông tin và cài đặt tài khoản</p>
            </div>

            <div class="flex justify-end">
                <p class="text-slate-600 text-sm">
                    <i class="fa-solid fa-circle-info text-teal-500 mr-2"></i>
                    Quản lý hồ sơ cá nhân của bạn
                </p>
            </div>

            <div class="flex justify-end">
                <label class="flex items-center cursor-pointer">
                    <span class="mr-2 text-sm text-slate-600">Đổi mật khẩu</span>
                    <div class="relative">
                        <input type="checkbox" id="toggleForm" class="sr-only" />
                        <div class="w-14 h-7 bg-gray-300 rounded-full shadow-inner transition"></div>
                        <div
                            class="dot absolute w-6 h-6 bg-white rounded-full top-0.5 left-0.5 transition transform shadow-md">
                        </div>
                    </div>
                    <span class="ml-2 text-sm text-slate-600">Đổi thông tin</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition">
                <div class="flex items-center space-x-4 mb-5">
                    <div
                        class="w-16 h-16 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xl">
                        {{ strtoupper(substr($admin->first_name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">
                            {{ $admin->last_name . ' ' . $admin->first_name }}
                        </h2>
                        <p class="text-gray-500 text-sm">{{ $admin->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3 text-gray-700">
                    <div class="flex items-center border rounded-lg px-4 py-3 shadow-sm">
                        <i class="fa-solid fa-id-card mr-3 text-teal-500 w-5 text-center"></i>
                        <span class="font-medium w-28">Họ:</span>
                        <span class="text-slate-800">{{ $admin->last_name }}</span>
                    </div>

                    <div class="flex items-center border rounded-lg px-4 py-3 shadow-sm">
                        <i class="fa-solid fa-user mr-3 text-teal-500 w-5 text-center"></i>
                        <span class="font-medium w-28">Tên:</span>
                        <span class="text-slate-800">{{ $admin->first_name }}</span>
                    </div>

                    <div class="flex items-center border rounded-lg px-4 py-3 shadow-sm">
                        <i class="fa-solid fa-envelope mr-3 text-teal-500 w-5 text-center"></i>
                        <span class="font-medium w-28">Email:</span>
                        <span class="text-slate-800">{{ $admin->email }}</span>
                    </div>

                    <div class="flex items-center border rounded-lg px-4 py-3 shadow-sm">
                        <i class="fa-solid fa-calendar mr-3 text-teal-500 w-5 text-center"></i>
                        <span class="font-medium w-28">Tạo ngày:</span>
                        <span class="text-slate-800">{{ $admin->created_at?->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex items-center border rounded-lg px-4 py-3 shadow-sm">
                        <i class="fa-solid fa-clock-rotate-left mr-3 text-teal-500 w-5 text-center"></i>
                        <span class="font-medium w-28">Cập nhật:</span>
                        <span class="text-slate-800">{{ $admin->updated_at?->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <div id="passwordForm"
                class="md:col-span-2 relative bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition">
                <div id="password-loader"
                    class="hidden absolute inset-0 bg-white/60 backdrop-blur-sm z-20 flex items-center justify-center rounded-xl">
                    <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Đổi mật khẩu</h3>
                <form action="{{ route('admin.profile.change-password') }}" method="POST" class="space-y-5">
                    @csrf
                    @include('admin.components.forms.input', [
                        'icon' => 'lock',
                        'label' => __('label.password'),
                        'name' => 'password',
                        'placeholder' => 'Nhập mật khẩu hiện tại',
                        'type' => 'password',
                        'required' => true,
                    ])
                    @include('admin.components.forms.input', [
                        'icon' => 'lock',
                        'label' => __('label.new_password'),
                        'name' => 'new_password',
                        'placeholder' => 'Nhập mật khẩu mới',
                        'type' => 'password',
                        'required' => true,
                    ])
                    @include('admin.components.forms.input', [
                        'icon' => 'lock',
                        'label' => __('label.again_new_password'),
                        'name' => 'again_new_password',
                        'placeholder' => 'Nhập lại mật khẩu mới',
                        'type' => 'password',
                        'required' => true,
                    ])
                    <div>
                        @include('admin.components.elements.button', [
                            'type' => 'submit',
                            'text' => 'Cập nhật mật khẩu',
                            'icon' => 'arrow-right-to-bracket',
                        ])
                    </div>
                </form>
            </div>

            <div id="infoForm"
                class="md:col-span-2 relative bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition hidden">
                <div id="info-loader"
                    class="hidden absolute inset-0 bg-white/60 backdrop-blur-sm z-20 flex items-center justify-center rounded-xl">
                    <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Cập nhật thông tin</h3>
                <form action="{{ route('admin.profile.update-profile') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    @include('admin.components.forms.input', [
                        'icon' => 'id-card',
                        'label' => 'Họ',
                        'name' => 'last_name',
                        'placeholder' => 'Nhập họ',
                        'type' => 'text',
                        'value' => $admin->last_name,
                        'required' => true,
                    ])

                    @include('admin.components.forms.input', [
                        'icon' => 'user',
                        'label' => 'Tên',
                        'name' => 'first_name',
                        'placeholder' => 'Nhập tên',
                        'type' => 'text',
                        'value' => $admin->first_name,
                        'required' => true,
                    ])

                    @include('admin.components.forms.input', [
                        'icon' => 'envelope',
                        'label' => 'Email',
                        'name' => 'email',
                        'placeholder' => 'Nhập email',
                        'type' => 'email',
                        'value' => $admin->email,
                        'required' => true,
                    ])
                    <div>
                        @include('admin.components.elements.button', [
                            'type' => 'submit',
                            'text' => 'Lưu thay đổi',
                            'icon' => 'floppy-disk',
                        ])
                    </div>
                </form>
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
            $("#toggleForm").change(function() {
                if ($(this).is(":checked")) {
                    $("#passwordForm").hide();
                    $("#info-loader").removeClass("hidden");
                    $("#infoForm").show();
                    $(".dot").addClass("translate-x-7 bg-teal-500");

                    setTimeout(() => {
                        $("#info-loader").addClass("hidden");
                    }, 300);
                } else {
                    $("#infoForm").hide();
                    $("#password-loader").removeClass("hidden");
                    $("#passwordForm").show();
                    $(".dot").removeClass("translate-x-7 bg-teal-500");

                    setTimeout(() => {
                        $("#password-loader").addClass("hidden");
                    }, 300);
                }
            });
        });
    </script>
@endpush

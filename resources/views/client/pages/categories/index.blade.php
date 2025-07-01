@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Thông Tin Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Thông tin cá nhân'],
    ];
@endphp

@section('content')
    <div
        class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4">
        <div class="text-center mb-8">
            <h1
                class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                <i class="fa-solid fa-wallet"></i> MyExpenseVn
            </h1>
            <div class="my-2 flex justify-center">
                <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
            </div>
            <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">Thông Tin Trang Cá Nhân</h2>

            <h3 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">
                Xin chào <span class="text-teal-600 underline decoration-2 decoration-cyan-400 decoration-dotted">
                    {{ $user->fullname }}
                </span> ,
                {{ $greeting }}
            </h3>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-8 max-w-5xl w-full">
            <div class="flex flex-col items-center p-4 bg-white shadow-md rounded-xl">
                <form id="avatarForm" action="{{ route('client.update-avatar') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="relative mb-4">
                        <img id="avatarPreview"
                            src="{{ isset($user->avatar) ? Storage::url($user->avatar) : asset('/images/default.png') }}"
                            alt="Ảnh cá nhân"
                            class="w-full sm:w-48 h-auto sm:h-48 rounded-xl border-2 border-teal-300 object-cover">

                        <label
                            class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-teal-100 transition">
                            <input id="avatarInput" name="avatar" type="file" class="hidden" accept="image/*" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z"></path>
                            </svg>
                        </label>
                    </div>
                    @if ($errors->has('avatar'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('avatar') }}</p>
                    @endif
                </form>

                <ul class="flex flex-col w-full text-center gap-2 mt-2 text-gray-800" id="menu-tabs">
                    <li>
                        <a href="#profile"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition"
                            data-step="1" data-intro="Đây là tab Thông tin cá nhân">Thông tin
                            cá nhân</a>
                    </li>
                    <li>
                        <a href="#change-password"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Đổi mật
                            khẩu</a>
                    </li>
                    <li>
                        <a href="#wallet"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Ví</a>
                    </li>
                    <li>
                        <a href="#transaction"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Giao
                            dịch</a>
                    </li>
                    <li>
                        <a href="#categories"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Danh
                            Mục</a>
                    </li>
                </ul>
            </div>

            <div
                class="md:col-span-3 relative flex flex-col justify-center p-2 md:p-6 bg-white shadow-md rounded-xl space-y-8">
                <div id="tab-loader"
                    class="hidden absolute inset-0 bg-white/60 backdrop-blur-sm z-20 flex items-center justify-center rounded-xl">
                    <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
                </div>
                <div id="profile" class="tab-content hidden">
                    @include('client.pages.profile.elements.profile')
                </div>

                <div id="change-password" class="tab-content hidden">
                    @include('client.pages.profile.elements.change-password')
                </div>

                <div id="wallet" class="tab-content">
                    @include('client.pages.profile.elements.wallet')
                </div>

                <div id="transaction" class="tab-content hidden">
                    @include('client.pages.profile.elements.transaction')
                </div>

                <div id="categories" class="tab-content hidden">
                    @include('client.pages.profile.elements.categories')
                </div>
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
        });
    </script>
@endpush

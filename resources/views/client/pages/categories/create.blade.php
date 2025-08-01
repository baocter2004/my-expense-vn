@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Danh Mục
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.categories.index'), 'icon' => 'fa-list'],
        ['label' => 'Thêm Mới Danh Mục'],
    ];
@endphp

@section('content')
    <div
        class="w-full mx-auto flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 py-10 px-4 rounded-3xl">
        <div class="text-center mb-8">
            <h1
                class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                <i class="fa-solid fa-wallet"></i> MyExpenseVn
            </h1>
            <div class="my-2 flex justify-center">
                <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
            </div>
            <h2 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">Danh Mục</h2>
            <h3 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">
                Khám phá và quản lý các mục chi tiêu của bạn một cách dễ dàng.
            </h3>
        </div>
        <div class="w-full mx-auto max-w-2xl rounded-xl bg-white border border-gray-200 shadow-lg p-3 md:p-6 relative">
            <div class="flex justify-end">
                <a href="{{ route('client.categories.index') }}"
                    class="border border-teal-300 text-teal-600
              hover:bg-teal-50 font-semibold py-2 px-4 rounded-full
              flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                    <i class="fa-solid fa-list"></i>
                    <span class="hidden md:inline">Về Danh Sách</span>
                </a>
            </div>

            <form action="{{ route('client.categories.store') }}" class="space-y-4 mt-3" method="POST">
                @csrf
                @include('client.components.forms.input', [
                    'icon' => 'tag',
                    'label' => 'Tên Danh Mục',
                    'name' => 'name',
                    'placeholder' => 'Nhập Tên Danh Mục',
                ])

                @include('client.components.forms.text-area', [
                    'icon' => 'align-left',
                    'label' => 'Mô Tả Danh Mục',
                    'name' => 'descriptions',
                    'placeholder' => 'Nhập Mô Tả Danh Mục',
                ])

                <label class="inline-flex relative items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" value="1">
                    <div
                        class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
                    </div>
                    <span
                        class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
                </label>

                @error('is_active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @include('client.components.elements.button', [
                    'type' => 'submit',
                    'text' => 'Thêm mới',
                    'icon' => 'save',
                ])
            </form>
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

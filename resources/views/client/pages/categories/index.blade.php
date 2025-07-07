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
        ['label' => 'Danh Mục Chi Tiêu'],
    ];
@endphp

@section('content')
    <div
        class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 rounded-3xl">
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

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($items as $item)
                <div
                    class="bg-white border border-teal-400 rounded-2xl shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <h3 class="text-lg font-semibold text-teal-600 mb-2">{{ $item?->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $item?->descriptions }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="inline-flex relative items-center cursor-pointer">
                            <input type="checkbox" @if ($item?->is_active) checked @endif class="sr-only peer">
                            <div
                                class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
                            </div>
                            <span
                                class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
                        </label>
                        <div class="space-x-2">
                            <button
                                class="text-sm text-white bg-teal-500 px-3 py-1 rounded-full hover:bg-teal-600 transition">Sửa</button>
                            <button
                                class="text-sm text-white bg-red-500 px-3 py-1 rounded-full hover:bg-red-600 transition">Xoá</button>
                        </div>
                    </div>
                </div>
            @endforeach
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

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

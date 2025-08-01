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
        ['label' => 'Danh Mục', 'url' => route('client.categories.index'), 'icon' => 'fa-list'],
        ['label' => 'Danh Mục Đã Xóa'],
    ];
@endphp

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 rounded-3xl min-h-screen">
        <div class="relative z-10 container mx-auto px-4 py-8">
            @include('client.components.search.form-search', [
                'sloganText' => 'Khám phá và quản lý các mục chi tiêu của bạn một cách dễ dàng.',
                'icon' => 'fa-list',
                'routeSearch' => route('client.categories.trash'),
                'routeIndex' => route('client.categories.index'),
            ])
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse ($items as $item)
                    <div
                        class="bg-white border border-teal-400 rounded-2xl shadow-sm p-3 flex flex-col justify-between hover:shadow-md transition relative">

                        <div class="view-mode" id="view-mode-{{ $item->id }}">
                            <div class="space-y-1 mb-2">
                                <h3 class="text-lg font-semibold text-teal-600 mb-2">{{ $item?->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item?->descriptions }}</p>
                                <div class="text-sm text-gray-500 flex items-center space-x-1">
                                    <i class="fa-solid fa-calendar"></i>
                                    <span>{{ $item->created_at?->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="inline-flex relative items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer toggle-status" data-id="{{ $item->id }}"
                                        data-url="{{ route('client.update-status', ['id' => $item->id]) }}"
                                        @if ($item?->is_active) checked @endif disabled>

                                    <div
                                        class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
                                    </div>

                                    <span
                                        class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
                                </label>
                                <div class="space-x-2">
                                    <form action="{{ route('client.categories.restore', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 text-sm text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                            Khôi phục
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="w-full col-span-full bg-white border border-teal-400 rounded-2xl shadow-sm p-3 flex flex-col justify-center items-center hover:shadow-md transition">
                        Không có dữ liệu.
                    </div>
                @endforelse
            </div>
            <div class="w-full flex justify-end items-center">
                {{ $items->onEachSide(1)->links('client.components.elements.paginate') }}
            </div>
        </div>
    </div>
    @include('client.components.elements.modal')
@endsection

@push('js')
    @include('client.components.scripts.reset', [
        'route' => route('client.categories.trash'),
    ])
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

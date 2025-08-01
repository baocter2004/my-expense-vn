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
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 rounded-3xl min-h-screen">
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

        <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-3 mb-6">
            <div class="md:col-span-2">
                <form method="GET" action="{{ route('client.categories.index') }}" class="w-full">
                    <div
                        class="flex i max-w-[500px] items-center border border-gray-300 rounded-full px-4 py-2 focus-within:border-teal-500 transition">
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            placeholder="Tìm kiếm danh mục..."
                            class="w-full outline-none bg-transparent text-sm md:text-base placeholder-gray-400">
                        <button type="submit" class="text-teal-600 hover:text-teal-800 transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex flex-wrap lg:flex-nowrap items-center justify-start lg:justify-end gap-2 mt-2 lg:mt-0">
                <a href="#" id="reset-search"
                    class="inline-flex items-center gap-2 text-sm md:text-base font-medium px-4 py-2 border border-gray-400 text-gray-700 rounded-full hover:bg-gray-100 transition">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span class="hidden md:inline">Xóa Sạch</span>
                </a>

                <a href="{{ route('client.categories.trash') }}"
                    class="inline-flex items-center gap-2 text-sm md:text-base font-medium px-4 py-2 border border-red-500 text-red-600 rounded-full hover:bg-red-50 transition">
                    <i class="fa-solid fa-trash"></i>
                    <span class="hidden md:inline">Thùng Rác</span>
                </a>

                <a href="{{ route('client.categories.create') }}"
                    class="inline-flex items-center gap-2 text-sm md:text-base font-medium px-4 py-2 border border-teal-300 text-teal-600 rounded-full hover:bg-teal-50 transition">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hidden md:inline">Thêm Mới</span>
                </a>
            </div>
        </div>

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 items-start">
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
                                    @if ($item?->is_active) checked @endif>

                                <div
                                    class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
                                </div>

                                <span
                                    class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
                            </label>
                            <div class="space-x-2">
                                <button
                                    class="btn-edit px-4 py-2 text-sm text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition"
                                    data-id="{{ $item->id }}">
                                    Sửa
                                </button>
                                <button
                                    class="open-delete-modal px-4 py-2 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600 transition"
                                    data-action="{{ route('client.categories.soft-delete', $item->id) }}"
                                    data-title="Xoá {{ $item->name }}"
                                    data-message="Bạn có chắc chắn muốn xoá '{{ $item->name }}'?">
                                    Xoá
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="edit-mode hidden" id="edit-mode-{{ $item->id }}">
                        <form method="POST" action="{{ route('client.categories.update') }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            @include('client.components.forms.input', [
                                'name' => 'name',
                                'label' => trans('categories.name'),
                                'value' => $item->name,
                                'placeholder' => 'Vui Lòng Nhập Tên Danh Mục',
                            ])

                            @include('client.components.forms.text-area', [
                                'name' => 'descriptions',
                                'label' => trans('categories.descriptions'),
                                'value' => $item->descriptions,
                                'placeholder' => 'Vui Lòng Nhập Mô Tả Danh Mục',
                            ])
                            <div class="flex justify-end space-x-2">
                                <button type="button"
                                    class="btn-cancel-edit px-4 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition"
                                    data-id="{{ $item->id }}">
                                    Huỷ
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm text-white bg-teal-500 rounded-lg hover:bg-teal-600 transition">
                                    Lưu
                                </button>
                            </div>
                        </form>
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
    @include('client.components.elements.modal')
@endsection

@push('js')
    @include('client.components.scripts.reset', [
        'route' => route('client.categories.index'),
    ])
    @include('client.components.scripts.update-status')
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                let id = $(this).data('id');
                $('#view-mode-' + id).addClass('hidden');
                $('#edit-mode-' + id).removeClass('hidden');
            });
            $('.btn-cancel-edit').on('click', function() {
                let id = $(this).data('id');
                $('#edit-mode-' + id).addClass('hidden');
                $('#view-mode-' + id).removeClass('hidden');
            });

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

        $('.open-delete-modal').on('click', function() {
            const action = $(this).data('action');
            const title = $(this).data('title') || 'Xác nhận xoá';
            const message = $(this).data('message') || 'Bạn có chắc chắn muốn xoá mục này không?';

            $('#deleteModalForm').attr('action', action);
            $('#modalTitle').text(title);
            $('#modalMessage').text(message);

            $('#deleteModal').removeClass('hidden').addClass('flex');
        });

        function closeDeleteModal() {
            $('#deleteModal').addClass('hidden').removeClass('flex');
        }

        $(document).on('click', '#deleteModal', function(e) {
            if (e.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        });
    </script>
@endpush

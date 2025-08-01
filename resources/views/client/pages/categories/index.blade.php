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
        ['label' => 'Danh Sách'],
    ];
@endphp

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 rounded-3xl min-h-screen">
        <div class="relative z-10 container mx-auto px-4 py-8">
            @include('client.components.search.form-search', [
                'sloganText' => 'Khám phá và quản lý các mục chi tiêu của bạn một cách dễ dàng.',
                'icon' => 'fa-list',
                'routeSearch' => route('client.categories.index'),
                'routeCreate' => route('client.categories.create'),
                'routeTrash' => route('client.categories.trash'),
            ])

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 items-start">
                @forelse ($items as $item)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-400 to-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div class="relative bg-white m-[2px] rounded-2xl p-6">
                            <div class="view-mode" id="view-mode-{{ $item->id }}">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $item->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $item->descriptions }}</p>
                                        <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                            <i class="fa-solid fa-calendar-alt text-teal-500"></i>
                                            <span>{{ $item->created_at?->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>

                                    <label class="inline-flex relative items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer toggle-status"
                                            data-id="{{ $item->id }}"
                                            data-url="{{ route('client.update-status', ['id' => $item->id]) }}"
                                            @if ($item?->is_active) checked @endif>
                                        <div
                                            class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
                                        </div>
                                        <span
                                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
                                    </label>
                                </div>

                                <div class="flex gap-2">
                                    <button
                                        class="btn-edit flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300"
                                        data-id="{{ $item->id }}">
                                        <i class="fa-solid fa-edit mr-2"></i>
                                        Chỉnh sửa
                                    </button>

                                    <button
                                        class="open-delete-modal px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all duration-300"
                                        data-action="{{ route('client.categories.soft-delete', $item->id) }}"
                                        data-title="Xoá {{ $item->name }}"
                                        data-message="Bạn có chắc chắn muốn xoá '{{ $item->name }}'?">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="edit-mode hidden" id="edit-mode-{{ $item->id }}">
                                <form method="POST" action="{{ route('client.categories.update') }}" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <h3 class="text-lg font-bold text-gray-800 mb-4">Chỉnh sửa danh mục</h3>

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

                                    <div class="flex gap-2 pt-4">
                                        <button type="button"
                                            class="btn-cancel-edit flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300"
                                            data-id="{{ $item->id }}">
                                            Huỷ
                                        </button>
                                        <button type="submit"
                                            class="flex-1 px-4 py-2 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                                            Lưu thay đổi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="w-full col-span-full bg-white border border-teal-400 rounded-2xl shadow-sm p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <i class="fa-solid fa-list text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có danh mục nào</h3>
                        <p class="text-gray-600 mb-6">Hãy tạo danh mục đầu tiên để bắt đầu phân loại chi tiêu của bạn</p>
                        <a href="{{ route('client.categories.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                            <i class="fa-solid fa-plus"></i>
                            Tạo danh mục mới
                        </a>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

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

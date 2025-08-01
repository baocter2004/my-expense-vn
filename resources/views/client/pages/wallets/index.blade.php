@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Ví Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách'],
    ];
@endphp

@section('content')
    <div class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 rounded-3xl min-h-screen">
        <div class="relative z-10 container mx-auto px-4 py-8">
            @include('client.components.search.form-search', [
                'sloganText' => 'Quản lý chi tiêu thông minh - Tương lai tài chính vững vàng',
                'icon' => 'fa-wallet',
                'routeSearch' => route('client.wallets.index'),
                'routeCreate' => route('client.wallets.create'),
            ])
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-500">
                                                <i class="fa-solid fa-exchange-alt mr-1"></i>
                                                {{ $item->total_transactions ?? 0 }} giao dịch hôm nay
                                            </span>
                                        </div>
                                    </div>
                                    @if ($item->is_default)
                                        <span
                                            class="px-3 py-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-xs font-semibold rounded-full">
                                            Mặc định
                                        </span>
                                    @endif
                                </div>

                                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-4 mb-4">
                                    <p class="text-sm text-gray-600 mb-1">Số dư hiện tại</p>
                                    <p
                                        class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">
                                        {{ \App\Helpers\Helper::formatPrice(
                                            $item->balance,
                                            \App\Consts\GlobalConst::CURRENCIES[$item->currency] ?? 'VND',
                                            2,
                                        ) }}
                                    </p>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fa-solid fa-calendar-alt mr-2 text-teal-500"></i>
                                        Tạo ngày: {{ $item->created_at?->format('d/m/Y H:i') }}
                                    </div>

                                    @if (!empty($item->note))
                                        <div class="flex items-start text-sm text-gray-600">
                                            <i class="fa-solid fa-sticky-note mr-2 text-amber-500 mt-0.5"></i>
                                            <span class="italic">{{ $item->note }}</span>
                                        </div>
                                    @endif
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
                                <form method="POST" action="{{ route('client.wallets.update', $item->id) }}"
                                    class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <h3 class="text-lg font-bold text-gray-800 mb-4">Chỉnh sửa ví</h3>

                                    @include('client.components.forms.input', [
                                        'name' => 'name',
                                        'label' => trans('wallets.name'),
                                        'value' => $item->name,
                                        'placeholder' => 'Nhập tên ví',
                                    ])

                                    @include('client.components.forms.input', [
                                        'name' => 'balance',
                                        'label' => trans('wallets.balance'),
                                        'type' => 'number',
                                        'value' => $item->balance,
                                        'placeholder' => 'Nhập số dư',
                                        'disabled' => true,
                                    ])

                                    @include('client.components.forms.select', [
                                        'name' => 'currency',
                                        'label' => trans('wallets.currency'),
                                        'options' => \App\Consts\GlobalConst::CURRENCIES,
                                        'value' => $item->currency,
                                    ])

                                    @include('client.components.forms.checkbox', [
                                        'name' => 'is_default',
                                        'checked' => $item->is_default,
                                        'label' => trans('wallets.is_default'),
                                    ])

                                    @include('client.components.forms.text-area', [
                                        'name' => 'note',
                                        'label' => trans('wallets.note'),
                                        'value' => $item->note,
                                        'placeholder' => 'Thêm ghi chú nếu có',
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
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                                <i class="fa-solid fa-wallet text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có ví nào</h3>
                            <p class="text-gray-600 mb-6">Hãy tạo ví đầu tiên để bắt đầu quản lý chi tiêu của bạn</p>
                            <a href="{{ route('client.wallets.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                                <i class="fa-solid fa-plus"></i>
                                Tạo ví mới
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
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
        'route' => route('client.wallets.index'),
    ])

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
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#14b8a6'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
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

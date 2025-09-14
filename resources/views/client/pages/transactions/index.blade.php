@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Giao Dịch Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách'],
    ];

    $statusColors = [
        \App\Consts\TransactionConst::STATUS_PENDING => 'bg-yellow-300 text-yellow-700 border-yellow-300',
        \App\Consts\TransactionConst::STATUS_COMPLETED => 'bg-green-300 text-green-700 border-green-300',
        \App\Consts\TransactionConst::STATUS_REVERSED => 'bg-red-300 text-red-700 border-red-300',
    ];
@endphp

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-2 md:p-4 rounded-3xl min-h-screen">
        <div class="relative z-10 container mx-auto px-4 py-8">
            @include('client.components.search.form-search', [
                'sloganText' => 'Quản lý chi tiêu thông minh - Tương lai tài chính vững vàng',
                'icon' => 'fa-wallet',
                'routeSearch' => route('client.transactions.index'),
                'routeCreate' => route('client.transactions.create'),
            ])

            <div class="w-full flex justify-end items-center gap-6 mt-4 mb-4">

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
                @forelse ($items as $item)
                    <div
                        class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border-2 hover:border-teal-200">
                        <div class="bg-white rounded-3xl overflow-hidden">
                            <div class="bg-teal-50 p-4 sm:p-6 pb-3 sm:pb-4">
                                <div class="flex justify-center mb-4">
                                    <div
                                        class="flex items-center gap-2 px-3 py-2 rounded-full bg-white/80 backdrop-blur-sm shadow-sm">
                                        <span
                                            class="w-[10px] h-[10px] rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-400' }} animate-pulse"></span>
                                        <span class="text-xs font-medium text-gray-700">
                                            {{ \App\Consts\TransactionConst::STATUS_LABELS[$item->status] ?? 'Không xác định' }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ route('client.transactions.show', $item->code) }}" class="block group/link">
                                    <div class="flex items-center gap-3 mb-3 sm:mb-4">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl sm:rounded-2xl shadow-lg group-hover/link:scale-110 transition-transform duration-300">
                                            <i class="fa-solid fa-receipt text-white text-base sm:text-lg"></i>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Mã giao dịch
                                            </div>
                                            <div class="text-base sm:text-lg font-bold text-gray-800 transition-colors duration-300 truncate"
                                                title="{{ $item->code }}">
                                                {{ $item->code }}
                                            </div>
                                        </div>

                                        <i
                                            class="fa-solid fa-chevron-right text-gray-400 group-hover/link:text-teal-500 group-hover/link:translate-x-1 transition-all duration-300 hidden sm:block"></i>
                                    </div>
                                </a>

                                <div class="bg-white/70 backdrop-blur-sm rounded-xl sm:rounded-2xl p-3 sm:p-4 shadow-sm">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-lg sm:rounded-xl flex items-center justify-center shadow-md">
                                                <i class="fa-solid fa-coins text-white text-sm sm:text-base"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs font-medium text-gray-500">Số tiền giao dịch</div>
                                                <div class="text-lg sm:text-xl font-bold text-gray-800">
                                                    {{ \App\Helpers\Helper::formatPrice($item->amount, \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 'VND') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex justify-start sm:justify-end">
                                            <div
                                                class="inline-flex px-2.5 sm:px-3 py-1.5 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                                <span
                                                    class="sm:hidden">{{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] ?? 'N/A' }}</span>
                                                <span
                                                    class="hidden sm:inline">{{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 md:p-6 pt-4 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div
                                        class="flex items-center gap-3 p-3 bg-teal-50 rounded-xl border border-teal-100 hover:bg-teal-100 transition-colors duration-300">
                                        <div
                                            class="w-9 h-9 bg-teal-500 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-tag text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs text-teal-600 font-medium">Danh mục</div>
                                            <div class="text-sm font-semibold text-teal-800 truncate"
                                                title="{{ $item->category->name }}">
                                                {{ $item->category->name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center gap-3 p-3 bg-cyan-50 rounded-xl border border-cyan-100 hover:bg-cyan-100 transition-colors duration-300">
                                        <div
                                            class="w-9 h-9 bg-cyan-500 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-wallet text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs text-cyan-600 font-medium">Ví tiền</div>
                                            <div class="text-sm font-semibold text-cyan-800 truncate"
                                                title="{{ $item->wallet->name }}">
                                                {{ $item->wallet->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl border border-green-100">
                                    <div class="w-9 h-9 bg-green-500 rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-calendar-days text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs text-green-600 font-medium">Thời gian giao dịch</div>
                                        <div class="text-sm font-semibold text-green-800">
                                            {{ \Carbon\Carbon::parse($item->occurred_at)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($item->description))
                                    <div
                                        class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-8 h-8 bg-gray-400 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <i class="fa-solid fa-comment text-white text-xs"></i>
                                            </div>
                                            <div class="flex-1 w-full max-w-[300px]">
                                                <div class="text-xs text-gray-500 font-medium mb-1">Ghi chú</div>
                                                <div
                                                    class="text-sm text-gray-700 truncate overflow-hidden whitespace-nowrap max-w-[150px] md:max-w-[300px]">
                                                    {{ $item->description }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 gap-3 pt-2">
                                    <a href="{{ route('client.transactions.show', $item->code) }}"
                                        class="flex items-center justify-center gap-2 bg-gradient-to-r from-teal-500 to-cyan-500 text-white py-2 px-4 rounded-xl font-medium shadow-lg hover:shadow-xl hover:from-teal-600 hover:to-cyan-600 transform hover:scale-105 transition-all duration-300">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                        <span class="hidden md:inline-block text-sm">Chi tiết</span>
                                    </a>

                                    @if (!$item->is_reversal && $item->status !== \App\Consts\TransactionConst::STATUS_REVERSED)
                                        <a href="{{ route('client.transactions.edit', $item->code) }}"
                                            class="flex items-center justify-center gap-2 bg-white border border-teal-500 text-teal-500 py-2 px-4 rounded-xl font-medium shadow-lg hover:shadow-xl hover:bg-teal-50 transform hover:scale-105 transition-all duration-300">
                                            <i class="fa-solid fa-edit text-sm"></i>
                                            <span class="hidden md:inline-block text-sm">Sửa</span>
                                        </a>
                                    @else
                                        <div
                                            class="flex items-center justify-center gap-2 bg-gray-200 text-gray-500 py-2 px-4 rounded-xl font-medium shadow-md cursor-not-allowed">
                                            <i class="fa-solid fa-ban text-sm"></i>
                                            <span class="hidden md:inline-block text-sm">Không thể sửa</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="absolute inset-0 bg-gradient-to-r from-teal-400/5 to-cyan-400/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-3xl">
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="w-full col-span-full bg-white border border-teal-400 rounded-2xl shadow-sm p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <i class="fa-solid fa-wallet text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có giao dịch nào</h3>
                        <p class="text-gray-600 mb-6">Hãy tạo giao dịch đầu tiên để bắt đầu quản lý chi tiêu của bạn</p>
                        <a href="{{ route('client.transactions.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                            <i class="fa-solid fa-plus"></i>
                            Tạo ví mới
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $items->onEachSide(1)->links('client.components.elements.paginate') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    @include('client.components.scripts.reset', [
        'route' => route('client.transactions.index'),
    ])

    <script>
        $(document).ready(function() {
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
    </script>
@endpush

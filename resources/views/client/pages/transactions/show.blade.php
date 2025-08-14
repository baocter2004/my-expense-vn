@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Giao Dịch Cá Nhân [Chi Tiết]
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.transactions.index'), 'icon' => 'fa-list'],
        ['label' => 'Chi Tiết'],
    ];
@endphp
@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 md:p-6 rounded-3xl min-h-screen">
        <div class="mb-6 p-4 md:p-6 bg-teal-500 rounded-2xl shadow-lg flex items-center gap-4 text-white">
            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-full shadow-md">
                <i class="fa-solid fa-credit-card text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-semibold">Chi Tiết Giao Dịch</h2>
                <p class="text-sm opacity-90">Xem thông tin chi tiết của giao dịch cá nhân</p>
            </div>
        </div>
        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl space-y-4">
            <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-teal-50 text-teal-600">
                                <i class="fa-solid fa-tag" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-600">Danh mục</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 max-w-[220px] md:max-w-none">
                            <div class="text-sm text-gray-700 truncate text-right" title="{{ $item->category->name }}">
                                {{ $item->category->name }}
                            </div>
                            <button onclick="navigator.clipboard?.writeText('{{ $item->category->name }}')"
                                class="ml-1 inline-flex items-center justify-center p-1 rounded-md hover:bg-gray-100"
                                aria-label="Sao chép danh mục">
                                <i class="fa-regular fa-copy text-xs text-gray-400"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-600">
                                <i class="fa-solid fa-wallet" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-600">Ví</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 max-w-[220px] md:max-w-none">
                            <div class="text-sm text-gray-700 truncate text-right" title="{{ $item->wallet->name }}">
                                {{ $item->wallet->name }}
                            </div>
                            <button onclick="navigator.clipboard?.writeText('{{ $item->wallet->name }}')"
                                class="ml-1 inline-flex items-center justify-center p-1 rounded-md hover:bg-gray-100"
                                aria-label="Sao chép tên ví">
                                <i class="fa-regular fa-copy text-xs text-gray-400"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 flex items-center justify-center rounded-md bg-yellow-50 text-yellow-500">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div class="min-w-[110px] text-sm font-medium text-gray-600">Số tiền</div>
                </div>
                <div class="text-sm font-medium text-gray-800 text-right">
                    {{ number_format($item->amount, 2, ',', '.') }}
                    {{ \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 1 }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 flex items-center justify-center rounded-md bg-purple-50 text-purple-500">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </div>
                    <div class="min-w-[110px] text-sm font-medium text-gray-600">Loại</div>
                </div>
                <div
                    class="p-3 {{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type] }} text-sm text-gray-700 text-right">
                    {{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 flex items-center justify-center rounded-md bg-green-50 text-green-500">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div class="min-w-[110px] text-sm font-medium text-gray-600">Ngày</div>
                </div>
                <div class="text-sm text-gray-700 text-right">
                    {{ \Carbon\Carbon::parse($item->occurred_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            @if (!empty($item->description))
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-gray-100 text-gray-500">
                            <i class="fa-solid fa-comment"></i>
                        </div>
                        <div class="text-sm text-gray-700 break-words">
                            {{ $item->description }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <a href="{{ route('client.transactions.edit', $item->code) }}"
                class="w-full bg-teal-300 text-white py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                Chỉnh sửa giao dịch
            </a>

            <a href="{{ route('client.transactions.index') }}"
                class="w-full bg-white text-teal-300 border border-teal-300 py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                Danh sách giao dịch
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
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

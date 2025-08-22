@extends('client.layouts.master')

@section('title', 'Chi Tiết Giao Dịch')

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.transactions.index'), 'icon' => 'fa-list'],
        ['label' => 'Chi Tiết'],
    ];
    $statusColors = [
        \App\Consts\TransactionConst::STATUS_PENDING => 'bg-yellow-300 text-yellow-700 border-yellow-300',
        \App\Consts\TransactionConst::STATUS_COMPLETED => 'bg-green-300 text-green-700 border-green-300',
        \App\Consts\TransactionConst::STATUS_REVERSED => 'bg-red-300 text-red-700 border-red-300',
    ];
@endphp

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 md:p-6 rounded-3xl min-h-screen">
        <div
            class="mb-6 p-4 md:p-6 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl shadow-lg flex items-center gap-4 text-white">
            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-full shadow-md">
                <i class="fa-solid fa-credit-card text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-semibold">Chi Tiết Giao Dịch</h2>
                <p class="text-sm opacity-90">Thông tin chi tiết về giao dịch này</p>
            </div>
        </div>
        ~
        <div class="w-full bg-white p-6 max-w-3xl rounded-2xl shadow-xl space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <div class="max-w-[200px] md:max-w-xs">
                    <div class="text-xs text-gray-500">Mã giao dịch</div>
                    <div class="text-lg font-bold text-teal-600 truncate" title="{{ $item->code }}">
                        {{ $item->code }}
                    </div>
                </div>

                <div class="flex justify-end items-center gap-2">
                    <span class="w-3 h-3 rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-400' }}"></span>
                    <span
                        class="hidden md:inline-block">{{ \App\Consts\TransactionConst::STATUS_LABELS[$item->status] ?? 'Không xác định' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-teal-50 text-teal-600">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Danh mục</div>
                    </div>
                    <div class="text-sm text-gray-800 font-medium truncate text-right" title="{{ $item->category->name }}">
                        {{ $item->category->name }}
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-cyan-50 text-cyan-600">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Ví</div>
                    </div>
                    <div class="text-sm text-gray-800 font-medium truncate text-right" title="{{ $item->wallet->name }}">
                        {{ $item->wallet->name }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-yellow-50 text-yellow-500">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Số tiền</div>
                    </div>
                    <div class="text-sm text-gray-800 font-medium text-right">
                        {{ \App\Helpers\Helper::formatPrice($item->amount, \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 'VND') }}
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-purple-50 text-purple-500">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Loại</div>
                    </div>
                    <div class="text-sm text-gray-800 font-medium text-right">
                        {{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-green-50 text-green-500">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Ngày</div>
                    </div>
                    <div class="text-sm text-gray-800 text-right">
                        {{ \Carbon\Carbon::parse($item->occurred_at)->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 flex items-center justify-center rounded-md bg-red-50 text-red-500">
                            <i class="fa-solid fa-undo"></i>
                        </div>
                        <div class="text-sm font-medium text-gray-600 hidden md:block">Hoàn tác</div>
                    </div>
                    <div class="text-sm text-gray-800 font-medium text-right">
                        {{ $item->is_reversal ? 'Có' : 'Không' }}
                    </div>
                </div>
            </div>

            @if (!empty($item->description))
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-comment text-gray-400 mt-1"></i>
                        <div class="text-sm text-gray-700 break-words">{{ $item->description }}</div>
                    </div>
                </div>
            @endif

            @if (!empty($item->receipt_image))
                <div class="flex flex-col justify-center items-center">
                    <div class="text-sm font-medium text-gray-600 hidden md:block mb-2">Ảnh hóa đơn</div>
                    <img id="image" src="{{ asset('storage/' . $item->receipt_image) }}" alt="Hóa đơn"
                        class="rounded-lg border shadow-sm max-h-80 object-contain">
                </div>
                <div id="image-modal"
                    class="hidden fixed inset-0 bg-black bg-opacity-75 flex flex-col items-center justify-center z-50">
                    <div class="overflow-hidden flex items-center justify-center w-full h-[80%] p-5">
                        <img id="modal-img" src=""
                            class="transition-transform duration-200 ease-in-out h-full rounded-lg shadow-lg select-none">
                    </div>
                </div>
            @endif
        </div>
        <div class="w-full max-w-3xl grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <a href="{{ route('client.transactions.edit', $item->code) }}"
                class="bg-teal-500 text-white py-3 px-4 rounded-xl text-center font-medium shadow hover:shadow-lg transition">
                <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
            </a>
            <a href="{{ route('client.transactions.index') }}"
                class="bg-white border border-teal-500 text-teal-500 py-3 px-4 rounded-xl text-center font-medium shadow hover:shadow-lg transition">
                <i class="fa-solid fa-list"></i> Quay lại danh sách
            </a>
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

            $("#image").on("click", function() {
                let src = $(this).attr("src");
                $("#modal-img").attr("src", src);
                $("#image-modal").removeClass('hidden');
            });

            $("#image-modal").on("click", function () {
                $("#modal-img").removeAttr("src");
                $("#image-modal").addClass('hidden');
            });
        });
    </script>
@endpush

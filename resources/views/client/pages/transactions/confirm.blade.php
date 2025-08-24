@extends('client.layouts.master')

@section('title', 'Xác nhận giao dịch')

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 
                p-4 md:p-8 rounded-3xl min-h-screen">

        <div class="mb-6 p-4 md:p-6 bg-teal-500 rounded-2xl shadow-lg flex items-center gap-4 text-white w-full max-w-3xl">
            <div>
                <h2 class="text-lg md:text-2xl font-semibold">Xác nhận giao dịch</h2>
                <p class="text-sm opacity-90">Vui lòng kiểm tra lại thông tin trước khi lưu</p>
            </div>
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Số tiền</span>
                    <strong class="text-teal-600">{{ number_format($items['amount']) }} đ</strong>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Loại giao dịch</span>
                    <strong
                        class="text-teal-600">{{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$items['transaction_type']] }}</strong>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Ngày giờ</span>
                    <strong>{{ $items['occurred_at'] }}</strong>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Mô tả</span>
                    <strong>{{ $items['description'] ?? '-' }}</strong>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Danh mục</span>
                    <strong>{{ $items['category_name'] ?? $items['category_id'] }}</strong>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Ví</span>
                    <strong>{{ $items['wallet_name'] ?? $items['wallet_id'] }}</strong>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Trạng thái</span>
                    <strong>{{ $items['status'] ?? 'Xác Nhận' }}</strong>
                </div>
            </div>

            @if (!empty($items['receipt_image']))
                <div class="flex flex-col gap-2 mt-4">
                    <span class="text-gray-600">Ảnh hóa đơn</span>
                    <img src="{{ Storage::url($items['receipt_image']) }}" alt="Receipt image"
                        class="rounded-xl border shadow max-h-80 w-full object-contain">
                </div>
            @endif
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <form
                action="{{ !empty($items['code'])
                    ? route('client.transactions.update', $items['code'])
                    : route('client.transactions.store') }}"
                method="POST" class="w-full">
                @csrf

                @if (!empty($items['code']))
                    @method('PUT')
                @endif

                <button
                    class="w-full bg-teal-500 text-white py-3 px-4 rounded-xl flex items-center justify-center 
                   shadow hover:bg-teal-600 transition font-semibold">
                    {{ !empty($items['code']) ? 'Cập nhật giao dịch' : 'Xác nhận giao dịch' }}
                </button>
            </form>

            <a href="{{ !empty($items['code'])
                ? route('client.transactions.edit', $items['code'])
                : route('client.transactions.create') }}"
                class="bg-white border border-teal-500 text-teal-500 hover:bg-teal-50 hover:border-teal-600 py-3 px-4 rounded-xl text-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-list text-lg"></i>
                <span class="hidden sm:inline">Quay lại</span>
            </a>
        </div>

    </div>
@endsection

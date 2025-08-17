@extends('client.layouts.master')

@section('title', 'Xác nhận giao dịch')

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 md:p-6 rounded-3xl min-h-screen">

        <div class="mb-6 p-4 md:p-6 bg-teal-500 rounded-2xl shadow-lg flex items-center gap-4 text-white">
            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-full shadow-md">
                <i class="fa-solid fa-clipboard-check text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-semibold">Xác nhận giao dịch</h2>
                <p class="text-sm opacity-90">Vui lòng kiểm tra lại thông tin trước khi lưu</p>
            </div>
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl space-y-4">
            <div class="flex justify-between"><span>Số tiền:</span> <strong>{{ number_format($items['amount']) }} đ</strong>
            </div>
            <div class="flex justify-between"><span>Loại giao dịch:</span>
                <strong>{{ $items['transaction_type'] == 'income' ? 'Thu nhập' : 'Chi tiêu' }}</strong>
            </div>
            <div class="flex justify-between"><span>Ngày giờ:</span> <strong>{{ $items['occurred_at'] }}</strong></div>
            <div class="flex justify-between"><span>Mô tả:</span> <strong>{{ $items['description'] ?? '-' }}</strong></div>
            <div class="flex justify-between"><span>Danh mục:</span> <strong>{{ $items['category_id'] }}</strong></div>
            <div class="flex justify-between"><span>Ví:</span> <strong>{{ $items['wallet_id'] }}</strong></div>
            <div class="flex justify-between"><span>Trạng thái:</span> <strong>{{ $items['status'] }}</strong></div>
            @if (!empty($items['receipt_image']))
                @if (!empty($items['receipt_image']))
                    <div class="flex flex-col gap-2">
                        <span>Ảnh hóa đơn:</span>
                        <img src="{{ Storage::url($items['receipt_image']) }}" alt="Receipt image"
                            class="rounded-xl border shadow max-h-60 object-contain">
                    </div>
                @endif
            @endif
        </div>


        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <form action="{{ route('client.transactions.store') }}" method="POST">
                @csrf
                <button form="transactions"
                    class="w-full bg-teal-300 text-white py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                    Xác nhận giao dịch
                </button>
            </form>

            <a href="{{ route('client.transactions.index') }}"
                class="w-full bg-white text-teal-300 border border-teal-300 py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                Danh sách giao dịch
            </a>
        </div>
    </div>
@endsection

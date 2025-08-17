@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Giao Dịch Cá Nhân [Thêm mới]
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.transactions.index'), 'icon' => 'fa-list'],
        ['label' => 'Thêm mới'],
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
                <h2 class="text-lg md:text-xl font-semibold">Thêm Mới Giao Dịch</h2>
                <p class="text-sm opacity-90">Xem thông tin chi tiết của giao dịch cá nhân</p>
            </div>
        </div>
        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl">
            <form action="{{ route('client.transactions.confirm') }}" class="space-y-4" method="POST"
                enctype="multipart/form-data" id="transactions">
                @csrf

                @include('client.components.forms.select', [
                    'icon' => 'money-bill',
                    'label' => 'Loại Tiền',
                    'name' => 'currency',
                    'placeholder' => 'Vui lòng chọn loại tiền',
                    'options' => \App\Consts\GlobalConst::CURRENCIES,
                ])

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('client.components.forms.select', [
                        'placeholder' => 'Vui lòng chọn danh mục',
                        'name' => 'category_id',
                        'label' => 'Danh mục',
                        'icon' => 'tags',
                        'options' => $categories,
                    ])

                    @include('client.components.forms.select', [
                        'placeholder' => 'Vui lòng chọn ví tiền',
                        'name' => 'wallet_id',
                        'label' => 'Ví',
                        'icon' => 'wallet',
                        'options' => $wallets,
                    ])
                </div>

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                    @include('client.components.forms.input', [
                        'name' => 'amount',
                        'placeholder' => 'Vui lòng nhập số tiền',
                        'type' => 'number',
                        'label' => 'Số tiền',
                        'icon' => 'money-bill-wave',
                    ])

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="balance_vnd">
                            Số Tiền (VND)
                        </label>
                        <input type="text" id="balance_vnd" name="balance_vnd" value="{{ old('balance_vnd', '0.00') }}"
                            readonly
                            class="block w-full rounded-md border-gray-300 bg-gray-100 py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-300" />
                    </div>
                </div>

                @include('client.components.forms.select', [
                    'name' => 'transaction_type',
                    'label' => 'Loại giao dịch',
                    'icon' => 'exchange-alt',
                    'options' => [
                        \App\Consts\TransactionConst::EXPENSE => 'Chi tiêu',
                        \App\Consts\TransactionConst::INCOME => 'Thu nhập',
                    ],
                ])

                @include('client.components.forms.date', [
                    'name' => 'occurred_at',
                    'label' => 'Ngày giờ giao dịch',
                    'icon' => 'calendar-alt',
                    'with_time' => true
                ])

                @include('client.components.forms.text-area', [
                    'name' => 'description',
                    'placeholder' => 'Thêm ghi chú (tuỳ chọn)',
                    'label' => 'Mô tả',
                    'icon' => 'align-left',
                ])

                @include('client.components.forms.select', [
                    'name' => 'status',
                    'label' => 'Trạng thái',
                    'icon' => 'clipboard-check',
                    'options' => \App\Consts\TransactionConst::STATUS_LABELS,
                ])

                @include('client.components.forms.input', [
                    'name' => 'receipt_image',
                    'type' => 'file',
                    'label' => 'Ảnh hoá đơn',
                    'icon' => 'image',
                ])
            </form>
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <button form="transactions" type="submit"
                class="w-full bg-teal-300 text-white py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                Xác nhận giao dịch
            </button>

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

            const rates = @json(\App\Consts\GlobalConst::EXCHANGE_RATES_TO_VND)

            $('#currency, #amount').on('change input', function() {
                var bal = parseFloat($('#amount').val()) || 0;
                var curr = $('#currency').val();
                var rate = parseFloat(rates[curr]) || 1;
                var vnd = bal * rate;

                $('#balance_vnd').val(
                    vnd.toLocaleString('vi-VN', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    })
                );
            });

            $('#currency').trigger('change');
        });
    </script>
@endpush

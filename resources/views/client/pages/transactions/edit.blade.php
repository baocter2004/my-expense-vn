@extends('client.layouts.master')

@section('title')
    Trang Giao Dịch Cá Nhân - Chỉnh Sửa
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.transactions.index'), 'icon' => 'fa-list'],
        ['label' => 'Chỉnh sửa'],
    ];
@endphp
@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 md:p-6 rounded-3xl min-h-screen">
        <div
            class="w-full max-w-3xl mb-6 p-4 md:p-6 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl shadow-lg flex items-center gap-4 text-white">
            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-full shadow-md">
                <i class="fa-solid fa-credit-card text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-semibold">Chỉnh Sửa Giao Dịch</h2>
                <p class="text-sm opacity-90">Chỉnh sửa thông tin chi tiết của giao dịch cá nhân</p>
            </div>
        </div>
        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl">
            <form action="{{ route('client.transactions.edit-confirm', ['code' => $oldItems['code']]) }}" class="space-y-4"
                method="POST" enctype="multipart/form-data" id="transactions">
                @csrf

                @include('client.components.forms.select', [
                    'icon' => 'money-bill',
                    'label' => 'Loại Tiền',
                    'name' => 'currency',
                    'placeholder' => 'Vui lòng chọn loại tiền',
                    'options' => \App\Consts\GlobalConst::CURRENCIES,
                    'value' => $oldItems['currency'] ?? '',
                ])

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @include('client.components.forms.update-select', [
                        'placeholder' => 'Vui lòng chọn danh mục',
                        'name' => 'category_id',
                        'label' => 'Danh mục',
                        'icon' => 'tags',
                        'options' => $categories,
                        'value' => $oldItems['category_id'] ?? '',
                    ])

                    @include('client.components.forms.select', [
                        'placeholder' => 'Vui lòng chọn ví tiền',
                        'name' => 'wallet_id',
                        'label' => 'Ví',
                        'icon' => 'wallet',
                        'options' => $wallets,
                        'value' => $oldItems['wallet_id'] ?? $defaultWalletId,
                    ])
                </div>

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                    @include('client.components.forms.input', [
                        'name' => 'amount',
                        'placeholder' => 'Vui lòng nhập số tiền',
                        'type' => 'number',
                        'label' => 'Số tiền',
                        'icon' => 'money-bill-wave',
                        'value' => $oldItems['amount'] ?? 0,
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

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                    @include('client.components.forms.select', [
                        'name' => 'transaction_type',
                        'label' => 'Loại giao dịch',
                        'placeholder' => 'Vui lòng chọn loại giao dịch',
                        'icon' => 'exchange-alt',
                        'options' => \App\Consts\TransactionConst::TRANSACTION_TYPE,
                        'value' => $oldItems['transaction_type'] ?? '',
                    ])

                    @include('client.components.forms.date', [
                        'name' => 'occurred_at',
                        'label' => 'Ngày giờ giao dịch',
                        'icon' => 'calendar-alt',
                        'with_time' => true,
                        'value' => $oldItems['occurred_at'] ?? '',
                    ])
                </div>

                @include('client.components.forms.input', [
                    'name' => 'receipt_image',
                    'type' => 'file',
                    'label' => 'Ảnh hoá đơn',
                    'icon' => 'image',
                    'value' => $oldItems['receipt_image'] ?? '',
                ])

                @include('client.components.forms.text-area', [
                    'name' => 'description',
                    'placeholder' => 'Thêm ghi chú (tuỳ chọn)',
                    'label' => 'Mô tả',
                    'icon' => 'align-left',
                    'value' => $oldItems['description'] ?? '',
                ])
            </form>
        </div>

        <div class="w-full bg-white p-4 md:p-6 max-w-3xl rounded-2xl shadow-xl grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <button form="transactions" type="submit"
                class="w-full bg-teal-500 text-white py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                Xác nhận giao dịch
            </button>

            <a href="{{ route('client.transactions.index') }}"
                class="bg-white border border-teal-500 text-teal-500 hover:bg-teal-50 hover:border-teal-600 py-3 px-4 rounded-xl text-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-list text-lg"></i>
                <span class="hidden sm:inline">Quay lại</span>
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
                    title: 'Thất bại!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
                });
            @endif

            const rates = @json(\App\Consts\GlobalConst::EXCHANGE_RATES_TO_VND);
            const walletByCurrency = @json($walletByCurrency);
            const walletBalances = @json($walletBalances);

            const $currency = $('#currency');
            const $wallet = $('#wallet_id');
            const $amount = $('#amount');
            const $balanceVnd = $('#balance_vnd');
            const $submitBtn = $('button[type=submit]');
            const $transactionType = $('#transaction_type');

            function renderWalletOptions(currency, selectedWalletId = null) {
                const meta = walletByCurrency[currency] || {
                    items: {},
                    default: null
                };
                $wallet.empty();

                $wallet.append(
                    `<option value="" disabled ${!selectedWalletId ? 'selected' : ''}>Vui lòng chọn ví tiền</option>`
                );

                for (const [id, label] of Object.entries(meta.items)) {
                    const isSelected = String(id) === String(selectedWalletId) ? 'selected' : '';
                    $wallet.append(`<option value="${id}" ${isSelected}>${label}</option>`);
                }

                if (Object.keys(meta.items).length === 0) {
                    $wallet.prop('disabled', true);
                    if ($('#wallet-empty-note').length === 0) {
                        $wallet.after('<div id="wallet-empty-note" class="mt-2"></div>');
                    }

                    $('#wallet-empty-note').html(`
                        <p class="text-red-500 text-sm">
                            Chưa có ví cho loại tiền này.
                        </p>
                        <a href="{{ route('client.wallets.create') }}"
                        class="inline-block mt-2 px-2 sm:px-3 py-1 bg-teal-500 text-white text-xs sm:text-sm rounded-lg hover:bg-teal-600">
                        + Tạo ví
                        </a>
                    `);
                } else {
                    $wallet.prop('disabled', false);
                    $('#wallet-empty-note').remove();
                }
            }

            function updateBalanceVndAndValidate() {
                const bal = parseFloat($amount.val()) || 0;
                const curr = $currency.val();
                const rate = parseFloat(rates[curr]) || 1;

                const vnd = bal * rate;
                $balanceVnd.val(
                    vnd.toLocaleString('vi-VN', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    })
                );

                const walletId = $wallet.val();
                const walletBalance = parseFloat(walletBalances[walletId] ?? 0) || 0;
                const type = $transactionType.val();

                const formattedBalance = walletBalance.toLocaleString('vi-VN', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                if (type == 2 && bal > walletBalance) {
                    $amount.addClass('border-red-500').removeClass('focus:ring-1 focus:ring-teal-500');
                    if ($('#amount-error').length === 0) {
                        $amount.after(
                            `<p id="amount-error" class="text-red-500 text-sm mt-1">
                        Số tiền vượt quá số dư trong ví (số dư: ${formattedBalance} ${curr})
                    </p>`
                        );
                    } else {
                        $('#amount-error').text(
                            `Số tiền vượt quá số dư trong ví (số dư: ${formattedBalance} ${curr})`
                        );
                    }
                    $submitBtn.prop('disabled', true);
                } else {
                    $amount.removeClass('border-red-500');
                    $('#amount-error').remove();
                    $submitBtn.prop('disabled', $wallet.prop('disabled'));
                }
            }

            $currency.on('change', function() {
                const curr = $(this).val();
                const meta = walletByCurrency[curr] || {};
                const defaultId = meta.default ?? null;
                let selectedWallet = $wallet.val();

                if (!selectedWallet || !(meta.items && selectedWallet in meta.items)) {
                    selectedWallet = defaultId;
                }

                renderWalletOptions(curr, selectedWallet);
                updateBalanceVndAndValidate();
            });

            $wallet.on('change', updateBalanceVndAndValidate);
            $amount.on('input change', updateBalanceVndAndValidate);
            $transactionType.on('change', updateBalanceVndAndValidate);

            @if (!empty($initialCurrency))
                $currency.val('{{ $initialCurrency }}');
            @endif
            $currency.trigger('change');
        });
    </script>
@endpush

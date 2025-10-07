@extends('client.layouts.master')

@section('title')
    Trang Ví Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.wallets.index'), 'icon' => 'fa-list'],
        ['label' => 'Thêm Mới'],
    ];
@endphp

@section('content')
    <div
        class="w-full mx-auto flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 py-10 px-4 rounded-3xl">
        <div class="text-center mb-8">
            <h1
                class="text-2xl font-extrabold bg-clip-text text-transparent bg-teal-500 flex items-center justify-center gap-x-2">
                <i class="fa-solid fa-wallet"></i> MyExpenseVn
            </h1>
            <div class="my-2 flex justify-center">
                <div class="w-20 h-1 rounded-full bg-teal-500 opacity-50"></div>
            </div>
            <h2 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">Ví Tiền </h2>
            <h3 class="text-lg md:text-xl font-medium text-center text-gray-600 tracking-wide">
                Theo dõi, phân loại và kiểm soát số dư các ví của bạn hiệu quả.
            </h3>
        </div>
        <div class="w-full mx-auto max-w-2xl rounded-xl bg-white border border-gray-200 shadow-lg p-3 md:p-6">
            <div class="flex justify-end">
                <a href="{{ route('client.wallets.index') }}"
                    class="border border-teal-300 text-teal-600
              hover:bg-teal-50 font-semibold py-2 px-4 rounded-full
              flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                    <i class="fa-solid fa-list"></i>
                    <span class="hidden md:inline">Về Danh Sách</span>
                </a>
            </div>

            <form action="{{ route('client.wallets.store') }}" class="space-y-4 mt-3" method="POST">
                @csrf

                @include('client.components.forms.input', [
                    'icon' => 'wallet',
                    'label' => 'Tên Ví',
                    'name' => 'name',
                    'placeholder' => 'Nhập tên ví',
                ])

                @include('client.components.forms.select', [
                    'icon' => 'money-bill',
                    'label' => 'Loại Tiền',
                    'name' => 'currency',
                    'placeholder' => 'Vui lòng chọn loại tiền',
                    'options' => \App\Consts\GlobalConst::CURRENCIES,
                ])

                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
                    @include('client.components.forms.input', [
                        'icon' => 'coins',
                        'label' => 'Số Dư Ban Đầu',
                        'name' => 'balance',
                        'placeholder' => 'Nhập số dư (ví dụ 1.000.000)',
                        'type' => 'number',
                    ])

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="balance_vnd">
                            Số Dư (VND)
                        </label>
                        <input type="text" id="balance_vnd" name="balance_vnd" value="{{ old('balance_vnd', '0.00') }}"
                            readonly
                            class="block w-full rounded-md border-gray-300 bg-gray-100 py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-300" />
                    </div>
                </div>

                @include('client.components.forms.checkbox', [
                    'name' => 'is_default',
                    'label' => trans('wallets.is_default'),
                ])

                @include('client.components.forms.text-area', [
                    'icon' => 'pencil-alt',
                    'label' => 'Ghi Chú',
                    'name' => 'note',
                    'placeholder' => 'Nhập ghi chú (nếu có)',
                ])

                @include('client.components.elements.button', [
                    'type' => 'submit',
                    'text' => 'Tạo Ví',
                    'icon' => 'save',
                ])
            </form>
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
    </script>

    <script>
        $(function() {
            var rates = @json(\App\Consts\GlobalConst::EXCHANGE_RATES_TO_VND);

            $('#currency, #balance').on('change input', function() {
                var bal = parseFloat($('#balance').val()) || 0;
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

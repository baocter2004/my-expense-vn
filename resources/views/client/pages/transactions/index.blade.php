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
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-2 md:p-4 rounded-3xl min-h-screen">
        <div class="relative z-10 container mx-auto px-4 py-8">
            @include('client.components.search.form-search', [
                'sloganText' => 'Quản lý chi tiêu thông minh - Tương lai tài chính vững vàng',
                'icon' => 'fa-wallet',
                'routeSearch' => route('client.transactions.index'),
            ])
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
                @forelse ($items as $item)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-400 to-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div class="relative bg-white m-[2px] rounded-2xl p-5 space-y-4">
                            <div class="space-y-4 text-sm text-gray-800">
                                <div
                                    class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-teal-500 pb-2 gap-2">
                                    <div class="flex items-center gap-2 text-lg font-semibold text-teal-600">
                                        <i class="fa-solid fa-receipt"></i>
                                        <span class="md:inline hidden">Mã giao dịch</span>
                                        <span class="inline md:hidden text-base">Mã</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-sm text-gray-700 truncate   max-w-[50%]"
                                        title="{{ $item->code }}">
                                        {{ $item->code }}
                                    </div>
                                </div>

                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 px-4 py-3 rounded-xl shadow-inner">

                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-tag text-teal-500"></i>
                                        <span class="font-medium">Danh mục:</span>
                                        <span>{{ $item->category->name }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-wallet text-cyan-500"></i>
                                        <span class="font-medium">Ví:</span>
                                        <span>{{ $item->wallet->name }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-coins text-yellow-500"></i>
                                        <span class="font-medium">Số tiền:</span>
                                        <span class="inline-block">
                                            {{ number_format($item->amount, 2, ',', '.') }}
                                            {{ \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 1 }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-arrow-left text-purple-500"></i>
                                        <span class="font-medium">Loại:</span>
                                        <span>{{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 md:col-span-2">
                                        <i class="fa-solid fa-calendar-days text-green-500"></i>
                                        <span class="font-medium">Ngày:</span>
                                        <span>{{ \Carbon\Carbon::parse($item->occurred_at)->format('d/m/Y H:i') }}</span>
                                    </div>

                                </div>
                                @if (!empty($item->description))
                                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                        <div class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fa-solid fa-comment text-gray-400 mt-1"></i>
                                            <span>{{ $item->description }}</span>
                                        </div>
                                    </div>
                                @endif
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
                        <a href="{{ route('client.wallets.create') }}"
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

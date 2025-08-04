<div
    class=" mx-auto mb-6 bg-white rounded-lg shadow-sm flex flex-col items-center text-center gap-3
         md:flex-row md:justify-between md:items-center md:text-left md:gap-0 p-4">
    <div class="flex items-center gap-2">
        <h2
            class="flex items-center gap-2 text-lg font-extrabold text-teal-600
           border-b-2 border-teal-200 pb-1 md:pb-0">
            <i class="fa-solid fa-wallet text-teal-500 text-lg md:text-xl"></i> Ví của bạn
        </h2>
    </div>
</div>

<div class="w-full bg-gray-50 p-2 md:p-3 rounded-lg border border-gray-100">
    @if ($wallets->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($wallets as $wallet)
                <div class="p-4 bg-white rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-wallet text-teal-500 text-2xl"></i>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $wallet->name }}</h3>
                        </div>
                        @if ($wallet->is_default)
                            <span class="px-2 py-1 bg-teal-100 text-teal-800 text-xs rounded-full">Mặc định</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-medium text-gray-800">ID: {{ $wallet->id }}</span>
                    </p>
                    <div class="space-y-1 mb-4">
                        <p class="text-sm text-gray-600">
                            Số dư:
                            <span class="font-medium text-gray-800">
                                {{ number_format($wallet->balance, 2, ',', '.') }}
                                {{ \App\Consts\GlobalConst::CURRENCIES[$wallet->currency] }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            Quy đổi VND:
                            <span class="font-medium text-gray-800">
                                {{ number_format($wallet->balance_vnd, 0, ',', '.') }} VND
                            </span>
                        </p>
                    </div>
                    <p class="text-sm text-gray-500">Ghi chú: {{ $wallet->note ?? '—' }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="w-full col-span-full bg-white border border-teal-400 rounded-2xl shadow-sm p-12 text-center">
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
    @endif
</div>

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
        <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
            @foreach ($wallets as $wallet)
                <li class="py-3 px-4 hover:bg-teal-50 transition">
                    <span class="font-semibold">{{ $wallet->name }}:</span>
                    {{ number_format($wallet->balance, 0, ',', '.') }} VND
                </li>
            @endforeach
        </ul>
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

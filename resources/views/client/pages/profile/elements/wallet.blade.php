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
        <p class="text-center text-gray-500 italic">Bạn chưa có ví nào.</p>
    @endif
</div>

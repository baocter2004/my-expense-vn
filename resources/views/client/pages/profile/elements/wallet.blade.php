<div class="flex justify-center items-center">
    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-wallet text-teal-500"></i> Ví của bạn
    </h2>
</div>

<div class="w-full bg-gray-50 p-2 md:p-6 rounded-lg border border-gray-100">
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

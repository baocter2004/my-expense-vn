<h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
    <i class="fa-solid fa-clock-rotate-left text-teal-500"></i> Lịch sử Giao Dịch
</h2>
@if ($transactions->count())
    <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
        @foreach ($transactions as $tx)
            <li class="py-3 px-4 hover:bg-teal-50 transition">
                <span class="font-semibold">{{ $tx->occurred_at }}:</span>
                {{ $tx->description }} — <span
                    class="text-teal-600 font-medium">{{ number_format($tx->amount, 0, ',', '.') }}
                    VND</span>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-center text-gray-500 italic">Bạn chưa có giao dịch nào.</p>
@endif

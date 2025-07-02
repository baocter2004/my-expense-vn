<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 mb-4">
    <h2 class="text-2xl font-extrabold text-teal-600 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left text-teal-500"></i>
        Lịch sử Giao Dịch
    </h2>
    <a href="#"
        class="inline-flex items-center gap-2 text-base font-semibold px-3 py-2 border border-teal-500 text-teal-600 rounded-full hover:bg-teal-50 transition">
        <i class="fa-solid fa-plus"></i>
        Thêm Mới
    </a>
</div>

<div class="w-full bg-gray-50 p-2 md:p-6 rounded-lg border border-gray-100">
    @if ($transactions->count())
        <ul class="space-y-2">
            @foreach ($transactions as $tx)
                <li class="border rounded-lg overflow-hidden shadow-sm">
                    <div
                        class="tx-header w-full flex justify-between items-center px-4 py-3 bg-white hover:bg-teal-50 transition cursor-pointer">
                        <div class="flex flex-col text-left">
                            <span class="text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($tx->occurred_at)->format('d/m/Y H:i') }}
                            </span>
                            <span class="text-gray-500 text-sm truncate" style="max-width: 300px;">
                                {{ Str::limit($tx->description, 50) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span
                                class="font-semibold text-lg {{ $tx->transaction_type == \App\Consts\TransactionConst::INCOME ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->transaction_type == \App\Consts\TransactionConst::INCOME ? '+' : '-' }}
                                {{ number_format($tx->amount, 0, ',', '.') }}₫
                            </span>
                            <svg class="toggle-icon h-5 w-5 text-gray-400 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="tx-body px-4 py-3 bg-gray-50 border-t" style="display: none;">
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                            <div>
                                <span class="font-medium">Mã giao dịch:</span>
                                <p class="break-all">{{ $tx->code }}</p>
                            </div>
                            <div>
                                <span class="font-medium">Loại giao dịch:</span>
                                <p>
                                    {{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$tx->transaction_type] }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <span class="font-medium">Mô tả chi tiết:</span>
                                <p>{{ $tx->description }}</p>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-6 flex justify-end">
            {{ $transactions->onEachSide(1)->links('client.components.elements.paginate') }}
        </div>
    @else
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-200">
            <p class="text-gray-500 italic">Bạn chưa có giao dịch nào.</p>
        </div>
    @endif
</div>

<script>
    $(function() {
        $('.tx-header').on('click', function() {
            var $li = $(this).closest('li');
            var $body = $li.find('.tx-body');
            var $icon = $li.find('.toggle-icon');

            $body.slideToggle(200);

            if ($icon.hasClass('rotated')) {
                $icon.removeClass('rotated').css('transform', 'rotate(0deg)');
            } else {
                $icon.addClass('rotated').css('transform', 'rotate(180deg)');
            }
        });
    });
</script>

<style>
    .toggle-icon {
        transition: transform 0.2s;
    }
</style>

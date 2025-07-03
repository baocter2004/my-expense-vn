<div
    class=" mx-auto mb-6 bg-white rounded-lg shadow-sm flex flex-col items-center text-center gap-3
         md:flex-row md:justify-between md:items-center md:text-left md:gap-0 p-4">
    <h2
        class="flex items-center gap-2 text-lg font-extrabold text-teal-600
           border-b-2 border-teal-200 pb-1 md:pb-0">
        <i class="fa-solid fa-clock-rotate-left text-teal-500 text-xl"></i>
        Lịch sử Giao Dịch
    </h2>

    <a href="#"
        class="inline-flex items-center gap-2 text-sm md:text-base font-medium
            px-4 py-2 border border-teal-300 text-teal-600 rounded-full
            hover:bg-teal-50 transition mt-2 md:mt-0">
        <i class="fa-solid fa-plus"></i>
        Thêm Mới
    </a>
</div>


<div class="w-full bg-gray-50 p-3 md:p-6 rounded-lg border border-gray-100">
    @if ($transactions->count())
        <ul class="space-y-3">
            @foreach ($transactions as $tx)
                <li class="border rounded-lg overflow-hidden shadow-sm">
                    <div
                        class="tx-header flex flex-col md:flex-row md:justify-between md:items-center bg-white border-b border-gray-100 px-4 py-3 hover:shadow-sm hover:bg-teal-50 transition cursor-pointer">
                        <div class="flex flex-col text-left">
                            <span class="text-gray-800 text-base md:text-lg font-semibold">
                                {{ \Carbon\Carbon::parse($tx->occurred_at)->format('d/m/Y H:i') }}
                            </span>
                            <span class="text-gray-500 text-xs md:text-sm truncate max-w-full md:max-w-[300px]">
                                {{ Str::limit($tx->description, 50) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-2 md:mt-0">
                            <span
                                class="font-bold text-base md:text-xl tracking-tight {{ $tx->transaction_type == \App\Consts\TransactionConst::INCOME ? 'text-green-600' : 'text-red-600' }}">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                            <div>
                                <span class="font-medium">Mã giao dịch:</span>
                                <p class="break-all">{{ $tx->code }}</p>
                            </div>
                            <div>
                                <span class="font-medium">Loại giao dịch:</span>
                                <p>{{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$tx->transaction_type] }}</p>
                            </div>
                            <div class="md:col-span-2">
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
            const $li = $(this).closest('li');
            const $body = $li.find('.tx-body');
            const $icon = $li.find('.toggle-icon');

            $body.slideToggle(200);
            $icon.toggleClass('rotated').css('transform', $icon.hasClass('rotated') ? 'rotate(180deg)' :
                'rotate(0deg)');
        });
    });
</script>

<style>
    .toggle-icon {
        transition: transform 0.2s;
    }
</style>

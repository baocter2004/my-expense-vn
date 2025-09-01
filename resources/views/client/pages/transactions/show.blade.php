@extends('client.layouts.master')

@section('title', 'Chi Tiết Giao Dịch')

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Danh Sách', 'url' => route('client.transactions.index'), 'icon' => 'fa-list'],
        ['label' => 'Chi Tiết'],
    ];
    $statusColors = [
        \App\Consts\TransactionConst::STATUS_PENDING => 'bg-yellow-300 text-yellow-700 border-yellow-300',
        \App\Consts\TransactionConst::STATUS_COMPLETED => 'bg-green-300 text-green-700 border-green-300',
        \App\Consts\TransactionConst::STATUS_REVERSED => 'bg-red-300 text-red-700 border-red-300',
    ];
@endphp

@section('content')
    <div
        class="w-full flex flex-col items-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4 md:p-6 rounded-3xl min-h-screen">
        <div
            class="w-full max-w-3xl mb-6 p-4 md:p-6 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl shadow-lg flex flex-col md:flex-row items-center gap-4 text-white">

            <div class="flex items-center justify-center w-14 h-14 bg-white/20 rounded-full shadow-md">
                <i class="fa-solid fa-credit-card text-2xl"></i>
            </div>

            <div class="text-center md:text-left">
                <h2 class="text-lg md:text-xl font-semibold">Chi Tiết Giao Dịch</h2>
                <p class="text-sm opacity-90">Thông tin chi tiết về giao dịch này</p>
            </div>
        </div>
        <div class="w-full bg-white p-6 max-w-3xl rounded-2xl shadow-xl">
            <button id="btn-pdf"
                class="flex items-center gap-2 p-2 border border-teal-500 rounded-lg text-teal-600 hover:bg-teal-50 transition mx-auto md:ml-auto mb-4">
                <i class="fa-solid fa-file-pdf"></i> Xuất PDF
            </button>
            <div id="content-pdf" class="space-y-6">
                <div class="flex items-center justify-between border-b pb-4 gap-4">
                    <div
                        class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl sm:rounded-2xl shadow-lg group-hover/link:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-receipt text-white text-base sm:text-lg"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Mã giao dịch
                        </div>
                        <div class="text-base sm:text-lg font-bold text-gray-800 transition-colors duration-300 truncate"
                            title="{{ $item->code }}">
                            {{ $item->code }}
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-2">
                        <span class="w-3 h-3 rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-400' }}"></span>
                        <span
                            class="hidden md:inline-block">{{ \App\Consts\TransactionConst::STATUS_LABELS[$item->status] ?? 'Không xác định' }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="flex items-center justify-between p-3 bg-teal-50 rounded-xl border border-teal-100 hover:bg-teal-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-teal-500 text-white">
                                <i class="fa-solid fa-tag"></i>
                            </div>
                            <div class="text-sm font-medium text-teal-600 hidden md:block">Danh mục</div>
                        </div>
                        <div class="text-sm text-teal-800 font-medium truncate text-right"
                            title="{{ $item->category->name }}">
                            {{ $item->category->name }}
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 bg-cyan-50 rounded-xl border border-cyan-100 hover:bg-cyan-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-cyan-500 text-white">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div class="text-sm font-medium text-cyan-600 hidden md:block">Ví</div>
                        </div>
                        <div class="text-sm text-cyan-800 font-medium truncate text-right"
                            title="{{ $item->wallet->name }}">
                            {{ $item->wallet->name }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div
                        class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl border border-yellow-100 hover:bg-yellow-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-yellow-500 text-white">
                                <i class="fa-solid fa-coins"></i>
                            </div>
                            <div class="text-sm font-medium text-yellow-600 hidden md:block">Số tiền</div>
                        </div>
                        <div class="text-sm text-yellow-800 font-medium text-right">
                            {{ \App\Helpers\Helper::formatPrice($item->amount, \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 'VND') }}
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 bg-purple-50 rounded-xl border border-purple-100 hover:bg-purple-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-purple-500 text-white">
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                            </div>
                            <div class="text-sm font-medium text-purple-600 hidden md:block">Loại</div>
                        </div>
                        <div class="text-sm text-purple-800 font-medium text-right">
                            {{ \App\Consts\TransactionConst::TRANSACTION_TYPE[$item->transaction_type ?? 1] }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div
                        class="flex items-center justify-between p-3 bg-green-50 rounded-xl border border-green-100 hover:bg-green-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-green-500 text-white">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div class="text-sm font-medium text-green-600 hidden md:block">Ngày</div>
                        </div>
                        <div class="text-sm text-green-800 text-right">
                            {{ \Carbon\Carbon::parse($item->occurred_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100 hover:bg-red-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 flex items-center justify-center rounded-md bg-red-500 text-white">
                                <i class="fa-solid fa-undo"></i>
                            </div>
                            <div class="text-sm font-medium text-red-600 hidden md:block">Hoàn tác</div>
                        </div>
                        <div class="text-sm text-red-800 font-medium text-right">
                            {{ $item->is_reversal ? 'Có' : 'Không' }}
                        </div>
                    </div>
                </div>

                @if (!empty($item->description))
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-comment text-gray-400 mt-1"></i>
                            <div class="text-sm text-gray-700 break-words">{{ $item->description }}</div>
                        </div>
                    </div>
                @endif

                @if (!empty($item->receipt_image))
                    <div class="flex flex-col justify-center items-center">
                        <div class="text-sm font-medium text-gray-600 hidden md:block mb-2">Ảnh hóa đơn</div>
                        <img id="image" src="{{ asset('storage/' . $item->receipt_image) }}" alt="Hóa đơn"
                            class="rounded-lg border shadow-sm max-h-80 object-contain">
                    </div>
                    <div id="image-modal"
                        class="hidden fixed inset-0 bg-black bg-opacity-75 flex flex-col items-center justify-center z-50">
                        <div class="overflow-hidden flex items-center justify-center w-full h-[80%] p-5">
                            <img id="modal-img" src=""
                                class="transition-transform duration-200 ease-in-out h-full rounded-lg shadow-lg select-none">
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-full max-w-3xl grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            @if (!$item->is_reversal && $item->status !== \App\Consts\TransactionConst::STATUS_REVERSED)
                <a href="{{ route('client.transactions.edit', $item->code) }}"
                    class="flex items-center justify-center gap-2 bg-white border border-teal-500 text-teal-500 py-2 px-4 rounded-xl font-medium shadow-lg hover:shadow-xl hover:bg-teal-50 transform hover:scale-105 transition-all duration-300">
                    <i class="fa-solid fa-edit text-sm"></i>
                    <span class="text-sm">Sửa</span>
                </a>
            @else
                <div
                    class="flex items-center justify-center gap-2 bg-gray-200 text-gray-500 py-2 px-4 rounded-xl font-medium shadow-md cursor-not-allowed">
                    <i class="fa-solid fa-ban text-sm"></i>
                    <span class="text-sm">Không thể sửa</span>
                </div>
            @endif

            @if ($item->status !== \App\Consts\TransactionConst::STATUS_REVERSED && !$item->is_reversal)
                <button id="confirm-reversal"
                    class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-3 px-4 rounded-xl text-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                    </div>
                    <i class="fa-solid fa-undo-alt text-lg animate-pulse"></i>
                    <span class="hidden sm:inline">Hoàn tác</span>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></div>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full"></div>
                </button>
            @else
                <div
                    class="bg-gray-300 text-gray-500 py-3 px-4 rounded-xl text-center font-medium shadow-lg flex items-center justify-center gap-2 cursor-not-allowed">
                    <i class="fa-solid fa-ban text-lg"></i>
                    <span class="hidden sm:inline">Đã hoàn tác</span>
                </div>
            @endif

            <a href="{{ route('client.transactions.index') }}"
                class="bg-white border border-teal-500 text-teal-500 hover:bg-teal-50 hover:border-teal-600 py-3 px-4 rounded-xl text-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fa-solid fa-list text-lg"></i>
                <span class="hidden sm:inline">Quay lại</span>
            </a>
        </div>

        @if (!$item->is_reversal && $item->status !== \App\Consts\TransactionConst::STATUS_REVERSED)
            <div
                class="w-full max-w-3xl mt-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-orange-400 rounded-xl shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-exclamation-triangle text-orange-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700 font-medium">
                            <span class="font-semibold">Lưu ý:</span> Thao tác hoàn tác sẽ tạo một giao dịch ngược lại để
                            bù
                            trừ giao dịch này và không thể hoàn tác.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/js/html2pdf.bundle.min.js') }}"></script>
@endpush

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
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
                });
            @endif

            $("#image").on("click", function() {
                let src = $(this).attr("src");
                $("#modal-img").attr("src", src);
                $("#image-modal").removeClass('hidden');
            });

            $("#image-modal").on("click", function() {
                $("#modal-img").removeAttr("src");
                $("#image-modal").addClass('hidden');
            });

            $('#confirm-reversal').on('click', function() {
                Swal.fire({
                    title: 'Xác nhận hoàn tác?',
                    html: `
                    <div class="text-left space-y-3">
                        <div class="flex items-center gap-2 text-orange-600">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <span class="font-semibold">Cảnh báo quan trọng:</span>
                        </div>
                        <ul class="text-sm text-gray-700 space-y-1 ml-6">
                            <li>Sẽ tạo giao dịch ngược lại để bù trừ</li>
                            <li>Số dư ví sẽ được điều chỉnh</li>
                            <li>Thao tác này không thể hoàn tác</li>
                        </ul>
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <div class="text-sm text-gray-600">
                                <strong>Giao dịch:</strong> {{ $item->code }}<br>
                                <strong>Số tiền:</strong> {{ \App\Helpers\Helper::formatPrice($item->amount, \App\Consts\GlobalConst::CURRENCIES[$item->wallet?->currency] ?? 'VND') }}
                            </div>
                        </div>
                    </div>
                `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fa-solid fa-undo-alt"></i> Xác nhận hoàn tác',
                    cancelButtonText: '<i class="fa-solid fa-times"></i> Hủy bỏ',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2',
                        cancelButton: 'rounded-xl px-6 py-2'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Đang xử lý...',
                            html: 'Vui lòng đợi trong giây lát',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'rounded-2xl'
                            },
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action =
                            '{{ route('client.transactions.undo-transaction', $item->code) }}';
                        console.log(form)

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            $("#btn-pdf").on('click', function() {
                Swal.fire({
                    title: 'Tải PDF ?',
                    text: "Bạn có chắc chắn muốn tải file PDF này không ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Tải ngay',
                    confirmButtonColor: '#14b8a6',
                    cancelButtonColor: '#6b7280',
                    cancelButtonText: 'Hủy bỏ',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        const elementPdf = $('#content-pdf')[0];

                        const opt = {
                            margin: 10,
                            filename: "giao-dich-{{ $item->code }}.pdf",
                            image: {
                                type: 'jpeg',
                                quality: 0.98
                            },
                            html2canvas: {
                                scale: 2
                            },
                            jsPDF: {
                                unit: 'mm',
                                format: 'a4',
                                orientation: 'portrait'
                            },
                            pagebreak: {
                                mode: ['css', 'legacy']
                            }
                        };

                        html2pdf().set(opt).from(elementPdf).save().then(() => {
                            Swal.fire('Thành công!', 'File PDF đã được tải xuống.',
                                'success');
                        });
                    }
                });
            });
        });
    </script>
@endpush

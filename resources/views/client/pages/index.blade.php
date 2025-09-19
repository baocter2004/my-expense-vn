@extends('client.layouts.master')

@section('title', 'Quản Lý Chi Tiêu')

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
    ];
@endphp

@section('content')
    <div class="w-full px-4">
        <h1 class="text-3xl font-bold my-6 text-teal-600 text-center">Chào mừng bạn đến với MyExpenseVN</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-wallet text-3xl text-teal-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Số dư hiện tại</div>
                    <div class="text-xl font-bold text-teal-600">
                        {{ \App\Helpers\Helper::formatPrice($dashboard['total_balance']) }}
                    </div>

                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-arrow-trend-down text-3xl text-red-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Chi tiêu tháng này</div>

                    <div class="text-xl font-bold text-red-500">
                        {{ \App\Helpers\Helper::formatPrice($dashboard['expenses_this_month']) }}
                    </div>

                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-arrow-trend-up text-3xl text-green-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Thu nhập tháng này</div>
                    <div class="text-xl font-bold text-green-500">
                        {{ \App\Helpers\Helper::formatPrice($dashboard['income_this_month']) }}
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-list text-3xl text-blue-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Danh mục</div>
                    <div class="text-xl font-bold text-blue-500">
                        {{ $dashboard['category_count'] }}
                    </div>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-8">
            <div class="bg-white p-4 border border-teal-500 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Thu chi hàng tháng</h2>
                <div class="h-64 bg-gray-100">
                    <canvas id="chartMonthly" class="w-full h-64"></canvas>
                </div>
            </div>

            <div class="bg-white p-4 border border-teal-500 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Chi tiêu theo danh mục</h2>
                <div class="h-64 bg-gray-100 flex justify-center items-center">
                    <canvas id="chartCategory" class="w-full h-64 max-w-md"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-teal-200 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-teal-600">
                        <i class="fa-solid fa-folder-open"></i>
                        <span class="hidden md:inline">Danh mục</span>
                    </h2>
                    <a href="{{ route('client.categories.index') }}"
                        class="relative inline-block text-teal-600 font-medium 
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:w-0 after:h-[2px] after:bg-teal-600 
                      after:transition-all after:duration-300 hover:after:w-full">
                        Danh sách
                    </a>
                </div>
                <ul class="space-y-3">
                    @forelse ($charts['category_summary'] as $category)
                        <li class="p-3 bg-gray-50 rounded-lg hover:bg-teal-50 transition">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <span class="text-gray-800 font-medium">
                                    {{ $category['category_name'] }}
                                </span>

                                <span class="text-base font-semibold text-teal-600">
                                    {{ \App\Helpers\Helper::formatPrice($category['total']) }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500 text-center py-4">Chưa có dữ liệu chi tiêu tháng này</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-teal-200 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-teal-600">
                        <i class="fa-solid fa-receipt"></i>
                        <span class="hidden md:inline">Giao dịch gần đây</span>
                    </h2>
                    <a href="{{ route('client.transactions.index') }}"
                        class="relative inline-block text-teal-600 font-medium 
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:w-0 after:h-[2px] after:bg-teal-600 
                      after:transition-all after:duration-300 hover:after:w-full">
                        Danh sách
                    </a>
                </div>
                <ul class="space-y-3">
                    @forelse ($transactionsToday as $transaction)
                        <li class="p-3 bg-gray-50 rounded-lg hover:bg-teal-50 transition">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <span class="text-base font-semibold text-teal-600 order-1 sm:order-2">
                                    {{ \App\Helpers\Helper::formatPrice($transaction->amount) }}
                                </span>

                                <span class="text-sm text-gray-700 order-2 sm:order-1">
                                    {{ $transaction->description ?? 'Không rõ' }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500 text-center py-4">Chưa có giao dịch nào</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
            @endif

            const charts = @json($charts ?? []);

            const monthly = charts.monthly_summary ?? [];
            const labels = monthly.map(m => m.month);
            const incomeData = monthly.map(m => parseFloat(m.income ?? 0));
            const expenseData = monthly.map(m => parseFloat(m.expense ?? 0));

            const allZero = incomeData.concat(expenseData).every(v => v === 0);

            const ctxMonthly = document.getElementById('chartMonthly').getContext('2d');
            if (window._chartMonthly) {
                window._chartMonthly.destroy();
            }

            window._chartMonthly = new Chart(ctxMonthly, {
                type: 'line',
                data: {
                    labels: allZero ? ['No data'] : labels,
                    datasets: [{
                            label: 'Thu nhập',
                            data: allZero ? [0] : incomeData,
                            tension: 0.3,
                            borderWidth: 2,
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,0.12)',
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#22c55e',
                            yAxisID: 'y'
                        },
                        {
                            label: 'Chi tiêu',
                            data: allZero ? [0] : expenseData,
                            tension: 0.3,
                            borderWidth: 2,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239,68,68,0.12)',
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#ef4444',
                            yAxisID: 'y'
                        }
                    ]

                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.raw ?? 0;
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('vi-VN')
                                        .format(v) + '₫';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: false
                            }
                        },
                        y: {
                            display: true,
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value >= 1000 ? (value / 1000) + 'k' : value;
                                }
                            }
                        }
                    }
                }
            });

            let categories = charts.category_summary ?? [];
            if (typeof categories === 'object' && !Array.isArray(categories)) {
                try {
                    categories = Object.values(categories);
                } catch (e) {
                    categories = [];
                }
            }

            const categoryLabels = categories.map(c => c.category_name ?? 'Khác');
            const categoryValues = categories.map(c => parseFloat(c.total ?? 0));

            const ctxCat = document.getElementById('chartCategory').getContext('2d');
            if (window._chartCategory) {
                window._chartCategory.destroy();
            }

            window._chartCategory = new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: (categoryLabels.length && categoryValues.some(v => v > 0)) ? categoryLabels : [
                        'No data'
                    ],
                    datasets: [{
                        data: (categoryValues.length && categoryValues.some(v => v > 0)) ?
                            categoryValues : [1],
                        backgroundColor: categoryLabels.length && categoryValues.some(v => v > 0) ?
                            [
                                '#ef4444',
                                '#3b82f6',
                                '#14b8a6',
                                '#6b7280',
                            ] : ['#d1d5db'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw ?? 0;
                                    const formatted = new Intl.NumberFormat('vi-VN').format(value) +
                                        ' VND';
                                    return label + ': ' + formatted;
                                }
                            }
                        },
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12
                            }
                        }
                    }
                }
            });

        });
    </script>
@endpush

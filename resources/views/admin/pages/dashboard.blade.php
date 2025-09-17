@extends('admin.layouts.master')

@section('title')
    My Expense VN - Admin Dashboard
@endsection

@section('content')
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">System overview — tổng quan hệ thống (không hiển thị dữ liệu riêng tư)
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                        <i class="fa-solid fa-users text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">Tổng người dùng</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">1,248</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-green-600 text-sm font-medium bg-green-50 px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-arrow-up mr-1 text-xs" aria-hidden="true"></i> +3.4%
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Active (30d): <span
                                class="font-medium text-slate-700">892</span></div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#0ea5e9" stroke-width="2"
                            points="0,14 8,10 16,8 24,9 32,6 40,7 48,4 56,2 60,3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div
                        class="flex-none w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-plus text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">Người dùng mới (hôm / tháng / năm)</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">12 / 58 / 1,024</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-rose-600 bg-rose-50 text-sm font-medium px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-arrow-down mr-1 text-xs" aria-hidden="true"></i> -1.2%
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Last 24h: <span class="text-slate-700">12</span></div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#10b981" stroke-width="2"
                            points="0,12 8,12 16,10 24,9 32,7 40,8 48,6 56,7 60,5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-wallet text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">Số ví (wallets)</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">3,410</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-sky-600 text-sm font-medium bg-sky-50 px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-arrow-up mr-1 text-xs" aria-hidden="true"></i> +4.1%
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Avg wallets / user: <span class="text-slate-700">2.7</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#f59e0b" stroke-width="2"
                            points="0,10 8,9 16,11 24,10 32,9 40,8 48,7 56,8 60,6" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex-none w-12 h-12 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">Tổng giao dịch</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">9,430</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-slate-700 text-sm font-medium bg-slate-100 px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-calendar-days mr-1 text-xs" aria-hidden="true"></i> 1,240 this
                                    month
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Today: <span class="text-slate-700">312</span></div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#ef4444" stroke-width="2"
                            points="0,16 8,12 16,10 24,11 32,9 40,7 48,6 56,4 60,5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div
                        class="flex-none w-12 h-12 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                        <i class="fa-solid fa-money-bill-wave text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">Doanh thu (tháng)</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">₫ 45,200,000</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-green-600 text-sm font-medium bg-green-50 px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-arrow-up mr-1 text-xs" aria-hidden="true"></i> +12%
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Paid users: <span class="text-slate-700">142</span></div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#7c3aed" stroke-width="2"
                            points="0,14 8,12 16,11 24,9 32,7 40,6 48,6 56,4 60,3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition h-full flex flex-col justify-between">
                <div class="flex items-start gap-4">
                    <div
                        class="flex-none w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-lg" aria-hidden="true"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm text-slate-400">User hoạt động (30d)</div>
                                <div class="text-2xl font-semibold text-slate-800 mt-1">892</div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div
                                    class="inline-flex items-center text-green-600 text-sm font-medium bg-green-50 px-2 py-0.5 rounded">
                                    <i class="fa-solid fa-arrow-up mr-1 text-xs" aria-hidden="true"></i> +5.6%
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2">Retention (30d): <span class="text-slate-700">71%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 hidden sm:block">
                    <svg viewBox="0 0 60 20" class="w-full h-5" preserveAspectRatio="none" aria-hidden="true">
                        <polyline fill="none" stroke="#6366f1" stroke-width="2"
                            points="0,14 8,13 16,12 24,10 32,9 40,8 48,7 56,6 60,5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Tăng trưởng người dùng theo tháng (2025)</h3>
                    <div class="text-sm text-slate-400">Thống kê theo tháng</div>
                </div>
                <div class="h-64">
                    <canvas id="usersGrowthChart" class="w-full h-full"></canvas>
                </div>
            </div>
            <div class="bg-white p-5 rounded-lg shadow space-y-6">
                <div>
                    <h4 class="text-md font-semibold">Giao dịch theo tháng</h4>
                    <div class="h-36 mt-3">
                        <canvas id="transactionsMonthlyChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div>
                    <h4 class="text-md font-semibold">Doanh thu theo tháng</h4>
                    <div class="h-36 mt-3">
                        <canvas id="revenueChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-1 bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">User mới đăng ký gần đây</h3>
                    <a href="#" class="text-sm text-sky-600">Xem tất cả</a>
                </div>
                <ul class="divide-y divide-slate-100">
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium">Nguyễn Văn A</div>
                            <div class="text-xs text-slate-400">a@example.com</div>
                        </div>
                        <div class="text-xs text-slate-500">12/09/2025</div>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium">Trần Thị B</div>
                            <div class="text-xs text-slate-400">b@example.com</div>
                        </div>
                        <div class="text-xs text-slate-500">11/09/2025</div>
                    </li>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium">Phạm Văn C</div>
                            <div class="text-xs text-slate-400">c@example.com</div>
                        </div>
                        <div class="text-xs text-slate-500">10/09/2025</div>
                    </li>
                </ul>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Top user hoạt động</h3>
                    <span class="text-xs text-slate-400">Theo số giao dịch</span>
                </div>
                <ol class="space-y-3 text-sm">
                    <li class="flex justify-between items-center">
                        <div><span class="font-medium">Lê Hoàng</span>
                            <div class="text-xs text-slate-400">Thành viên</div>
                        </div>
                        <div class="text-sm font-semibold">312 giao dịch</div>
                    </li>
                    <li class="flex justify-between items-center">
                        <div><span class="font-medium">Phương Anh</span>
                            <div class="text-xs text-slate-400">Thành viên</div>
                        </div>
                        <div class="text-sm font-semibold">280 giao dịch</div>
                    </li>
                    <li class="flex justify-between items-center">
                        <div><span class="font-medium">Trọng Minh</span>
                            <div class="text-xs text-slate-400">Thành viên</div>
                        </div>
                        <div class="text-sm font-semibold">245 giao dịch</div>
                    </li>
                </ol>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Phân bố user theo khu vực</h3>
                    <span class="text-xs text-slate-400">Tổng: 1,248</span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <div>Hà Nội</div>
                        <div>420</div>
                    </div>
                    <div class="flex justify-between">
                        <div>TP HCM</div>
                        <div>360</div>
                    </div>
                    <div class="flex justify-between">
                        <div>Đà Nẵng</div>
                        <div>120</div>
                    </div>
                    <div class="flex justify-between">
                        <div>Khác</div>
                        <div>348</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Hoạt động giao dịch (ẩn danh)</h3>
                    <div class="text-sm text-slate-400">Không hiển thị mô tả giao dịch cá nhân</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="p-4 bg-gray-50 rounded">
                        <div class="text-xs text-slate-500">Tổng giao dịch hôm nay</div>
                        <div class="text-xl font-bold mt-1">312</div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded">
                        <div class="text-xs text-slate-500">Tổng giao dịch tháng</div>
                        <div class="text-xl font-bold mt-1">1,240</div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded">
                        <div class="text-xs text-slate-500">Tỉ lệ Thu vs Chi</div>
                        <div class="text-xl font-bold mt-1">65% / 35%</div>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium mb-2">Phân bổ theo danh mục (trung bình hệ thống)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-3 bg-white rounded shadow-sm">
                            <div class="text-sm text-slate-500">Ăn uống</div>
                            <div class="text-lg font-semibold mt-1">3,120</div>
                        </div>
                        <div class="p-3 bg-white rounded shadow-sm">
                            <div class="text-sm text-slate-500">Đi lại</div>
                            <div class="text-lg font-semibold mt-1">2,500</div>
                        </div>
                        <div class="p-3 bg-white rounded shadow-sm">
                            <div class="text-sm text-slate-500">Giáo dục</div>
                            <div class="text-lg font-semibold mt-1">1,010</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <h4 class="font-semibold mb-3">Tỉ lệ theo danh mục</h4>
                <div class="h-52">
                    <canvas id="anonCategoryChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-5 rounded-lg shadow">
                <div class="text-sm text-slate-400">Free vs Paid users</div>
                <div class="text-2xl font-bold mt-2">Free: 1,106 • Paid: 142</div>
                <div class="text-xs text-slate-400 mt-2">Churn (30d): 2.1%</div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <div class="text-sm text-slate-400">Doanh thu tháng</div>
                <div class="text-2xl font-bold mt-2">₫ 45,200,000</div>
                <div class="text-xs text-slate-400 mt-2">MRR: ₫ 3,760,000</div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <div class="text-sm text-slate-400">User sắp hết hạn Premium</div>
                <ul class="mt-2 text-sm space-y-2">
                    <li class="flex justify-between"><span>phuong.an</span><span class="text-xs text-slate-500">3
                            ngày</span></li>
                    <li class="flex justify-between"><span>le.hoang</span><span class="text-xs text-slate-500">5
                            ngày</span></li>
                    <li class="flex justify-between"><span>trong.minh</span><span class="text-xs text-slate-500">6
                            ngày</span></li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-5 rounded-lg shadow">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Cảnh báo hệ thống</h3>
                    <a href="#" class="text-sm text-rose-600">Xem log đầy đủ</a>
                </div>

                <ul class="space-y-3 text-sm">
                    <li class="p-3 rounded border border-slate-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium">Đăng nhập thất bại - IP bất thường</div>
                                <div class="text-xs text-slate-400">2025-09-12 — 5 lần</div>
                            </div>
                            <div class="text-xs text-slate-500">2 giờ trước</div>
                        </div>
                    </li>
                    <li class="p-3 rounded border border-slate-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium">Backup DB thất bại</div>
                                <div class="text-xs text-slate-400">S3 upload error</div>
                            </div>
                            <div class="text-xs text-slate-500">1 ngày trước</div>
                        </div>
                    </li>
                    <li class="p-3 rounded border border-slate-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium">Audit: config changed</div>
                                <div class="text-xs text-slate-400">User: admin — Changed payment settings</div>
                            </div>
                            <div class="text-xs text-slate-500">3 ngày trước</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Quick actions</h3>
                <div class="flex flex-col gap-3">
                    <button class="py-2 px-3 bg-sky-600 text-white rounded">Export reports</button>
                    <button class="py-2 px-3 bg-rose-500 text-white rounded">Run DB backup</button>
                    <button class="py-2 px-3 border rounded">Open audit log</button>
                </div>
            </div>
        </div>
    </div>
@endsection

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
            const usersCtx = document.getElementById('usersGrowthChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'User mới',
                        data: [30, 50, 80, 60, 90, 120, 150, 140, 180, 200, 210, 248],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14,165,233,0.12)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const txCtx = document.getElementById('transactionsMonthlyChart').getContext('2d');
            new Chart(txCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Giao dịch',
                        data: [420, 380, 560, 500, 630, 720, 800, 760, 900, 1000, 1100, 1240],
                        backgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
            const revCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [1200, 1500, 1700, 1600, 2000, 2200, 2500, 2400, 2700, 3000, 3200,
                            4520
                        ],
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124,58,237,0.08)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            const catCtx = document.getElementById('anonCategoryChart').getContext('2d');
            new Chart(catCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Ăn uống', 'Đi lại', 'Giải trí', 'Gia đình', 'Khác'],
                    datasets: [{
                        data: [3120, 2500, 1800, 1010, 900],
                        backgroundColor: ['#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#6b7280']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush

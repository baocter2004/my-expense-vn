@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    My Expense VN - Chi tiết người dùng
@endsection

@php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Users']];
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Chi Tiết Người Dùng</h1>
                <p class="text-sm text-slate-500 mt-1">Thông tin chi tiết của người dùng</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-sm text-slate-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="hidden sm:inline">Quay lại</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <div class="flex flex-col items-center text-center space-y-4 mb-8">
                <div>
                    <img src="{{ $user->avatar_url ?? asset('images/default.png') }}" alt="Avatar"
                        class="w-32 h-32 rounded-full object-cover border-4 border-teal-100 shadow">
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ $user->last_name }} {{ $user->first_name }}
                    </h2>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                </div>
                <div>
                    @if ($user->is_active)
                        <span
                            class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                            Active
                        </span>
                    @else
                        <span
                            class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 border border-red-200">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-user mr-2 text-teal-500"></i> Thông tin cá nhân
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500">Giới tính</p>
                        <p class="font-medium">{{ \App\Consts\UserConst::GENDER[$user->gender] ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày sinh</p>
                        <p class="font-medium">{{ $user->birth_date ?? '---' }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-database mr-2 text-indigo-500"></i> Thông tin hệ thống
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500">Google ID</p>
                        <p class="font-medium">{{ $user->google_id ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Admin quản lý</p>
                        <p class="font-medium">
                            {{ $user->admin ? trim($user->admin->last_name . ' ' . $user->admin->first_name) : '---' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày tạo</p>
                        <p class="font-medium">{{ $user->created_at?->format('d/m/Y H:i') ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày cập nhật</p>
                        <p class="font-medium">{{ $user->updated_at?->format('d/m/Y H:i') ?? '---' }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-chart-pie mr-2 text-teal-500"></i> Thống kê
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-teal-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Danh mục</p>
                        <p class="text-2xl font-bold text-teal-600">{{ $user->categories_count }}</p>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Giao dịch</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $user->transactions_count }}</p>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Ví</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $user->wallets_count }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-gears mr-2 text-amber-500"></i> Quản lý
                </h3>
                <div class="flex gap-3">
                    <button
                        class="px-4 py-2 bg-amber-500 text-white text-sm rounded-lg shadow hover:bg-amber-600 transition">
                        <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                    </button>
                    <button class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg shadow hover:bg-red-600 transition">
                        <i class="fas fa-lock mr-2"></i> Khóa người dùng
                    </button>
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

        });
    </script>
@endpush

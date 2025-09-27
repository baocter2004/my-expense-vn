@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    My Expense VN - Admin Dashboard
@endsection

@php
    $breadcrumbs = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Users']];
@endphp

@section('content')
    <div class="p-4 md:p-6 rounded-lg bg-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-800">Danh Sách Người Dùng</h1>
                <p class="text-sm text-slate-500 mt-1">Quản lý danh sách người dùng</p>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.forms.input', [
                    'label' => 'Họ',
                    'name' => 'last_name',
                    'placeholder' => 'Nhập họ người dùng...',
                    'icon' => 'id-card',
                ])

                @include('admin.components.forms.input', [
                    'label' => 'Tên',
                    'name' => 'first_name',
                    'placeholder' => 'Nhập tên người dùng...',
                    'icon' => 'user',
                ])
            </div>

            @include('admin.components.forms.input', [
                'label' => 'Email',
                'name' => 'email',
                'placeholder' => 'Nhập email...',
                'icon' => 'envelope',
            ])

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.forms.select', [
                    'label' => 'Giới tính',
                    'name' => 'gender',
                    'placeholder' => 'Vui lòng chọn',
                    'options' => \App\Consts\UserConst::GENDER,
                    'icon' => 'venus-mars',
                ])

                @include('admin.components.forms.select', [
                    'label' => 'Trạng thái',
                    'name' => 'is_active',
                    'options' => \App\Consts\GlobalConst::STATUS,
                    'icon' => 'toggle-on',
                ])
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @include('admin.components.forms.date', [
                    'label' => 'Ngày tạo từ',
                    'name' => 'from_date',
                    'placeholder' => 'YYYY/MM/DD',
                    'icon' => 'calendar',
                ])

                @include('admin.components.forms.date', [
                    'label' => 'Ngày tạo đến',
                    'name' => 'to_date',
                    'placeholder' => 'YYYY/MM/DD',
                    'icon' => 'calendar',
                ])

                <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center gap-2">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-teal-600 text-white text-sm font-medium rounded-lg shadow transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-300">
                        Lọc
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        Xóa lọc
                    </a>
                </div>
            </div>
        </form>

        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-lg transition my-4 h-full overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">ID</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Google ID</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Admin ID</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">First Name</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Last Name</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Email</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Gender</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Birth Date</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Active</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Created At</th>
                        <th class="px-4 py-3 text-left font-medium text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($items as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $user->id }}</td>
                            <td class="px-4 py-3">{{ $user->google_id ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $user->admin_id ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $user->first_name }}</td>
                            <td class="px-4 py-3">{{ $user->last_name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                {{ \App\Consts\UserConst::GENDER[$user->gender] ?? '-' }}
                            </td>
                            <td class="px-4 py-3">{{ $user->birth_date ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($user->is_active)
                                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="" class="text-teal-600 hover:text-teal-800 mx-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 mx-1"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-6 text-center text-gray-500 italic">
                                Không có người dùng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        });
    </script>
@endpush

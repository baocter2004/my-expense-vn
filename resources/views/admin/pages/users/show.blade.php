@extends('admin.layouts.master')


@section('title')
    My Expense VN - Chi tiết người dùng
@endsection

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Users', 'url' => route('admin.users.index')],
        ['label' => 'Show'],
    ];
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
                    <img src="{{ $user->avatar ? Storage::url($user?->avatar) : asset('images/default.png') }}" alt="Avatar"
                        class="w-32 h-32 rounded-full object-cover border-4 border-teal-100 shadow">
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">
                        {{ $user?->last_name }} {{ $user?->first_name }}
                    </h2>
                    <p class="text-sm text-slate-500">{{ $user?->email }}</p>
                </div>
                <div>
                    @if ($user?->is_active == 1)
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
                        <p class="font-medium">{{ \App\Consts\UserConst::GENDER[$user?->gender] ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày sinh</p>
                        <p class="font-medium">{{ $user?->birth_date?->format('d/m/Y') ?? '---' }}</p>
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
                        <p class="font-medium">{{ $user?->google_id ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Admin quản lý</p>
                        <p class="font-medium">
                            {{ $user?->admin ? trim($user?->admin->last_name . ' ' . $user?->admin->first_name) : '---' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày tạo</p>
                        <p class="font-medium">{{ $user?->created_at?->format('d/m/Y H:i') ?? '---' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Ngày cập nhật</p>
                        <p class="font-medium">{{ $user?->updated_at?->format('d/m/Y H:i') ?? '---' }}</p>
                    </div>

                    @if ($user?->is_active == 2 && !empty($user?->reason_for_unactive))
                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-500">Lý do khóa</p>
                            <p class="font-medium text-red-600">
                                <i class="fa-solid fa-ban mr-1"></i> {{ $user?->reason_for_unactive }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-chart-pie mr-2 text-teal-500"></i> Thống kê
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-teal-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Danh mục</p>
                        <p class="text-2xl font-bold text-teal-600">{{ $user?->categories_count }}</p>
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Giao dịch</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $user?->transactions_count }}</p>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-xl text-center shadow-sm">
                        <p class="text-xs text-slate-500">Ví</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $user?->wallets_count }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-700 border-b border-gray-200 pb-2 mb-4">
                    <i class="fa-solid fa-gears mr-2 text-amber-500"></i> Quản lý
                </h3>
                <div class="flex gap-2 flex-wrap">
                    <a
                        href="{{ route('admin.users.edit',$user?->id) }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-amber-500 text-white text-sm rounded-lg shadow hover:bg-amber-600 transition">
                        <i class="fas fa-edit"></i>
                        <span class="hidden sm:inline">Chỉnh sửa</span>
                    </a>

                    @if ($user?->is_active == 1)
                        <button data-id="{{ $user?->id }}"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-red-500 text-white text-sm rounded-lg shadow hover:bg-red-600 transition btn-lock-user">
                            <i class="fas fa-lock"></i>
                            <span class="hidden sm:inline">Khóa</span>
                        </button>
                    @endif

                    @if ($user?->is_active == 2)
                        <button data-id="{{ $user?->id }}" data-reason="{{ $user?->reason_for_unactive }}"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-blue-500 text-white text-sm rounded-lg shadow hover:bg-blue-600 transition btn-unlock-user">
                            <i class="fas fa-unlock"></i>
                            <span class="hidden sm:inline">Mở Khóa</span>
                        </button>
                    @endif

                    <button data-id="{{ $user?->id }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-500 text-white text-sm rounded-lg shadow hover:bg-gray-600 transition btn-delete-user">
                        <i class="fas fa-trash"></i>
                        <span class="hidden sm:inline">Xóa</span>
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

            $('.btn-lock-user').on('click', function() {
                let userId = $(this).data('id');

                Swal.fire({
                    title: 'Khóa người dùng',
                    text: 'Nhập lý do khóa tài khoản này:',
                    input: 'text',
                    inputPlaceholder: 'Ví dụ: Vi phạm chính sách...',
                    inputAttributes: {
                        maxlength: 255,
                    },
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Khóa',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Bạn phải nhập lý do!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let reason = result.value;
                        $.ajax({
                            url: `/admin/users/${userId}/lock`,
                            type: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}',
                                reason: reason,
                                user_id: userId
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã khóa!',
                                    text: res.message ||
                                        'Người dùng đã bị khóa thành công.'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Thất bại!',
                                    text: xhr.responseJSON?.message ||
                                        'Không thể khóa người dùng.'
                                });
                            }
                        });
                    }
                });
            });

            $('.btn-unlock-user').on('click', function() {
                let userId = $(this).data('id');
                let reason = $(this).data('reason');

                Swal.fire({
                    title: 'Mở khóa người dùng?',
                    html: `
                            <p class="text-gray-700 mb-2">Người dùng này đã bị khóa với lý do:</p>
                            <p class="font-semibold text-red-600">"${reason || 'Không có lý do'}"</p>
                        `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Mở khóa',
                    cancelButtonText: 'Hủy',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/${userId}/unlock`,
                            type: 'PATCH',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Đã mở khóa!', res.message ||
                                        'Người dùng đã được mở khóa.', 'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Thất bại!', xhr.responseJSON?.message ||
                                    'Không thể mở khóa.', 'error');
                            }
                        });
                    }
                });
            });

            $('.btn-delete-user').on('click', function() {
                let userId = $(this).data('id');

                Swal.fire({
                    title: 'Xóa người dùng?',
                    text: 'Người dùng sẽ bị chuyển vào thùng rác.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/users/${userId}/soft-delete`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Đã xóa!', res.message ||
                                        'Người dùng đã bị xóa.', 'success')
                                    .then(() => {
                                        window.location.href =
                                            "{{ route('admin.users.index') }}";
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire('Thất bại!', xhr.responseJSON?.message ||
                                    'Không thể xóa.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            height: 0;
            width: 0;
        }

        #top-scroll-inner {
            background: rgba(20, 184, 166, 0.04);
            border-radius: 9999px;
        }

        @media (pointer: coarse) {
            #top-scroll {
                height: 6px;
            }

            #top-scroll-inner {
                height: 3px;
            }
        }
    </style>
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
        <form id="filterForm" method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                <div
                    class="flex items-center justify-between px-4 md:px-6 py-3 md:py-4 bg-gradient-to-r from-white to-gray-50">
                    <div class="flex items-center gap-3">
                        <button type="button" id="filterToggle"
                            class="inline-flex items-center gap-2 text-sm md:text-base text-slate-700 hover:text-teal-600 focus:outline-none">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01.293.707L16 13.414V19a1 1 0 01-1.447.894L9 17l-5.553 2.894A1 1 0 012 19v-5.586L.707 6.707A1 1 0 011 6V4z" />
                            </svg>
                            <span class="font-semibold">Bộ lọc</span>
                            <span id="activeCount"
                                class="ml-1 inline-flex items-center justify-center text-xs px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">0</span>
                        </button>
                        <p class="text-sm text-slate-500 hidden md:block">Tìm kiếm & lọc nhanh danh sách người dùng</p>
                    </div>
                </div>

                <div id="filterBody" class="px-4 md:px-6 pb-4 md:pb-6 hidden space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                        <div class="space-y-1">
                            @include('admin.components.forms.input', [
                                'label' => 'Họ',
                                'name' => 'first_name',
                                'placeholder' => 'Nhập họ người dùng...',
                                'icon' => 'id-card',
                            ])
                        </div>

                        <div class="space-y-1">
                            @include('admin.components.forms.input', [
                                'label' => 'Tên',
                                'name' => 'last_name',
                                'placeholder' => 'Nhập tên người dùng...',
                                'icon' => 'user',
                            ])
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            @include('admin.components.forms.input', [
                                'label' => 'Email',
                                'name' => 'email',
                                'placeholder' => 'Nhập email...',
                                'icon' => 'envelope',
                            ])
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                @include('admin.components.forms.select', [
                                    'label' => 'Giới tính',
                                    'name' => 'gender',
                                    'placeholder' => 'Tất cả',
                                    'options' => \App\Consts\UserConst::GENDER,
                                    'icon' => 'venus-mars',
                                ])
                            </div>

                            <div class="space-y-1">
                                @include('admin.components.forms.select', [
                                    'label' => 'Trạng thái',
                                    'name' => 'is_active',
                                    'placeholder' => 'Tất cả',
                                    'options' => \App\Consts\GlobalConst::STATUS,
                                    'icon' => 'toggle-on',
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div class="space-y-1">
                            @include('admin.components.forms.date', [
                                'label' => 'Ngày tạo từ',
                                'name' => 'from_date',
                                'placeholder' => 'YYYY/MM/DD',
                                'icon' => 'calendar',
                            ])
                        </div>

                        <div class="space-y-1">
                            @include('admin.components.forms.date', [
                                'label' => 'Ngày tạo đến',
                                'name' => 'to_date',
                                'placeholder' => 'YYYY/MM/DD',
                                'icon' => 'calendar',
                            ])
                        </div>
                        <div class="flex justify-end items-center gap-2">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-md shadow hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-300">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="hidden sm:inline">Áp dụng</span>
                            </button>

                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 text-sm text-slate-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                <i class="fa-solid fa-rotate-right"></i>
                                <span class="hidden sm:inline">Đặt lại</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-3">
            <div class="w-full md:w-1/2 p-3 border border-teal-500 rounded-xl bg-white flex items-start gap-2">
                <i class="fa-regular fa-lightbulb text-teal-500 mt-0.5"></i>
                <p class="text-xs text-teal-500 leading-relaxed">
                    Dùng <span class="font-medium">Ngày tạo</span> để lọc theo khoảng thời gian.
                    Nhấp vào "Bộ lọc" để ẩn/hiện nhanh.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <button id="scrollToAction"
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition text-sm">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span class="hidden sm:inline">Đi đến Hành động</span>
                </button>

                <button id="scrollToFirst"
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg shadow hover:bg-amber-600 transition text-sm hidden">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="hidden sm:inline">Quay lại ID</span>
                </button>

                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center justify-center gap-2 px-4 py-2 bg-teal-500 text-white rounded-lg shadow hover:bg-teal-600 transition text-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hidden sm:inline">Thêm mới</span>
                </a>
            </div>
        </div>

        <div class="relative">
            <div id="top-scroll" class="w-full overflow-x-auto overflow-y-hidden h-3 my-3 md:my-6">
                <div id="top-scroll-inner" class="h-1"></div>
            </div>

            <div id="table-scroll"
                class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 my-4 h-full overflow-x-auto border border-gray-100 no-scrollbar">
                <table class="min-w-[1200px] w-full table-auto text-sm">
                    <thead class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
                        <tr>
                            <th class="sticky left-0 bg-teal-600 text-white px-6 py-5 font-semibold whitespace-nowrap z-10">
                                Mã ID
                            </th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Google ID</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Tên Quản Trị Viên</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Họ</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Tên</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Email</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Giới Tính</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Ngày Sinh</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Trạng Thái</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Tổng Số Giao Dịch</th>
                            <th class="px-6 py-5 text-left font-semibold whitespace-nowrap">Ngày Tạo</th>
                            <th class="px-6 py-5 text-center font-semibold whitespace-nowrap">Hành Động</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($items as $user)
                            <tr
                                class="hover:bg-gradient-to-r hover:from-teal-50 hover:to-teal-50 transition-all duration-200 group">
                                <td class="sticky left-0 bg-white px-6 py-4 font-medium text-gray-900 z-10">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->google_id ?? '---' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-teal-700">
                                    {{ $user->admin ? trim($user->admin->last_name . ' ' . $user->admin->first_name) : '---' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $user->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $user->first_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ \App\Consts\UserConst::GENDER[$user->gender] ?? '---' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $user->birth_date?->format('d/m/Y') ?? '---' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->is_active && $user->is_active === 1)
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700 border border-red-200">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">
                                    {{ $user->transactions_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ $user->created_at?->format('d/m/Y') ?? '---' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div
                                        class="flex items-center justify-center gap-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="p-3 cursor-pointer text-teal-600 hover:text-teal-800 hover:bg-teal-200 rounded-lg transition-all duration-200 tooltip"
                                            title="Xem chi tiết">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        <button
                                            class="p-3 text-amber-600 hover:text-amber-800 hover:bg-amber-200 rounded-lg transition-all duration-200 tooltip"
                                            title="Chỉnh sửa">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>

                                        @if ($user->is_active == 1)
                                            <button
                                                class="p-3 text-red-600 hover:text-red-800 hover:bg-red-200 rounded-lg transition-all duration-200 tooltip btn-lock-user"
                                                data-id="{{ $user->id }}" title="Khóa người dùng">
                                                <i class="fas fa-lock text-sm"></i>
                                            </button>
                                        @endif

                                        @if ($user->is_active == 2)
                                            <button
                                                class="p-3 text-blue-600 hover:text-blue-800 hover:bg-blue-200 rounded-lg transition-all duration-200 tooltip btn-unlock-user"
                                                data-id="{{ $user->id }}"
                                                data-reason="{{ $user->reason_for_unactive }}"
                                                title="Mở khóa người dùng">
                                                <i class="fas fa-unlock text-sm"></i>
                                            </button>
                                        @endif

                                        <button
                                            class="p-3 text-gray-600 hover:text-gray-800 hover:bg-gray-200 rounded-lg transition-all duration-200 tooltip btn-delete-user"
                                            data-id="{{ $user->id }}" title="Xóa người dùng">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-users text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Không có người dùng nào</p>
                                        <p class="text-sm mt-1">Dữ liệu sẽ được hiển thị ở đây khi có người dùng mới</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $items->onEachSide(1)->links('client.components.elements.paginate') }}
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

            var $topScroll = $('#top-scroll');
            var $topInner = $('#top-scroll-inner');
            var $tableScroll = $('#table-scroll');
            var $table = $tableScroll.find('table');

            if (!$topScroll.length || !$topInner.length || !$tableScroll.length || !$table.length) return;

            function updateTopWidth() {
                var w = $table[0].scrollWidth || 0;
                $topInner.css('width', w + 'px');
            }

            updateTopWidth();

            $(window).on('resize', updateTopWidth);

            if (window.ResizeObserver) {
                var ro = new ResizeObserver(function() {
                    updateTopWidth();
                });
                ro.observe($table[0]);
            }

            var isSyncing = false;

            $topScroll.on('scroll', function() {
                if (isSyncing) return;
                isSyncing = true;
                $tableScroll.scrollLeft($topScroll.scrollLeft());
                window.requestAnimationFrame(function() {
                    isSyncing = false;
                });
            });

            $tableScroll.on('scroll', function() {
                if (isSyncing) return;
                isSyncing = true;
                $topScroll.scrollLeft($tableScroll.scrollLeft());
                window.requestAnimationFrame(function() {
                    isSyncing = false;
                });

                let scrollLeft = $tableScroll.scrollLeft();
                let maxScroll = $tableScroll[0].scrollWidth - $tableScroll.outerWidth();

                if (scrollLeft <= 20) {
                    $('#scrollToFirst').addClass('hidden');
                    $('#scrollToAction').removeClass('hidden');
                } else if (scrollLeft >= maxScroll - 20) {
                    $('#scrollToAction').addClass('hidden');
                    $('#scrollToFirst').removeClass('hidden');
                }
            });


            $('#scrollToAction').on('click', function() {
                let $tableScroll = $('#table-scroll');
                let $lastTh = $('#table-scroll table thead th:last');

                if ($lastTh.length) {
                    let left = $lastTh.position().left + $tableScroll.scrollLeft();
                    $tableScroll.animate({
                        scrollLeft: left
                    }, 500);

                    setTimeout(() => {
                        $('#scrollToAction').addClass('hidden');
                        $('#scrollToFirst').removeClass('hidden');
                    }, 500);
                }
            });

            $('#scrollToFirst').on('click', function() {
                let $tableScroll = $('#table-scroll');
                $tableScroll.animate({
                    scrollLeft: 0
                }, 500);

                setTimeout(() => {
                    $('#scrollToFirst').addClass('hidden');
                    $('#scrollToAction').removeClass('hidden');
                }, 500);
            });

            var hasError = @json($errors->any());
            var $filterToggle = $('#filterToggle');
            var $filterBody = $('#filterBody');
            var $form = $('#filterForm');
            var $activeCount = $('#activeCount');
            var collapsed = false;

            $filterToggle.on('click', function() {
                collapsed = !collapsed;
                $filterBody.slideToggle(180);
            });

            function countActiveFilters() {
                var count = 0;
                $form.find('input, select').each(function() {
                    var type = $(this).attr('type');
                    var val = $(this).val();

                    if (type === 'hidden') return;

                    if (type === 'checkbox' || type === 'radio') {
                        if (this.checked) count++;
                    } else if ($(this).is('select')) {
                        if (val && val.trim() !== '') count++;
                    } else {
                        if (val && String(val).trim() !== '') count++;
                    }
                });

                $activeCount.text(count);
                return count;
            }

            countActiveFilters();

            if (hasError || countActiveFilters() > 0) {
                $filterBody.show();
                collapsed = true;
            }

            $form.on('change input', 'input, select', function() {
                countActiveFilters();
            });

            $form.on('keypress', 'input', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $form.submit();
                }
            });

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
                            url: `/admin/users/${userId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Đã xóa!', res.message ||
                                        'Người dùng đã bị xóa.', 'success')
                                    .then(() => location.reload());
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

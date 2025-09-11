@extends('client.layouts.master')

@section('title', 'Quản Lý Chi Tiêu')

@section('content')
    <div class="w-full px-4">
        <h1 class="text-3xl font-bold mb-6 text-teal-600 text-center">Chào mừng bạn đến với MyExpenseVN</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-wallet text-3xl text-teal-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Số dư hiện tại</div>
                    <div class="text-xl font-bold text-teal-600">{{ $sumBalance }}</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-arrow-trend-down text-3xl text-red-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Chi tiêu tháng này</div>
                    <div class="text-xl font-bold text-red-500">5,500,000₫</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-arrow-trend-up text-3xl text-green-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Thu nhập tháng này</div>
                    <div class="text-xl font-bold text-green-500">8,200,000₫</div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition flex items-center space-x-3">
                <i class="fa-solid fa-list text-3xl text-blue-500"></i>
                <div>
                    <div class="text-sm text-gray-500">Danh mục</div>
                    <div class="text-xl font-bold text-blue-500">12</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-8">
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Thu chi hàng tháng</h2>
                <div class="h-64 bg-gray-100 flex justify-center items-center text-gray-400">
                    Biểu đồ thu chi
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Chi tiêu theo danh mục</h2>
                <div class="h-64 bg-gray-100 flex justify-center items-center text-gray-400">
                    Biểu đồ danh mục
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Danh mục</h2>
                <ul class="space-y-2">
                    @foreach([['Chi tiêu ăn uống', 'red'], ['Tiền nhà', 'blue'], ['Giải trí', 'teal'], ['Khác', 'gray']] as [$name, $color])
                        <li class="flex justify-between items-center border-b last:border-none pb-2">
                            <span class="text-{{ $color }}-500">{{ $name }}</span>
                            <span class="text-sm text-gray-500">Tổng: 1,000,000₫</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Giao dịch gần đây</h2>
                <ul class="space-y-2">
                    @foreach(range(1,5) as $i)
                        <li class="flex justify-between items-center border-b last:border-none pb-2">
                            <span class="text-gray-700">Chi tiêu #{{ $i }}</span>
                            <span class="text-gray-500 text-sm">500,000₫</span>
                        </li>
                    @endforeach
                </ul>
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

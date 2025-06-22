@extends('admin.layouts.master')

@section('title')
    My Expense VN
@endsection

@section('content')
    Đây Là Trang DashBoard
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

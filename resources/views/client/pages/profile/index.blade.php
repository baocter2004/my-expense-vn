@extends('client.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title')
    Trang Thông Tin Cá Nhân
@endsection

@php
    $breadcrumb = [
        ['label' => 'Trang chủ', 'url' => route('client.index'), 'icon' => 'fa-home'],
        ['label' => 'Thông tin cá nhân'],
    ];
@endphp

@section('content')
    <div
        class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-4">
        <div class="text-center mb-8">
            <h1
                class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-cyan-400 flex items-center justify-center gap-x-2">
                <i class="fa-solid fa-wallet"></i> MyExpenseVn
            </h1>
            <div class="my-2 flex justify-center">
                <div class="w-20 h-1 rounded-full bg-gradient-to-r from-teal-500 to-cyan-400 opacity-50"></div>
            </div>
            <h2 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">Thông Tin Trang Cá Nhân</h2>

            <h3 class="text-base sm:text-lg font-medium text-center text-gray-600 tracking-wide">
                Xin chào <span class="text-teal-600 underline decoration-2 decoration-cyan-400 decoration-dotted">
                    {{ $user->fullname }}
                </span> ,
                {{ $greeting }}
            </h3>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-5xl w-full">
            <div class="flex flex-col items-center p-4 bg-white shadow-md rounded-xl">
                <form id="avatarForm" action="{{ route('client.update-avatar') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="relative mb-4">
                        <img id="avatarPreview"
                            src="{{ isset($user->avatar) ? Storage::url($user->avatar) : asset('/images/default.png') }}"
                            alt="Ảnh cá nhân" class="w-full sm:w-48 h-auto sm:h-48 rounded-xl border-2 border-teal-300 object-cover">

                        <label
                            class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-teal-100 transition">
                            <input id="avatarInput" name="avatar" type="file" class="hidden" accept="image/*" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z"></path>
                            </svg>
                        </label>
                    </div>
                    @if ($errors->has('avatar'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('avatar') }}</p>
                    @endif
                </form>

                <ul class="flex flex-col w-full text-center gap-2 mt-2 text-gray-800" id="menu-tabs">
                    <li>
                        <a href="#profile"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition"
                            data-step="1" data-intro="Đây là tab Thông tin cá nhân">Thông tin
                            cá nhân</a>
                    </li>
                    <li>
                        <a href="#wallet"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Ví</a>
                    </li>
                    <li>
                        <a href="#transaction"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Giao
                            dịch</a>
                    </li>
                    <li>
                        <a href="#categories"
                            class="tab-link block py-2 border border-teal-300 rounded hover:bg-teal-50 transition">Danh
                            Mục</a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-2 relative flex flex-col justify-center p-2 md:p-6 bg-white shadow-md rounded-xl space-y-8">
                <div id="tab-loader"
                    class="hidden absolute inset-0 bg-white/60 backdrop-blur-sm z-20 flex items-center justify-center rounded-xl">
                    <div class="w-12 h-12 border-4 border-dashed border-teal-500 rounded-full animate-spin"></div>
                </div>
                <div id="profile" class="tab-content hidden">
                    <div class="flex justify-center items-center">
                        <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user text-teal-500"></i> Thông Tin Cá Nhân
                        </h2>
                    </div>

                    <form action="{{ route('client.update-info') }}" method="POST" enctype="multipart/form-data"
                        class="w-full bg-gray-50 p-2 md:p-6 rounded-lg border border-gray-100">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            @include('client.components.forms.input', [
                                'name' => 'first_name',
                                'label' => trans('users.users.first_name'),
                                'value' => $user->first_name,
                                'placeholder' => 'Vui Lòng Nhập Tên Của Bạn',
                            ])
                            @include('client.components.forms.input', [
                                'name' => 'last_name',
                                'label' => trans('users.users.last_name'),
                                'value' => $user->last_name,
                                'placeholder' => 'Vui Lòng Nhập Họ Của Bạn',
                            ])
                        </div>

                        <div class="mb-4">
                            @include('client.components.forms.input', [
                                'name' => 'email',
                                'label' => trans('users.users.email'),
                                'value' => $user->email,
                                'placeholder' => 'Vui Lòng Nhập Email Của Bạn',
                            ])
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            @include('client.components.forms.date', [
                                'name' => 'birth_date',
                                'label' => trans('users.users.birth_date'),
                                'value' => $user->birth_date,
                                'type' => 'date',
                                'placeholder' => '2004-04-10',
                            ])

                            @include('client.components.forms.select', [
                                'name' => 'gender',
                                'label' => trans('users.users.gender'),
                                'value' => $user->gender,
                                'placeholder' => 'Vui Lòng Chọn Giới Tính',
                                'options' => \App\Consts\UserConst::GENDER,
                            ])
                        </div>

                        @include('client.components.elements.button', [
                            'text' => 'Lưu Thay Đổi',
                            'type' => 'submit',
                            'icon' => 'save',
                        ])
                    </form>
                </div>

                <div id="wallet" class="tab-content">
                    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-teal-500"></i> Ví của bạn
                    </h2>
                    @if ($wallets->count())
                        <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
                            @foreach ($wallets as $wallet)
                                <li class="py-3 px-4 hover:bg-teal-50 transition">
                                    <span class="font-semibold">{{ $wallet->name }}:</span>
                                    {{ number_format($wallet->balance, 0, ',', '.') }} VND
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 italic">Bạn chưa có ví nào.</p>
                    @endif
                </div>

                <div id="transaction" class="tab-content hidden">
                    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-teal-500"></i> Lịch sử Giao Dịch
                    </h2>
                    @if ($transactions->count())
                        <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
                            @foreach ($transactions as $tx)
                                <li class="py-3 px-4 hover:bg-teal-50 transition">
                                    <span class="font-semibold">{{ $tx->occurred_at }}:</span>
                                    {{ $tx->description }} — <span
                                        class="text-teal-600 font-medium">{{ number_format($tx->amount, 0, ',', '.') }}
                                        VND</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 italic">Bạn chưa có giao dịch nào.</p>
                    @endif
                </div>

                <div id="categories" class="tab-content hidden">
                    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-list-ul text-teal-500"></i> Danh Mục
                    </h2>
                    @if ($categories->count())
                        <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
                            @foreach ($categories as $category)
                                <li class="py-3 px-4 hover:bg-teal-50 transition">
                                    <span class="font-semibold">Tên danh mục:</span> {{ $category->name }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 italic">Bạn chưa có danh mục nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const STORAGE_KEY = 'myexpense-current-tab';

            function activateTab(selector) {
                $('#tab-loader').removeClass('hidden').fadeIn(150);

                setTimeout(() => {
                    $('.tab-content').hide();
                    $(selector).fadeIn(100);

                    $('#menu-tabs .tab-link')
                        .removeClass('bg-teal-500 text-white')
                        .addClass('hover:bg-teal-50 border border-teal-300');

                    $('#menu-tabs .tab-link[href="' + selector + '"]')
                        .removeClass('hover:bg-teal-50 border border-teal-300')
                        .addClass('bg-teal-500 text-white');

                    $('#tab-loader').fadeOut(100);
                }, 100);
            }

            const savedTab = localStorage.getItem(STORAGE_KEY) || '#profile';
            activateTab(savedTab);

            $('#menu-tabs').on('click', '.tab-link', function(e) {
                e.preventDefault();
                const target = $(this).attr('href');
                activateTab(target);
                localStorage.setItem(STORAGE_KEY, target);
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'OK'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Thất Bại!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush

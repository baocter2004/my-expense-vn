@extends('client.layouts.master')

@section('title', 'Quản Lý Chi Tiêu')

@section('content')
    <div class="w-full space-y-10">
        <div class="w-full min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-teal-100 via-white to-cyan-50 p-3 rounded-custom-sides"
            data-aos="fade-down">

            <div class="w-full flex flex-col justify-center items-center p-4 space-y-6">
                <h2 class="text-3xl font-extrabold text-cyan-500">Gửi Đánh Giá Của Bạn</h2>
                <p class="text-base text-gray-600 max-w-lg leading-relaxed text-center">
                    Chúng tôi rất mong nhận được phản hồi từ bạn để không ngừng cải thiện dịch vụ.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <form id="feedback-form" action="{{ route('client.submit') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @include('client.components.forms.input', [
                                    'icon' => 'user',
                                    'label' => 'Họ',
                                    'name' => 'last_name',
                                    'placeholder' => 'vui lòng nhập họ',
                                    'required' => true,
                                ])
                                @include('client.components.forms.input', [
                                    'icon' => 'user',
                                    'label' => 'Tên',
                                    'name' => 'first_name',
                                    'placeholder' => 'vui lòng nhập tên',
                                    'required' => true,
                                ])
                            </div>
                            @include('client.components.forms.input', [
                                'icon' => 'envelope',
                                'label' => 'Email',
                                'name' => 'email',
                                'placeholder' => 'Email của bạn',
                                'required' => true,
                            ])
                            @include('client.components.forms.select', [
                                'icon' => 'list-alt',
                                'label' => 'Chủ Đề',
                                'name' => 'subject',
                                'options' => $contacts,
                                'placeholder' => 'Chủ đề muốn góp ý ',
                                'required' => true,
                            ])
                            @include('client.components.forms.text-area', [
                                'icon' => 'comment',
                                'label' => 'Nội dung đánh giá',
                                'name' => 'message',
                                'placeholder' => 'Viết đánh giá hoặc góp ý của bạn...',
                                'rows' => 5,
                                'required' => true,
                            ])
                            <div class="flex items-center gap-2 mt-4">
                                <input type="checkbox" name="subscribe" id="subscribe" value="1"
                                    {{ old('subscribe') ? 'checked' : '' }}
                                    class="h-4 w-4 text-teal-500 border-gray-300 rounded">
                                <label for="subscribe" class="text-sm text-gray-700">
                                    Tôi muốn nhận bản tin qua email
                                </label>
                            </div>

                        </form>
                    </div>

                    <div class="flex flex-col justify-center space-y-4">
                        <div class="w-full">
                            <img class="w-full object-contain max-h-64" src="{{ asset('images/contact.png') }}"
                                alt="Hình minh họa đánh giá khách hàng">
                        </div>

                        <ul class="mt-4 text-sm text-gray-600 hidden md:grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-heart text-cyan-500"></i> Lắng nghe
                                khách hàng</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-bolt text-cyan-500"></i> Cải tiến
                                dịch vụ</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-gem text-cyan-500"></i> Trải nghiệm
                                tốt hơn</li>
                            <li class="flex items-center gap-x-2"><i class="fa-solid fa-handshake text-cyan-500"></i> Xây
                                dựng cộng đồng</li>
                        </ul>

                        <button type="submit" form="feedback-form"
                            class="w-full bg-gradient-to-r from-cyan-500 to-teal-400 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
                            <i class="fa-solid fa-paper-plane"></i> Gửi Đánh Giá
                        </button>

                        <p class="text-center mt-4 text-xs text-gray-500">
                            Cảm ơn bạn đã đồng hành cùng <span class="text-cyan-500 font-semibold">MyExpenseVn</span>!
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('/js/faq-modal.js') }}"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
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

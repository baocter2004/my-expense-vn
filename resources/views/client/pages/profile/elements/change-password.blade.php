<div
    class=" mx-auto mb-6 bg-white rounded-lg shadow-sm flex flex-col items-center text-center gap-3
         md:flex-row md:justify-between md:items-center md:text-left md:gap-0 p-4">
    <div class="flex items-center gap-2">
        <h2
            class="flex items-center gap-2 text-lg font-extrabold text-teal-600
           border-b-2  border-teal-200 pb-1 md:pb-0">
            <i class="fa-solid fa-key text-teal-500 text-lg md:text-xl"></i>
            Đổi mật khẩu
        </h2>
    </div>
</div>


<form action="{{ route('client.update-password') }}" method="POST"
    class="w-full bg-gray-50 p-2 md:p-6 rounded-lg border border-gray-100">
    @csrf
    @method('PATCH')

    @if (!$user->google_id || $user->is_change_password)
        <div class="mb-4">
            @include('client.components.forms.input', [
                'name' => 'current_password',
                'label' => 'Mật khẩu hiện tại',
                'type' => 'password',
                'placeholder' => 'Nhập mật khẩu hiện tại',
            ])
        </div>
    @endif

    <div class="mb-4">
        @include('client.components.forms.input', [
            'name' => 'new_password',
            'label' => 'Mật khẩu mới',
            'type' => 'password',
            'placeholder' => 'Nhập mật khẩu mới',
        ])
    </div>

    <div class="mb-4">
        @include('client.components.forms.input', [
            'name' => 'new_password_confirmation',
            'label' => 'Xác nhận mật khẩu mới',
            'type' => 'password',
            'placeholder' => 'Nhập lại mật khẩu mới',
        ])
    </div>

    @include('client.components.elements.button', [
        'text' => 'Cập nhật mật khẩu',
        'type' => 'submit',
        'icon' => 'save',
    ])
</form>

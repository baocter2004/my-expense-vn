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

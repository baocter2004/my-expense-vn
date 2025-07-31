<div
    class=" mx-auto mb-6 bg-white rounded-lg shadow-sm flex flex-col items-center text-center gap-3
         md:flex-row md:justify-between md:items-center md:text-left md:gap-0 p-4">
    <div class="flex items-center gap-2">
        <h2
            class="flex items-center gap-2 text-lg font-extrabold text-teal-600
           border-b-2  border-teal-200 pb-1 md:pb-0">
            <i class="fa-solid fa-user text-teal-500 text-lg md:text-xl"></i> Thông Tin Cá Nhân
        </h2>
    </div>
</div>

<form action="{{ route('client.update-info') }}" method="POST" enctype="multipart/form-data"
    class="w-full bg-gray-50 p-2 md:p-3 rounded-lg border border-gray-100">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        @include('client.components.forms.input', [
            'name' => 'first_name',
            'label' => trans('users.users.first_name'),
            'value' => $user->first_name,
            'placeholder' => 'Vui Lòng Nhập Tên Của Bạn',
            'required' => true,
        ])
        @include('client.components.forms.input', [
            'name' => 'last_name',
            'label' => trans('users.users.last_name'),
            'value' => $user->last_name,
            'placeholder' => 'Vui Lòng Nhập Họ Của Bạn',
            'required' => true,
        ])
    </div>

    <div class="mb-4">
        @include('client.components.forms.input', [
            'name' => 'email',
            'label' => trans('users.users.email'),
            'value' => $user->email,
            'placeholder' => 'Vui Lòng Nhập Email Của Bạn',
            'required' => true,
        ])
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        @include('client.components.forms.date', [
            'name' => 'birth_date',
            'label' => trans('users.users.birth_date'),
            'value' => $user->birth_date,
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

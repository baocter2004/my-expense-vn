@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'icon' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="w-full">
    <label for="{{ $name }}" class="flex items-center gap-x-2 text-sm font-medium text-teal-500 mb-1">
        @if ($icon)
            <i class="fa-solid fa-{{ $icon }}"></i>
        @endif
        {{ $label }}
        @if ($required)
            <span class="text-red-500 text-base leading-none">*</span>
        @endif
    </label>

    <div class="relative">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            @if ($disabled) disabled @endif value="{{ old($name, request($name, $value)) }}"
            placeholder="{{ $placeholder }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500 {{ $hasError ? 'is-valid' : '' }} {{ $type === 'password' ? 'pr-10' : 'pr-4' }}">
        @if ($type === 'password')
            <button type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-teal-500 toggle-password"
                data-target="#{{ $name }}" id="toggle-{{ $name }}">
                <i class="fa-solid fa-eye"></i>
            </button>
        @endif
    </div>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

@if ($type === 'password')
    @push('scripts')
        <script>
            $(function() {
                $('#toggle-{{ $name }}').off('click').on('click', function() {
                    let $inp = $($(this).data('target'));
                    let $icon = $(this).find('i');
                    if ($inp.attr('type') === 'password') {
                        $inp.attr('type', 'text');
                        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        $inp.attr('type', 'password');
                        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });
        </script>
    @endpush
@endif

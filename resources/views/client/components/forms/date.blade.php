@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'icon' => '',
    'required' => false,
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
        <input id="{{ $name }}" name="{{ $name }}" type="text"
            value="{{ old($name, request($name, $value)) }}" placeholder="{{ $placeholder }}"
            class="flatpickr w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500 {{ $hasError ? 'is-valid' : '' }}">

        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

@push('js')
    <script>
        $(function() {
            $('#{{ $name }}').flatpickr({
                dateFormat: "Y-m-d",
                disableMobile: true
            });
        });
    </script>
@endpush

@props([
    'label' => '',
    'name' => '',
    'icon' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $name }}" class="flex items-center gap-x-2 text-sm font-medium text-teal-500 mb-1">
            @if ($icon)
                <i class="fa-solid fa-{{ $icon }}"></i>
            @endif
            {{ $label }}
            @if ($required)
                <span class="text-red-500 text-base leading-none">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500 {{ $hasError ? 'is-valid' : '' }}">{{ old($name, request($name, $value)) }}</textarea>
    </div>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

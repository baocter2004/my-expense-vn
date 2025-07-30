@props([
    'label' => '',
    'name' => '',
    'checked' => false,
    'id' => uniqid('toggle-'),
    'url' => null,
    'required' => false,
    'dataId' => null,
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="w-full flex justify-start items-center gap-4">
    @if ($label)
        <label for="{{ $id }}" class="text-sm font-medium text-teal-500 mb-1 inline-block">
            {{ $label }}
            @if ($required)
                <span class="text-red-500 text-base leading-none">*</span>
            @endif
        </label>
    @endif

    <label class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="sr-only peer toggle-status"
            data-id="{{ $dataId }}" data-url="{{ $url }}" {{ $checked ? 'checked' : '' }}>

        <div
            class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-teal-300 rounded-full peer-checked:bg-teal-500 transition-all">
        </div>

        <span
            class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform">
        </span>
    </label>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

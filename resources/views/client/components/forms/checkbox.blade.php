@props([
    'label' => '',
    'name' => '',
    'checked' => false,
    'id' => uniqid('toggle-'),
    'required' => false,
])

@php
    $isChecked = old($name, $checked ? 1 : 0) == 1;
@endphp

<div class="w-full flex items-center gap-4">
    @if ($label)
        <label for="{{ $id }}" class="text-sm font-medium text-teal-500">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif


    <label class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="sr-only peer" value="1"
            {{ $isChecked ? 'checked' : '' }}>
        <div
            class="w-10 h-5 bg-gray-200 rounded-full peer-focus:ring-2 peer-focus:ring-teal-300 peer-checked:bg-teal-500 transition-all">
        </div>
        <span
            class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform"></span>
    </label>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

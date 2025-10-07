@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'icon' => '',
    'required' => false,
    // mới: bật time/seconds khi cần
    'with_time' => false,
    'with_seconds' => false,
    // tùy chọn: hiển thị giờ 24h
    'time_24hr' => true,
])

@php
    $hasError = $errors->has($name);
    // đảm bảo value là string để flatpickr nhận (nếu cần bạn có thể format trước khi truyền vào)
    $value = old($name, request($name, $value));
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
        <input id="{{ $name }}" name="{{ $name }}" type="text" value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="flatpickr w-full pl-4 pr-10 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500 {{ $hasError ? 'is-invalid' : '' }}">

        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
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
            const enableTime = @json((bool) $with_time || (bool) $with_seconds);
            const enableSeconds = @json((bool) $with_seconds);
            const time24hr = @json((bool) $time_24hr);

            let dateFormat = "Y-m-d";
            if (enableTime) {
                dateFormat = enableSeconds ? "Y-m-d H:i:S" : "Y-m-d H:i";
            }

            $('#{{ $name }}').flatpickr({
                dateFormat: dateFormat,
                disableMobile: true,
                enableTime: enableTime,
                time_24hr: time24hr,
                enableSeconds: enableSeconds,
            });
        });
    </script>
@endpush

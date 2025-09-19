@props([
    'label' => '',
    'name' => '',
    'options' => [], // Cho phép mảng optgroup hoặc mảng thường
    'value' => '',
    'placeholder' => '',
    'icon' => '',
])

@php
    $hasError = $errors->has($name);
    $selected = old($name, request($name, $value));
@endphp

<div class="w-full">
    <label for="{{ $name }}" class="flex items-center gap-x-2 text-sm font-medium text-teal-500 mb-1">
        @if ($icon)
            <i class="fa-solid fa-{{ $icon }}"></i>
        @endif
        {{ $label }}
    </label>

    <div class="relative">
        <button type="button" id="{{ $name }}_btn"
            class="w-full px-4 py-2 border rounded-lg text-left bg-white focus:outline-none focus:ring-1 focus:ring-teal-500">
            {{ $options[$selected] ?? ($placeholder ?? 'Chọn...') }}
        </button>

        <div id="{{ $name }}_dropdown"
            class="absolute z-20 hidden w-full mt-1 bg-white border rounded-lg shadow max-h-60 overflow-auto">

            <div class="p-2 border-b">
                <input type="text" id="{{ $name }}_search" placeholder="Tìm kiếm..."
                    class="w-full px-3 py-1 border rounded focus:outline-none focus:ring-1 focus:ring-teal-400 text-sm">
            </div>

            <ul class="text-sm" id="{{ $name }}_list">
                @foreach ($options as $groupLabel => $groupOptions)
                    @if (is_array($groupOptions))
                        <li class="px-3 py-1 text-xs font-semibold text-gray-500 bg-gray-50">{{ $groupLabel }}</li>
                        @foreach ($groupOptions as $optValue => $optLabel)
                            <li>
                                <button type="button" data-value="{{ $optValue }}"
                                    class="w-full text-left px-4 py-2 hover:bg-teal-50 {{ (string) $selected === (string) $optValue ? 'bg-teal-100' : '' }}">
                                    {{ $optLabel }}
                                </button>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <button type="button" data-value="{{ $groupLabel }}"
                                class="w-full text-left px-4 py-2 hover:bg-teal-50 {{ (string) $selected === (string) $groupLabel ? 'bg-teal-100' : '' }}">
                                {{ $groupOptions }}
                            </button>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" id="{{ $name }}_hidden" value="{{ $selected }}">

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

@push('js')
    <script>
        $(function() {
            const btn = $('#{{ $name }}_btn');
            const dropdown = $('#{{ $name }}_dropdown');
            const hidden = $('#{{ $name }}_hidden');
            const search = $('#{{ $name }}_search');

            btn.on('click', function() {
                dropdown.toggleClass('hidden');
                search.val('').trigger('input').focus();
            });

            dropdown.on('click', 'button[data-value]', function() {
                const val = $(this).data('value');
                const label = $(this).text().trim();
                hidden.val(val);
                btn.text(label);
                dropdown.addClass('hidden');
            });

            search.on('input', function() {
                const q = $(this).val().toLowerCase();
                $('#{{ $name }}_list button[data-value]').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).closest('li').toggle(text.includes(q));
                });
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#{{ $name }}_btn, #{{ $name }}_dropdown')
                    .length) {
                    dropdown.addClass('hidden');
                }
            });
        });
    </script>
@endpush

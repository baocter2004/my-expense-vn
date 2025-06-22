@props(['label' => '', 'name' => '', 'type' => 'text', 'icon' => ''])

<div class="w-full">
    <label for="{{ $name }}" class="flex items-center gap-x-2 text-sm font-medium text-gray-700 mb-1">
        @if ($icon)
            <i class="fa-solid fa-{{ $icon }}"></i>
        @endif
        {{ $label }}
    </label>

    <div class="relative">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name) }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500 pr-10 
            @error($name) border-red-500 focus:ring-red-500 @enderror">

        @if ($type === 'password')
            <button type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-teal-500 toggle-password"
                data-target="#{{ $name }}">
                <i class="fa-solid fa-eye"></i>
            </button>
        @endif
    </div>

    @error($name)
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>

@if ($type === 'password')
    @push('js')
        <script>
            $(function() {
                $('.toggle-password').off('click').on('click', function() {
                    let target = $($(this).data('target'));
                    let icon = $(this).find('i');

                    if (target.attr('type') === 'password') {
                        target.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        target.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });
        </script>
    @endpush
@endif

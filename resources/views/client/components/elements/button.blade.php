@props(['type', 'icon', 'text'])
<button type="{{ $type }}"
    class="w-full bg-teal-500 text-white font-semibold py-2 px-4 rounded-xl flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
    <i class="fa-solid fa-{{ $icon }}"></i> {{ $text }}
</button>

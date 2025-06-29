@props(['type', 'icon', 'text'])
<button type="{{ $type }}"
    class="w-full bg-gradient-to-r from-teal-500 to-cyan-400 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center gap-x-2 shadow hover:shadow-lg transition">
    <i class="fa-solid fa-{{ $icon }}"></i> {{ $text }}
</button>

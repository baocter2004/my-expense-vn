@props(['type' , 'icon' , 'text'])
<button type="{{ $type }}"
    class="w-full bg-teal-500 text-white font-medium py-2.5 rounded-lg hover:bg-teal-600 transition-colors flex items-center justify-center gap-x-2">
    <i class="fa-solid fa-{{ $icon }}"></i> {{ $text }}
</button>

@if (isset($items) && count($items) > 0)
    <nav class="inline-flex bg-white/70 backdrop-blur-sm border border-gray-200 rounded-xl px-4 py-2 shadow-sm mb-4"
        aria-label="breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            @foreach ($items as $index => $item)
                @if ($item['url'] ?? false)
                    <li>
                        <a href="{{ $item['url'] }}" class="hover:text-teal-500 flex items-center">
                            @if (!empty($item['icon']))
                                <i class="fa {{ $item['icon'] }} mr-1"></i>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    </li>
                    @if (!$loop->last)
                        <li><i class="fa fa-chevron-right text-xs text-gray-400"></i></li>
                    @endif
                @else
                    <li class="text-teal-600 font-semibold flex items-center">
                        @if (!empty($item['icon']))
                            <i class="fa {{ $item['icon'] }} mr-1"></i>
                        @endif
                        {{ $item['label'] }}
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-6">
        <ul class="inline-flex items-center space-x-1 text-sm">
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1 bg-gray-100 text-gray-400 rounded cursor-not-allowed">
                    <i class="fa-solid fa-angle-left"></i>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-1 bg-white border border-gray-300 text-gray-600 rounded hover:bg-gray-50 transition">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-1 text-gray-400">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-1 bg-teal-600 text-white rounded font-semibold">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-1 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-1 bg-white border border-gray-300 text-gray-600 rounded hover:bg-gray-50 transition">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
            @else
                <li class="px-3 py-1 bg-gray-100 text-gray-400 rounded cursor-not-allowed">
                    <i class="fa-solid fa-angle-right"></i>
                </li>
            @endif
        </ul>
    </nav>
@endif

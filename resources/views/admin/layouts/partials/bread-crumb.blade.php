<nav class="flex mb-6" aria-label="Breadcrumb">
    <ul class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="inline-flex items-center">
                @if ($loop->first && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}"
                        class="inline-flex items-center text-gray-500 hover:text-teal-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 1.707a1 1 0 00-1.414 0L1 10h2v8a1 1 0 001 1h5v-6h2v6h5a1 1 0 001-1v-8h2l-8.293-8.293z" />
                        </svg>
                        {{ $breadcrumb['label'] }}
                    </a>
                @elseif ($loop->first && $loop->last)
                    <span class="inline-flex items-center text-gray-700 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 1.707a1 1 0 00-1.414 0L1 10h2v8a1 1 0 001 1h5v-6h2v6h5a1 1 0 001-1v-8h2l-8.293-8.293z" />
                        </svg>
                        {{ $breadcrumb['label'] }}
                    </span>
                @elseif (!$loop->last)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414L12.414 10l-3.707 3.707a1 1 0 01-1.414 0z" />
                        </svg>
                        <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-teal-500 transition-colors">
                            {{ $breadcrumb['label'] }}
                        </a>
                    </div>
                @else
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414L12.414 10l-3.707 3.707a1 1 0 01-1.414 0z" />
                        </svg>
                        <span class="text-teal-500 font-medium">{{ $breadcrumb['label'] }}</span>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
</nav>

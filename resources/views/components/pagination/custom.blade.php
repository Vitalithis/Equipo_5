@if ($paginator->hasPages())
    <nav role="navigation" class="flex items-center justify-center space-x-2 text-sm" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 bg-white border border-green-300 text-green-400 rounded cursor-default">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 bg-white border border-green-500 text-green-700 hover:bg-green-50 rounded">‹</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-green-500 text-white rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 bg-white border border-green-300 text-green-700 hover:bg-green-50 rounded">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 bg-white border border-green-500 text-green-700 hover:bg-green-50 rounded">›</a>
        @else
            <span class="px-3 py-1 bg-white border border-green-300 text-green-400 rounded cursor-default">›</span>
        @endif
    </nav>
@endif

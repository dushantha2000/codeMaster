@if ($paginator->hasPages())
    <nav class="flex items-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-5 py-2.5 bg-white/5 border border-white/5 rounded-xl text-gray-600 font-bold text-sm cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white font-bold text-sm transition-all">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="w-10 h-10 flex items-center justify-center text-gray-600 font-bold">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- Active Page --}}
                        <span class="w-10 h-10 flex items-center justify-center bg-blue-600/20 border border-blue-500/50 rounded-xl text-blue-400 font-black text-sm shadow-lg shadow-blue-500/10">
                            {{ $page }}
                        </span>
                    @else
                        {{-- Inactive Page --}}
                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center bg-white/5 border border-white/5 rounded-xl text-gray-400 hover:bg-white/10 hover:text-white font-bold text-sm transition-all">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-8 py-2.5 bg-[#FF9F00] rounded-xl text-black font-black text-sm hover:bg-orange-400 transition-all shadow-lg shadow-orange-500/20">
                Next
            </a>
        @else
            <span class="px-8 py-2.5 bg-white/5 border border-white/5 rounded-xl text-gray-600 font-bold text-sm cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif
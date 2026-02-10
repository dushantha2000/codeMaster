@if ($paginator->hasPages())
    <nav class="flex items-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-5 py-2.5 bg-white/5 border border-white/5 rounded-xl text-gray-600 font-bold text-sm cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white font-bold text-sm transition-all">Prev</a>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-10 h-10 flex items-center justify-center bg-white/20 border border-white/20 rounded-xl text-white font-bold text-sm shadow-xl">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center bg-white/5 border border-white/5 rounded-xl text-gray-400 hover:bg-white/10 hover:text-white font-bold text-sm transition-all">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-8 py-2.5 bg-[#FF9F00] rounded-xl text-black font-black text-sm hover:bg-[#e68a00] transition-all shadow-lg shadow-orange-500/20">Next</a>
        @else
            <span class="px-8 py-2.5 bg-white/5 border border-white/5 rounded-xl text-gray-600 font-bold text-sm cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif
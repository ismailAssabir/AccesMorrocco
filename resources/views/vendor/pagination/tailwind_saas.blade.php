@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col items-center justify-center gap-4 py-4">
        {{-- Pill Controls --}}
        <div class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-300 cursor-default border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 text-slate-500 hover:border-[#b11d40] hover:text-[#b11d40] hover:shadow-lg hover:shadow-[#b11d40]/10 transition-all duration-300" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="flex items-center gap-2 px-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="text-slate-400 px-1 font-bold">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-[#b11d40] text-white text-sm font-black shadow-xl shadow-[#b11d40]/30 ring-4 ring-[#b11d40]/15 z-10 scale-110">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 text-sm font-bold hover:bg-slate-100 hover:text-slate-800 transition-all duration-300">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-slate-100 text-slate-500 hover:border-[#b11d40] hover:text-[#b11d40] hover:shadow-lg hover:shadow-[#b11d40]/10 transition-all duration-300" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-300 cursor-default border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

        {{-- Centered Stats --}}
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] opacity-60">
            Page <span class="text-slate-900">{{ $paginator->currentPage() }}</span> sur {{ $paginator->lastPage() }}
        </p>
    </nav>
@endif

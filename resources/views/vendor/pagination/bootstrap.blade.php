@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-6 paginationList">
        <ul class="inline-flex items-center">
            {{-- Önceki Sayfa --}}
            @if ($paginator->onFirstPage())
                <li class="text-gray-400 px-3 py-2  cursor-not-allowed">
                    ← Önceki
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="text-gray-400 no-underline px-3 py-2 ">
                        ← Önceki
                    </a>
                </li>
            @endif

            {{-- Sayfa Numaraları --}}
            @foreach ($elements as $element)
                {{-- Ayrım İşaretleri (...) --}}
                @if (is_string($element))
                    <li class="text-gray-500 px-3 py-2">{{ $element }}</li>
                @endif

                {{-- Sayfa Linkleri --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="text-yellow-600 font-bold px-3  py-2 ">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" 
                                   class="text-gray-400  px-3  py-2 ">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Sonraki Sayfa --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="text-gray-400 no-underline py-2 ">
                        Sonraki →
                    </a>
                </li>
            @else
                <li class="text-gray-400  cursor-not-allowed">
                    Sonraki →
                </li>
            @endif
        </ul>
    </nav>
@endif

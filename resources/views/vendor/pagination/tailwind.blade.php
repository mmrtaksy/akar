@if ($paginator->hasPages())
    <div class="post-pagination">
        <nav aria-label="Page navigation">
            <ul class="pagination flex items-center justify-center space-x-2">
                {{-- Önceki Sayfa Linki --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled  bg-transparent border-none" aria-disabled="true">
                        <span class="page-link bg-transparent border-none"><i class="fa fa-angle-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link bg-transparent border-none">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Sayfa Numaraları --}}
                @foreach ($elements as $element)
                    {{-- Ayrım Noktaları --}}
                    @if (is_string($element))
                        <li class="page-item disabled  bg-transparent border-none" aria-disabled="true">
                            <span class="page-link  bg-transparent border-none">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Sayfa Linkleri --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link  bg-transparent border-none">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link  bg-transparent border-none">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Sonraki Sayfa Linki --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link bg-transparent border-none">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled  bg-transparent border-none" aria-disabled="true">
                        <span class="page-link bg-transparent border-none"><i class="fa fa-angle-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

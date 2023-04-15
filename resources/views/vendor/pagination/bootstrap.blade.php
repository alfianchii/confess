@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Do first page --}}
                @if ($loop->first)
                    @if ($paginator->currentPage() > 2)
                        <li class="page-item">
                            <a data-bs-toggle="tooltip" data-bs-original-title="Halaman 1" class="page-link"
                                href="{{ $paginator->url(1) }}">«</a>
                        </li>
                    @endif
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li data-bs-toggle="tooltip" data-bs-original-title="Halaman {{ $page }}"
                                class="page-item active" aria-current="page"><span
                                    class="page-link">{{ $page }}</span></li>
                        @elseif (abs($page - $paginator->currentPage()) <= 1)
                            <li data-bs-toggle="tooltip" data-bs-original-title="Halaman {{ $page }}"
                                class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif

                {{-- Do last page --}}
                @if ($loop->last)
                    @if ($paginator->currentPage() < $paginator->lastPage() - 1)
                        <li class="page-item">
                            <a data-bs-toggle="tooltip" data-bs-original-title="Halaman {{ $paginator->lastPage() }}"
                                class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">»</a>
                        </li>
                    @endif
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

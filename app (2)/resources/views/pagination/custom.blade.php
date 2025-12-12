@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
            @endif

            {{-- First Page --}}
            <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Dots before current range --}}
            @if ($paginator->currentPage() > 3)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Middle Pages --}}
            @foreach (range(max(2, $paginator->currentPage() - 1), min($paginator->lastPage() - 1, $paginator->currentPage() + 1)) as $page)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Dots after current range --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Last Page --}}
            @if ($paginator->lastPage() > 1)
                <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif

        </ul>
    </nav>
@endif

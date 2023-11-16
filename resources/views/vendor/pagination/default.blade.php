<div class="row" style="align-items: center;">
    <div class="col-lg-6 col-md-6 col-12">
        <span class="page_counts">
            Showing {{ $paginator->firstItem()  }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        </span>
    </div>
    @if ($paginator->hasPages())
        <div class="col-lg-6 col-md-6 col-12 pagination_box">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if ($paginator->onFirstPage())
                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <a href="javascript:void(0)" aria-label="Previous">
                                <span class="move_previous" aria-hidden="true"></span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                                <span class="move_previous" aria-hidden="true"></span>
                            </a>
                        </li>
                    @endif
                    @if($paginator->currentPage() > 3)
                        <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
                    @endif
                    @if($paginator->currentPage() > 4)
                        <li><a>...</a></li>
                    @endif
                    @foreach(range(1, $paginator->lastPage()) as $i)
                        @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                            @if ($i == $paginator->currentPage())
                                <li class="active" style="background-color: #e46d29;border-radius: 25px;">
                                    <a class="active" style="color: white; margin: 0 10px;">{{ $i }}</a>
                                </li>
                            @else
                                <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endif
                    @endforeach
                    @if($paginator->currentPage() < $paginator->lastPage() - 3)
                        <li><a>...</a></li>
                    @endif
                    @if($paginator->currentPage() < $paginator->lastPage() - 2)
                        <li class="hidden-xs"><a
                                href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                        </li>
                    @endif

                    @if ($paginator->hasMorePages())

                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                                <span class="move_next" aria-hidden="true"></span>
                            </a>
                        </li>
                    @else
                        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <a href="javascript:void(0)" aria-label="Next">
                                <span class="move_next" aria-hidden="true"></span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>

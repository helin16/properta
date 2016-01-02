@if($data->count() > 0)
    <nav style="{{ $style or 'text-align: center' }}">
        <ul class="pagination">
            <li>
                <a href="{{ $data->currentPage() === 1 ? '#' : $data->url(1) }}"><i class="fa fa-step-backward"></i></a>
                <a href="{{ $data->previousPageUrl() ?: '#' }}"><i class="fa fa-chevron-left"></i></a>
            </li>
            @for($offset = -2; $offset <= 2; $offset++)
                <span class="hidden" {{ $pageNo = (($data->currentPage() + $offset) > 0 && ($data->currentPage() + $offset) <= $data->lastPage()) ? ($data->currentPage() + $offset) : null }}></span>
                <li class="{{ $offset === 0 ? 'active' : ( $pageNo ? '' : 'hidden' ) }}">
                    <a href="{{ ($pageNo && $pageNo !== $data->currentPage()) ? $data->url($pageNo) : '#' }}">{{ $pageNo ?: '' }}</a>
                </li>
            @endfor
            <li>
                <a href="{{ $data->nextPageUrl() ?: '#' }}"><i class="fa fa-chevron-right"></i></a>
                <a href="{{ $data->currentPage() === $data->lastPage() ? '#' : $data->url($data->lastPage()) }}"><i class="fa fa-step-forward"></i></a>
            </li>
        </ul>
    </nav>
@endif
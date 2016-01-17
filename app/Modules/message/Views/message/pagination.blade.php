@if($data->count() > 0)
    <div class="btn-group pull-right">
        @if($data->currentPage() > 2)
            <a class="btn btn-white btn-sm" href="{{ $data->currentPage() === 1 ? '#' : $data->url(1) }}"><i class="fa fa-step-backward"></i></a>
        @endif
        @for($offset = -2; $offset <= 2; $offset++)
            <span class="hidden" {{ $pageNo = (($data->currentPage() + $offset) > 0 && ($data->currentPage() + $offset) <= $data->lastPage()) ? ($data->currentPage() + $offset) : null }}></span>
            @if($pageNo)
                <a class="{{ 'btn btn-white btn-sm ' . ($offset === 0 ? 'active' : '') }}" href="{{ ($pageNo && $pageNo !== $data->currentPage()) ? $data->url($pageNo) : '#' }}">
                    <i>{{ $pageNo ?: '' }}</i>
                </a>
            @endif
        @endfor
        @if($data->currentPage() < ($data->lastPage() - 1) )
            <a class="btn btn-white btn-sm" href="{{ $data->currentPage() === $data->lastPage() ? '#' : $data->url($data->lastPage()) }}"><i class="fa fa-step-forward"></i></a>
        @endif
    </div>
@endif
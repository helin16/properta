<nav style="text-align: center">
    <ul class="pagination">
        <li>
            <a href="{{$items['prev_page_url'] ?: '#'}}" class="{{ $items['prev_page_url'] ? '' : 'hidden' }}">&laquo;</a>
        </li>
        @for($offset = -2; $offset <= 2; $offset++)
            <li class="{{ $offset === 0 ? 'active' : '' }}">
                <a href="{{ preg_replace('/page=\d+$/', 'page=' . ($items['current_page'] + $offset), $items['prev_page_url'] ?: $items['next_page_url']) }}"
                   class="{{ (($items['current_page'] + $offset) > 0 && ($items['current_page'] + $offset) <= $items['last_page']) ? '' : 'hidden' }}">
                    {{ (($items['current_page'] + $offset) > 0 && ($items['current_page'] + $offset) <= $items['last_page']) ? ($items['current_page'] + $offset) : '' }}
                </a>
            </li>
        @endfor
        <li>
            <a href="{{$items['next_page_url'] ?: '#'}}" class="{{ $items['next_page_url'] ? '' : 'hidden' }}">&raquo;</a>
        </li>
    </ul>
</nav>
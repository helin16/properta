<div class="row">
    @if(isset($title) && $title)
        <div class="{!! $title['class'] or 'col-sm-2' !!}">{!! $title['content'] !!}</div>
    @endif
    @if(isset($body) && $body)
        <div class="{!! $body['class'] or ((isset($title) && $title) ? 'col-sm-10' : 'col-sm-12') !!}">{!! $body['content'] !!}</div>
    @endif
</div>
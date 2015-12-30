<div class="row">
    <div class="{{ $title['class'] or 'col-sm-2' }}">{{ ucfirst('media') }}</div>
    <div class="{{ $body['class'] or 'col-sm-10' }}">
        @foreach($media as $single_media)
            @if($single_media)
                @include('message::media.single', ['media' => $single_media])
            @endif
        @endforeach
    </div>
</div>
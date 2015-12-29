<div class="row">
    <div class="{{ $title['class'] or 'col-sm-2' }}">{{ ucfirst('media') }}</div>
    <div class="{{ $body['class'] or 'col-sm-10' }}">
        @foreach($media as $single_media)
            @if($single_media)
                <a href="{{ $single_media->path }}" target="_blank" download="{{ $single_media->name }}">{{ $single_media->name }}</a>
            @endif
        @endforeach
    </div>
</div>
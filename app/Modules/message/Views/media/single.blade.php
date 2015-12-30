<a media_id="{{ $media->id }}" href="{{ $media->path }}" target="_blank"
    @if(strpos($media->mimeType, 'image') === false)
        {!! ' download="' . $media->name . '""' !!}
    @endif
>{{ $media->name }}</a>
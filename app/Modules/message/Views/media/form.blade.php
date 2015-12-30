<div class="media form-group">
    @foreach($media as $single_media)
        @if($single_media)
            <div class="col-sm-10">
                <a href="{{ $single_media->path }}" target="_blank" download="{{ $single_media->name }}">{{ $single_media->name }}</a>
            </div>
            {!! Form::checkbox((isset($saveItem) ? $saveItem . '_' : '') . 'media_id_' . $single_media->id, 1, true, ['class' => 'col-sm-2']) !!}
        @endif
    @endforeach
    {!! Form::file('media_new', ['class' => 'col-sm-12']) !!}
</div>
@foreach($media as $single_media)
    @if($single_media)
        <div class="form-group">
            <div class="row">
                <div class="col-sm-10">
                    <a href="{{ $single_media->path }}" target="_blank" download="{{ $single_media->name }}">{{ $single_media->name }}</a>
                </div>
                {!! Form::checkbox((isset($saveItem) ? $saveItem  : '') . 'media_id_' . $single_media->id, 1, true, ['class' => 'col-sm-2']) !!}
            </div>
        </div>
    @endif
@endforeach
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::file((isset($saveItem) ? $saveItem  : '') . 'media_new') !!}
        </div>
    </div>
</div>
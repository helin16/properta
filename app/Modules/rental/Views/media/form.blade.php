<div class="media form-group">
    @foreach($media as $single_media)
        <div class="col-sm-10">{{ $single_media->name }}</div>
        {!! Form::checkbox('media_id_' . $single_media->id, 1, true, ['class' => 'col-sm-2']) !!}
    @endforeach
    {!! Form::file('media_new', ['class' => 'col-sm-12']) !!}
</div>
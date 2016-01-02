@extends('rental::base.base')
@section('container')
    {!! Form::open(array('route' => 'property.store')) !!}
        @include('rental::property.form', ['property' => $property])
        @include('rental::address.form', ['address' => $property ? $property->address : null])
        @foreach($property ? $property->logs->all() : [] as $log)
            <hr/>
            {!! Form::label('property_logs', ucfirst((trim($log->type) === '' ? '' : ($log->type . ' ')) . 'Log')) !!}
            @include('rental::base.list_row', ['body' => ['content' => $log->content]])
            @if(sizeof(json_decode($log->comments)) > 0)
                <div class="col-xs-12">&nbsp;</div>
            @endif
            @foreach(json_decode($log->comments) as $comments)
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('comments')], 'body' => ['content' => $comments]])
            @endforeach
        @endforeach
        {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
@endsection
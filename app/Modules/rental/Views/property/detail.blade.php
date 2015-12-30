@extends('rental::base.base')
@section('container')
    {!! Form::open(array('url' => '/property')) !!}
        @include('rental::property.form', ['property' => $property])
        @include('rental::address.form', ['address' => $property ? $property->address : null])
        @foreach($property ? $property->logs->all() : [] as $log)
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('type')], 'body' => ['content' => $log->type]])
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('content')], 'body' => ['content' => $log->content]])
            @foreach(json_decode($log->comments) as $comments)
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('comments')], 'body' => ['content' => $comments]])
            @endforeach
        @endforeach
        {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
@endsection
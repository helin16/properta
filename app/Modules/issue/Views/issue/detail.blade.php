{{--{{ die(var_dump($rentals)) }}--}}

@extends('rental::base.base')
@section('container')
    {!! Form::open(['url' => '/issue', 'files' => true]) !!}
        @include('issue::issue.form', ['issue' => $issue])
        {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
@endsection
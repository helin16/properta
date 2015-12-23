@extends('rental::base.base')
@section('container')
    {!! Form::open(array('url' => '/property')) !!}
        @include('rental::property.form', ['property' => $property])
        @include('rental::address.form', ['address' => $property['address']])
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
@endsection
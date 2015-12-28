@extends('rental::base.base')
@section('container')
    {!! Form::open(array('url' => '/property')) !!}
        @include('rental::property.form', ['property' => $property])
        @include('rental::address.form', ['address' => $property ? $property->address : null])
        {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
@endsection
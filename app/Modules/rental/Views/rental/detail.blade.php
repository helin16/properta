@extends('rental::base.base')
@section('container')
    {!! Form::open(array('url' => '/rental')) !!}
    @include('rental::rental.form', ['rental' => $rental])
    <hr/>
    <h4>Property Details</h4>
    @include('rental::property.form', ['property' => $rental['property']])
    @include('rental::address.form', ['address' => $rental['property']['address']])
    {!! Form::submit('Save') !!}
    {!! Form::close() !!}
@endsection
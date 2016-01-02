@extends('rental::base.base')
@section('container')
    {!! Form::open(['url' => '/rental', 'files' => true]) !!}
        {!! Form::label('property_id', 'Property') !!}
        @include('rental::property.select', ['property' => $rental ? $rental->property : null, 'properties' => $properties, 'options' => ['class' => 'form-control']])
        @include('rental::rental.form', ['rental' => $rental])
        {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    {!! Form::close() !!}
@endsection
@extends('rental::base.list')
@section('row')
    <li class="list-group-item">
        <div class="row title-row">
            <div class="col-sm-1">ID</div>
            <div class="col-sm-5">Description</div>
            <div class="col-sm-5">Address</div>
            <div class="col-sm-1">
                {!! Form::open(['method' => 'GET', 'route' => 'property.show']) !!}
                    {!! Form::submit('Create') !!}
                {!! Form::close() !!}
            </div>
        </div>
    </li>
    @foreach($properties as $property)
        <li class="list-group-item">
            <div class="row item-row" property_id="{{ $property['id'] }}">
                <div class="col-sm-1">{{ $property['id'] }}</div>
                <div class="col-sm-5">{{ $property['description'] }}</div>
                <div class="col-sm-5">@include('rental::address.inline', ['address' => $property['address']])</div>
                <div class="col-sm-1">
                    {!! Form::open(['method' => 'GET', 'url' => '/property/' . $property['id']]) !!}
                        {!! Form::submit('Update') !!}
                    {!! Form::close() !!}
                    {!! Form::open(['method' => 'DELETE', 'url' => '/property/' . $property['id']]) !!}
                        {!! Form::submit('Delete') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
@endsection
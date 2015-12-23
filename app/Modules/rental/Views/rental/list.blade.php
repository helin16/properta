@extends('rental::base.list')
@section('row')
    <li class="list-group-item">
        <div class="row title-row">
            <div class="col-sm-1">ID</div>
            <div class="col-sm-2">Daily Amount</div>
            <div class="col-sm-2">From</div>
            <div class="col-sm-2">To</div>
            <div class="col-sm-4">Address</div>
            <div class="col-sm-1">
                {!! Form::open(['method' => 'GET', 'route' => 'rental.show']) !!}
                    {!! Form::submit('Create') !!}
                {!! Form::close() !!}
            </div>
        </div>
    </li>
    @foreach($rentals as $rental)
        <li class="list-group-item">
            <div class="row item-row" rental_id="{{ $rental['id'] }}">
                <div class="col-sm-1">{{ $rental['id'] }}</div>
                <div class="col-sm-2">{{ $rental['dailyAmount'] }}</div>
                <div class="col-sm-2">{{ $rental['from'] }}</div>
                <div class="col-sm-2">{{ $rental['to'] }}</div>
                <div class="col-sm-4">@include('rental::address.inline', ['address' => $rental['property'] ? $rental['property']['address'] : []])</div>
                <div class="col-sm-1">
                    {!! Form::open(['method' => 'GET', 'url' => '/rental/' . $rental['id']]) !!}
                        {!! Form::submit('Update') !!}
                    {!! Form::close() !!}
                    {!! Form::open(['method' => 'DELETE', 'url' => '/rental/' . $rental['id']]) !!}
                        {!! Form::submit('Delete') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </li>
    @endforeach
@endsection
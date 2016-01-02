{{--{{ die(var_dump($data)) }}--}}
<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
@extends('rental::base.list')
@section('item-list')
    <div class="row">
        <strong style="line-height: 30px;">Found {{ $data->total() }} Rentals</strong>
        {!! Form::open(['method' => 'GET', 'route' => 'rental.show', 'class' => 'pull-right', 'style'=>'display:inline-block']) !!}
        {!! Form::button('Create', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    @foreach($data->all() as $rental)
        <li class="list-group-item row" rental_id="{{ $rental->id }}">
            <div class="col-sm-10">
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('address')], 'body' => ['content' => '<a href=' . URL::route('property.show', ['property_id' => $rental->property->id]) . '>' . $rental->property->address->inline() . '</a>']])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('Daily Amount')], 'body' => ['content' => money_format('%.2n',$rental->dailyAmount)]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('from')], 'body' => ['content' => $rental->from ? $rental->from->format('l jS \\of F Y h:i:s A') : 'Not Available']])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('to')], 'body' => ['content' => $rental->to ? $rental->to->format('l jS \\of F Y h:i:s A') : 'Not Available']])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('issues')], 'body' => ['content' => '<a href=' . URL::route('issue.index', ['rental_id' => $rental->id]) . '>' . $rental->issues->count() . '</a>' ]])
                @include('message::media.list', ['media' => $rental->media()->get()->all()])
            </div>
            <div class="col-sm-2">
                {!! Form::open(['method' => 'GET', 'route' => ['rental.show', $rental->id], 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['rental.destroy', $rental->id], 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </div>
        </li>
    @endforeach
@endsection
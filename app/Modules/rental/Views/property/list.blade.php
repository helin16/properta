<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
@extends('rental::base.list')
@section('item-list')
    <div class="row">
        <strong style="line-height: 30px;">Found {{ $data->total() }} Properties</strong>
        {!! Form::open(['method' => 'GET', 'route' => 'property.show', 'class' => 'pull-right', 'style'=>'display:inline-block']) !!}
            {!! Form::button('Create', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    @foreach($data->all() as $property)
        <li class="list-group-item row" property_id="{{ $property->id }}">
            <div class="col-sm-10">
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('address')], 'body' => ['content' => $property->address->inline()]])
                @foreach($property->details->all() as $detail)
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('type')], 'body' => ['content' => $detail->type]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('car Parks')], 'body' => ['content' => $detail->carParks]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('bedrooms')], 'body' => ['content' => $detail->bedrooms]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('bathrooms')], 'body' => ['content' => $detail->bathrooms]])
                    @foreach(json_decode($detail->options, true) as $option)
                        @include('rental::base.list_row', ['title' => ['content' => ucfirst(key($option))], 'body' => ['content' => $option[key($option)]]])
                    @endforeach
                @endforeach
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => money_format('%.2n',$property->rental()['averageDailyAmount']) ]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('description')], 'body' => ['content' => $property->description]])
            </div>
            <div class="col-sm-2">
                {!! Form::open(['method' => 'GET', 'url' => '/property/' . $property->id, 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'url' => '/property/' . $property->id, 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </div>
        </li>
    @endforeach
@endsection
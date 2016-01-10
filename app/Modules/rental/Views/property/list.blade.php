<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    {!! Form::open(['method' => 'GET', 'route' => 'property.show']) !!}
                        {!! Form::button('Create', array('type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'width: 100%')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @foreach($data->all() as $property)
            <div class="col-lg-12" property_id="{{ $property->id }}">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-11">
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
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => '<a href=' . URL::route('rental.index', ['property_id' => $property->id]) . '>' . money_format('%.2n',$property->rental()['averageDailyAmount']) . '</a>' ]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('issues')], 'body' => ['content' => '<a href=' . URL::route('issue.index', ['property_id' => $property->id]) . '>' . $property->rental()['issuesCount'] . '</a>' ]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('description')], 'body' => ['content' => $property->description]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('logs')], 'body' => ['content' => $property->logs->count() ]])
                            </div>
                            <div class="col-sm-1">
                                {!! Form::open(['method' => 'GET', 'route' => ['property.show', $property->id], 'style'=>'display:inline-block']) !!}
                                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['method' => 'DELETE', 'route' => ['property.destroy', $property->id], 'style'=>'display:inline-block']) !!}
                                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
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

        <li  style="margin-bottom: 10px" class="list-group-item row" property_id="{{ $property->id }}">
            {{--base information--}}
            <div class="col-sm-6">
                <div class="col-sm-6 pricepoint">
                    Daily Rental:
                    <a href="{{ URL::to('/rental/'.$property->id) }}" class="">{{money_format('%.2n',$property->rental()['averageDailyAmount'])}}</a>
                </div>
                <div class="col-sm-6 pricepoint">
                    Type:
                    @foreach($property->details->all() as $detail)
                        {{$detail->type}}
                    @endforeach
                </div>
                <div class="col-sm-12 address">
                    <i class="fa fa-location-arrow"></i>
                    <span class="">{{$property->address->inline()}}</span>
                </div>

                @foreach($property->details->all() as $detail)
                    <div class="col-sm-4">
                        <i class="icon icon-bed"></i> <span>{{$detail->bedrooms}}</span>
                    </div>
                    <div class="col-sm-4">
                        <i class="icon icon-tube"></i>
                        {{ ($detail->bathrooms === null ) ? '-' : $detail->bathrooms }}
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-car"></i>  {{$detail->carParks}}
                    </div>
                @endforeach
                <div class="col-sm-6">
                    <div class="pull-left">ISSUE:</div>
                    <div class="col-sm-8">{{$property->rental()['issuesCount']}}</div>
                </div>
                <div class="col-sm-6">
                    <div class="pull-left">Logs:</div>
                    <div class="col-sm-8">{{$property->logs->count()}}</div>
                </div>

            </div>
            {{--option--}}
            <div class="col-sm-6">
                @foreach($property->details->all() as $detail)
                    @foreach(json_decode($detail->options, true) as $option)
                        <div class="col-sm-4">{{ucfirst(key($option)).":"}}</div>
                        <div class="col-sm-8">{{$option[key($option)]}}</div>
                    @endforeach
                @endforeach
            </div>
            <hr>
            {{--description--}}
            <div class="col-sm-12 description">
                <div class="sm-title">Description:</div>
                <span>{{$property->description}}</span>
            </div>
            <div class="col-sm-2 pull-right">
                {!! Form::open(['method' => 'GET', 'route' => ['property.show', $property->id], 'style'=>'display:inline-block']) !!}
                {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['property.destroy', $property->id], 'style'=>'display:inline-block']) !!}
                {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                {!! Form::close() !!}
            </div>
{{--            <div class="col-sm-10">
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
            <div class="col-sm-2">
                {!! Form::open(['method' => 'GET', 'route' => ['property.show', $property->id], 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'route' => ['property.destroy', $property->id], 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </div>--}}
        </li>
    @endforeach
@endsection

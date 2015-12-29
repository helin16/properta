<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
@extends('rental::base.list')
@section('item-list')
    <div class="row">
        <strong style="line-height: 30px;">Found {{ $data->total() }} Issues</strong>
        {!! Form::open(['method' => 'GET', 'route' => 'issue.show', 'class' => 'pull-right', 'style'=>'display:inline-block']) !!}
            {!! Form::button('Create', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}
    </div>
    @foreach($data->all() as $issue)
{{--        {{ die(var_dump($issue->details)) }}--}}
        <li class="list-group-item row" issue_id="{{ $issue->id }}">
            <div class="col-sm-10">
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('address')], 'body' => ['content' => $issue->rental->property->address->inline()]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => money_format('%.2n', $issue->rental->property->rental()['averageDailyAmount']) ]])
                @foreach($issue->details->all() as $detail)
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('type')], 'body' => ['content' => $issue->details->first()->type]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('priority')], 'body' => ['content' => $issue->details->first()->priority]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('3rd Party')], 'body' => ['content' => $issue->details->first()['3rdParty']]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('content')], 'body' => ['content' => $issue->details->first()->content]])
                    @include('message::media.list', ['media' => $issue->details->first()->media()])
                @endforeach
                {{--@include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => money_format('%.2n',$property->rental()['averageDailyAmount']) ]])--}}
                {{--@include('rental::base.list_row', ['title' => ['content' => ucfirst('description')], 'body' => ['content' => $property->description]])--}}
            </div>
            <div class="col-sm-2">
                {!! Form::open(['method' => 'GET', 'url' => '/issue/' . $issue->id, 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'url' => '/issue/' . $issue->id, 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </div>
        </li>
    @endforeach
@endsection
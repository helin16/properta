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
        <li class="list-group-item row" issue_id="{{ $issue->id }}">
            <div class="col-sm-10">
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('requester')], 'body' => ['content' => $issue->requester_user->inline() ]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('status')], 'body' => ['content' => $issue->status ]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('address')], 'body' => ['content' => '<a href=' . URL::route('property.show', ['property_id' => $issue->rental->property->id]) . '>' . $issue->rental->property->address->inline() . '</a>' ]])
                @include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => '<a href=' . URL::route('rental.show', ['property_id' => $issue->rental->property->id]) . '>' . money_format('%.2n', $issue->rental->property->rental()['averageDailyAmount']) . '</a>' ]])
                @foreach($issue->details->all() as $detail)
                    <hr/>
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('type')], 'body' => ['content' => $detail->type]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('priority')], 'body' => ['content' => $detail->priority]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('3rd Party')], 'body' => ['content' => $detail['3rdParty']]])
                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('content')], 'body' => ['content' => $detail->content]])
                    @include('message::media.list', ['media' => $detail->media()->get()->all()])
                @endforeach
            </div>
            <div class="col-sm-2">
                {!! Form::open(['method' => 'GET', 'url' => URL::route('issue.show', $issue->id), 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE', 'url' => URL::route('issue.destroy', $issue->id), 'style'=>'display:inline-block']) !!}
                    {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </div>
        </li>
    @endforeach
@endsection
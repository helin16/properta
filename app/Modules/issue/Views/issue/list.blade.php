<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
@extends('abstracts::base.2_columns_left_nav_bar')
{{--{{ Session::get('currentUserId') }}--}}
@section('page_body')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    {!! Form::open(['method' => 'GET', 'route' => 'issue.show']) !!}
                        {!! Form::button('Create', array('type' => 'submit', 'class' => 'btn btn-primary', 'style' => 'width: 100%')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @foreach($data->all() as $issue)
            <div class="col-lg-12" issue_id="{{ $issue->id }}">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-11">
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('requester')], 'body' => ['content' => $issue->requester_user->inline() ]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('status')], 'body' => ['content' => $issue->status ]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('address')], 'body' => ['content' => '<a href=' . URL::route('property.show', ['property_id' => $issue->rental->property->id]) . '>' . $issue->rental->property->address->inline() . '</a>' ]])
                                @include('rental::base.list_row', ['title' => ['content' => ucfirst('rental')], 'body' => ['content' => '<a href=' . URL::route('rental.show', ['property_id' => $issue->rental->property->id]) . '>' . money_format('%.2n', $issue->rental->property->rental()['averageDailyAmount']) . '</a>' ]])
                                <hr/>
                                @include('issue::issue_detail.list', ['data' => $issue->details])
                            </div>
                            <div class="col-sm-1">
                                {!! Form::open(['method' => 'GET', 'url' => URL::route('issue.show', $issue->id), 'style'=>'display:inline-block']) !!}
                                    {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['method' => 'DELETE', 'url' => URL::route('issue.destroy', $issue->id), 'style'=>'display:inline-block']) !!}
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
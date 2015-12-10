@extends('app')
@section('content')
    <h1>Create New Issue</h1>

    {!! Form::open(['url' => 'dashboard/issues']) !!}
    @include('issues.detail')
    {!! Form::close() !!}

    @include('errors.list')
@stop
@extends('rental::base.base')
@section('container')
    {!! Form::open(['url' => '/issue', 'files' => true]) !!}
        @include('issue::issue.form', ['issue' => $issue])
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
        </div>
    {!! Form::close() !!}
@endsection
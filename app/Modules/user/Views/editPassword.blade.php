@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    {!! Form::open(array('url' => 'user/update-password')) !!}
    @if(Session::has('error'))
    <div class="alert-box success">
        <h2>{{ Session::get('error') }}</h2>
    </div>
    @endif
    <div class="controls">
        Current password
        {!! Form::text('now_password','',array('id'=>'','class'=>'form-control span6','placeholder' => 'Please Enter your Current Password')) !!}
        <p class="errors">{{$errors->first('email')}}</p>
    </div>
    <div class="controls">
        New password
        {!! Form::password('password',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
        <p class="errors">{{$errors->first('password')}}</p>
    </div>
    <div class="controls">
        Repeat password
        {!! Form::password('password_confirmation',array('class'=>'form-control span6', 'placeholder' => 'Please Repeat your Password')) !!}
        <p class="errors">{{$errors->first('password')}}</p>
    </div>
    <p>{!! Form::submit('Submit', array('class'=>'send-btn')) !!}</p>
    {!! Form::close() !!}
@endsection


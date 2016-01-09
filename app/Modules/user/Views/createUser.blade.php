@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
{!! Form::open(array('url' => 'user/create-user')) !!}
<h1>Create Sub user</h1>
@if(Session::has('error'))
<div class="alert-box success">
    <h2>{{ Session::get('error') }}</h2>
</div>
@endif
<div class="controls">
    First Name
    {!! Form::text('firstName','',array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your First Name')) !!}
    <p class="errors">{{$errors->first('firstName')}}</p>
</div>
<div class="controls">
    Last Name
    {!! Form::text('lastName','',array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your Last Name')) !!}
    <p class="errors">{{$errors->first('lastName')}}</p>
</div>
<div class="controls">
    Contact Number
    {!! Form::text('contactNumber','',array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your Email')) !!}
    <p class="errors">{{$errors->first('contactNumber')}}</p>
</div>

<div class="controls">
    Email
    {!! Form::text('email','',array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your Email')) !!}
    <p class="errors">{{$errors->first('email')}}</p>
</div>

<div class="controls">
    Password
    {!! Form::password('password',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
    <p class="errors">{{$errors->first('password')}}</p>
</div>
<div class="controls">
    Repeat password
    {!! Form::password('password_confirmation',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
    <p class="errors">{{$errors->first('password_confirmation')}}</p>
</div>



<div class="controls">
    Agent
    {!! Form::radio('type', 'male') !!}
</div>

<div class="controls">
    Tenant
    {!! Form::radio('type', 'female') !!}
</div>




<p>{!! Form::submit('Submit', array('class'=>'send-btn')) !!}</p>


{!! Form::close() !!}
@endsection

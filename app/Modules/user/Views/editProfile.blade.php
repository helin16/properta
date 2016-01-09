@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    {!! Form::open(array('url' => 'user/update-profile')) !!}
    @if(Session::has('error'))
    <div class="alert-box success">
        <h2>{{ Session::get('error') }}</h2>
    </div>
    @endif
    <div class="controls">
        First Name
        {!! Form::text('firstName',$data['firstName'],array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your First Name')) !!}
        <p class="errors">{{$errors->first('firstName')}}</p>
    </div>
    <div class="controls">
        Last Name
        {!! Form::text('lastName',$data['lastName'],array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your Last Name')) !!}
        <p class="errors">{{$errors->first('lastName')}}</p>
    </div>
    <div class="controls">
        Contact Number
        {!! Form::text('contactNumber',$data['contactNumber'],array('id'=>'','class'=>'form-control col-3 span6','placeholder' => 'Please Enter your Email')) !!}
        <p class="errors">{{$errors->first('contactNumber')}}</p>
    </div>
    <p>{!! Form::submit('Update', array('class'=>'send-btn')) !!}</p>
    {!! Form::close() !!}
@endsection
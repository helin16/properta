
{!! Form::open(array('url' => 'user/update-password')) !!}
<h1>Login</h1>
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
    {!! Form::password('password_confirmation',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
    <p class="errors">{{$errors->first('password')}}</p>
</div>
<p>{!! Form::submit('Login', array('class'=>'send-btn')) !!}</p>
{!! Form::close() !!}

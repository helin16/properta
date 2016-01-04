@extends('abstracts::base.1_column')
@section('page_body')

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">IN+</h1>

        </div>
        <h3>Welcome to Properta</h3>
        <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Login in. To see it in action.</p>
<!--        <form class="m-t" role="form" action="/user/login" method="post">-->
<!--            <div class="form-group">-->
<!--                <input type="email" class="form-control" name="email" placeholder="Email" required="">-->
<!--                <p class="errors">{{$errors->first('email')}}</p>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <input type="password" class="form-control" placeholder="Password" required="">-->
<!--                <p class="errors">{{$errors->first('password')}}</p>-->
<!--            </div>-->
<!---->
<!--        </form>-->
        {!! Form::open(array('url' => 'user/login')) !!}
        @if(Session::has('error'))
        <div class="alert-box success">
            <h2>{{ Session::get('error') }}</h2>
        </div>
        @endif
        <div class="controls">
            {!! Form::text('email','',array('id'=>'','class'=>'form-control span6','placeholder' => 'Please Enter your Email')) !!}
            <p class="errors">{{$errors->first('email')}}</p>
        </div>
        <div class="controls">
            {!! Form::password('password',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
            <p class="errors">{{$errors->first('password')}}</p>
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
        <a href="#"><small>Forgot password?</small></a>
        {!! Form::close() !!}
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div>
</div>

@endsection



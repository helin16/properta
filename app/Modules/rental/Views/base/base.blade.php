<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properta</title>
    @section('css')
    {!! HTML::style('bower_components\bootstrap\dist\css\bootstrap.css') !!}
    {!! HTML::style('bower_components\font-awesome\css\font-awesome.css') !!}
    {!! HTML::style('bower_components\css\plugins\toastr\font-awesome.css') !!}
            <!-- Toastr style -->
    {!! HTML::style('bower_components\css\plugins\toastr\toastr.min.css') !!}
            <!-- Gritter -->
    {!! HTML::style('bower_components\js\plugins\gritter\jquery.gritter.css') !!}
    {!! HTML::style('bower_components\css\animate.css') !!}
    {!! HTML::style('bower_components\css\style.css') !!}
    @show
</head>
<body>
@include('rental::base.left_nav')
@include('rental::base.top_nav')
<div class="container">
    @section('container')
    @show
</div>
@section('script')
    {!! HTML::script('bower_components\jquery\dist\jquery.js') !!}
    {!! HTML::script('bower_components\bootstrap\dist\js\bootstrap.js') !!}
@show
</body>
@section('style')
@show
</html>
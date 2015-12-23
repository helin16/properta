<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properta</title>
    @section('css')
        {!! HTML::style('bower_components\bootstrap\dist\css\bootstrap.css') !!}
    @show
</head>
<body>
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
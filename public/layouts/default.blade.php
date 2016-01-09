<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="pace-done">
<div id="wrapper">
    @include('includes.leftBar')
    <div class="row  border-bottom white-bg dashboard-header">
        @include('includes.topBar')
        <div id="main" class="row">
            @section('container')
        </div>
    </div>

    <footer class="row">
        @include('includes.footer')
    </footer>
</div>

@section('script')
    {!! HTML::script('bower_components\jquery\dist\jquery.js') !!}
    {!! HTML::script('bower_components\bootstrap\dist\js\bootstrap.js') !!}
@show
</body>
@section('style')
@show
</html>
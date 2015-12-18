<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
    {!! HTML::style('bower_components\bootstrap\dist\css\bootstrap.css') !!}
    {!! HTML::style('bower_components\font-awesome\css\font-awesome.css') !!}
    {!! HTML::style('bower_components\eonasdan-bootstrap-datetimepicker\build\css\bootstrap-datetimepicker.css') !!}
    {!! HTML::script('bower_components\jquery\dist\jquery.js') !!}
    {!! HTML::script('bower_components\bootstrap\dist\js\bootstrap.js') !!}
    {!! HTML::script('bower_components\mustache.js\mustache.js') !!}
    {!! HTML::script('bower_components\moment\moment.js') !!}
    {!! HTML::script('bower_components\accounting\accounting.js') !!}
    {!! HTML::script('bower_components\eonasdan-bootstrap-datetimepicker\src\js\bootstrap-datetimepicker.js') !!}
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <div class="footer">
        @yield('footer')
    </div>
</body>
@yield('script')
@yield('style')
</html>
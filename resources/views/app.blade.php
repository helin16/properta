<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
    {!! HTML::style('bower_components\tether\dist\css\tether.css') !!}
    {!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.css') !!}
    {!! HTML::script('bower_components\tether\dist\js\tether.js') !!}
    {!! HTML::script('bower_components/jquery/dist/jquery.js') !!}
    {!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.js') !!}
    {!! HTML::script('bower_components\font-awesome\css\font-awesome.css') !!}
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <div class="footer">
        @yield('footer')
    </div>
</body>
</html>
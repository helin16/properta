<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @section('css')
        <link rel="stylesheet/less" type="text/css" href="/bower_components/bootstrap/less/bootstrap.less">
        <link rel="stylesheet/less" type="text/css" href="/bower_components/font-awesome/less/font-awesome.less">
        <link media="screen" type="text/css" rel="stylesheet" href="/bower_components/animate.css/animate.min.css">
        <link media="screen" type="text/css" rel="stylesheet" href="/css/style.css">
        <link media="screen" type="text/css" rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    @show
    <script src="/bower_components/less/dist/less.min.js"></script>
</head>
<body>
<div id="wrapper">
    @section('left_side_nav')
        @include('abstracts::base.left_side_nav')
    @show
    <div id="page-wrapper" class="gray-bg" style="min-height: 660px;">
        @section('top_nav')
            @include('abstracts::base.top_nav')
        @show
        @section('page_heading')
            @include('abstracts::base.page_heading')
        @show
        @section('page_body')
        @show
        @section('page_footer')
            @include('abstracts::base.page_footer')
        @show
    </div>
</div>

@section('script')
    {!! HTML::script('bower_components\jquery\dist\jquery.js') !!}
    {!! HTML::script('bower_components\bootstrap\dist\js\bootstrap.js') !!}

    {!! HTML::script('bower_components\metisMenu\dist\metisMenu.js') !!}
    {!! HTML::script('bower_components\jquery-slimscroll\jquery.slimscroll.js') !!}

    {!! HTML::script('Inspinia\Static_Full_Version\js\inspinia.js') !!}
    {!! HTML::script('bower_components\PACE\pace.js') !!}

    {!! HTML::script('bower_components\mustache.js\mustache.js') !!}
    {!! HTML::script('bower_components\moment\moment.js') !!}
    {!! HTML::script('bower_components\accounting\accounting.js') !!}
    {!! HTML::script('bower_components\eonasdan-bootstrap-datetimepicker\src\js\bootstrap-datetimepicker.js') !!}
@show
</body>
@yield('style')
</html>
@section('appName', env('APP_DEFAULT_NAME', ''))
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet/less" type="text/css" href="/bower_components/font-awesome/less/font-awesome.less">
	<link rel="stylesheet/less" type="text/css" href="/bower_components/bootstrap/less/bootstrap.less">
	<link rel="stylesheet/less" type="text/css" href="/css/app.less" />
	<link rel="stylesheet" type="text/css" href="/bower_components/dropzone/dist/basic.css" />
	<link rel="stylesheet" type="text/css" href="/bower_components/dropzone/dist/dropzone.css" />
	<script src="/bower_components/less/dist/less.min.js"></script>
	<title>App Name - @yield('appName')</title>
</head>
<body ng-app="mpApp">
	@section('header')
		@include('layouts.head')
	@show
	@section('body')
		<div class="page-wrapper">
			<ng-view></ng-view>
		</div>
	@show
	<script src="/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/bower_components/angular/angular.min.js"></script>
	<script src="/bower_components/angular-route/angular-route.min.js"></script>
	<script src="/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
	<script src="/bower_components/dropzone/dist/dropzone.js"></script>
	<script src="/js/app.js"></script>
    <script src="/js/directives.js"></script>
    <script src="/js/services.js"></script>
	<script src="/js/controllers.js"></script>
    @section('end-js')
    @show
</body>
</html>
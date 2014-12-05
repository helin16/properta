<!DOCTYPE html>
<html lang="en">
<com:THead ID="titleHeader" Title="<%= $this->getPage()->getAppName() %>">
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="<%= $this->getPage()->getAppName() %>, Online Property Management, Online Property Management Platform">
	<meta name="description" content="<%= $this->getPage()->getAppName() %> is a free Online Proeprty Management Platform, that allows Owners, Agents and Tenants to communicate, share documents and track issues with each other.">
	<!-- Google Fonts -->
	<link href='//fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Lato:400,300,400italic,300italic,700,700italic,900' rel='stylesheet' type='text/css'>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</com:THead>
<body role="document">
	<com:TForm Attributes.id="main-form" Attributes.onSubmit="return false;">
		<com:Application.controls.jQuery.jQuery />
		<header id="header">
			<com:Application.layout.FrontEnd.Header.Header />
		</header>
		<div id="mainbody">
			<com:TContentPlaceHolder ID="MainContent" />
		</div>
		<footer id="footer">
			<com:Application.layout.FrontEnd.Footer.Footer />
		</footer>
	</com:TForm>
</body>
</html>
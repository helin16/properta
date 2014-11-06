<div class="top-head">
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-menu">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">My logo</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right top-menu">
					<li><a href="/">Home</a></li>
					<li><a href="/aboutus.html">About Us</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Why Us</a></li>
					<li><a href="/contactus.html">Contact Us</a></li>
					<li class="dropdown visible-xs visible-md visible-sm visible-lg">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>
<div class="top-bar clearfix">
	<div class="container">
       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       </div><!-- end columns -->
       <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 user-menu-bar">
       	   <com:TPanel ID="user_menu_not_login" CssClass="top-bar-menu pull-right">
       	   		<nav class="navbar navbar-default" role="navigation">
       	   			<ul class="nav navbar-nav">
       	   				<li><a data-toggle="modal" href="/login.html"><i class="fa fa-user"></i> Member Login</a></li>
       	   				<li><a href="/login.html"><i class="fa fa-male"></i> Sign Up</a></li>
       	   			</ul>
       	   		</nav>
           </com:TPanel><!-- end top-bar-menu -->
       	   <com:TPanel ID="user_menu_login" CssClass="top-bar-menu pull-right" Visible='false'>
       	   		<nav class="navbar navbar-default" role="navigation">
       	   			<ul class="nav navbar-nav">
       	   				<li><a>Welcome, <%= Core::getUser()->getFirstName() %></a></li>
       	   				<li><a href="/" title="Settings"><i class="glyphicon glyphicon-cog"></i></a></li>
       	   				<li><a href="/" title="Messages"><i class="glyphicon glyphicon-envelope"></i></a></li>
       	   				<li><a href="/logout.html" title="sign out"><i class="fa fa-sign-out"></i></a></li>
       	   			</ul>
       	   		</nav>
           </com:TPanel><!-- end top-bar-menu -->
       </div><!-- end columns -->
   </div>
</div>
<div class="banner-wrapper">
	
</div>

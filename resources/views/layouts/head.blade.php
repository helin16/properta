<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> 
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/#/group">@yield('appName')</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="/#/group" title="Groups">
						<i class="fa fa-group"></i>
						<span class="hidden-sm hidden-md hidden-lg">Groups</span>
					</a>
				</li>
				<li>
					<a href="#" title="notification">
						<i class="fa fa-bell-o"></i>
						<span class="hidden-sm hidden-md hidden-lg">Notificaton</span>
					</a>
				</li>
				<li>
					<a href="/#/me">
					  <user-avatar ng-model='user'></user-avatar><span class="hidden-sm"> @{{user.firstname}}</span>
					</a>
				</li>
				<li>
					<a href="#" title="logout">
						<i class="fa fa-sign-out"></i>
						<span class="hidden-sm hidden-md hidden-lg">Logout</span>
					</a>
				</li>
			</ul>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search..." ng-model="nameFilter">
			</form>
		</div>
	</div>
</nav>
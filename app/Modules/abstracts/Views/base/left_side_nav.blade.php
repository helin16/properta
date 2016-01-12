<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/Inspinia/Static_Full_Version/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                                    @if(Session::has('currentUserId'))
                                        <strong class="font-bold">
                                            {{ Session::get('currentUserDetails')['firstName'] }}
                                            {{ Session::get('currentUserDetails')['lastName'] }}
                                        </strong>
                                    @endif
                             </span>
                             <span class="text-muted text-xs block">
                                 {{ Session::get('currentUserRole') }}
                                 <b class="caret"></b></span>
                            </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/user/edit-profile">Edit Profile</a></li>
                        <li><a href="/user/edit-password">Change Password</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="/user/logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="/rental">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Rentals</span>
                </a>
                <a href="/message">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Message</span>
                </a>
                <a href="/property">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Property</span>
                </a>
                <a href="/issue">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Issue</span>
                </a>
                <a href="/document">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Document</span>
                </a>
            </li>
        </ul>

    </div>
</nav>
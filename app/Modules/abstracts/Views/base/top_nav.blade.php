<div class="row border-bottom">
    <nav class="navbar" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome to Properta</span>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i>
                    <span class="label label-warning">
                        {!! Helper::getAllMessages()->count() !!}
                    </span>
                </a>
                <!--{{ $data =  Helper::getAllMessages()->get() }}-->
                <ul class="dropdown-menu dropdown-messages">
                    @foreach($data as $message)
                        <li>
                            <div class="dropdown-messages-box">
                                <!--<a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="/Inspinia/Static_Full_Version/img/a7.jpg">
                                </a>-->
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                        <a href="/messages/detail/?id={{ $message->id }}"><strong>{{ $message->subject }}</strong></a><br>
                                    <small class="text-muted">{{ $message->created_at }}</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                    @endforeach
                    <li>
                        <div class="text-center link-block">
                            <a href="/messages">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <!--<li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="profile.html">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="grid_options.html">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="notifications.html">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>-->


            <li>
                <a href="/user/logout">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>
</div>
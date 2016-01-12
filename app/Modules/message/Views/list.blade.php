@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div id="wrapper">
        <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="/message/compose">Compose Mail</a>
                            <div class="space-25"></div>
                            <h5>Folders</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="mailbox.html"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger pull-right">2</span></a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-trash-o"></i> Trash</a></li>
                            </ul>
                            <h5>Categories</h5>
                            <ul class="category-list" style="padding: 0">
                                <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                                <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

                <form method="get" action="/message/listall" class="pull-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                <h2>
                    Inbox ({{ $mails->total() }})
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                    </div>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                </div>
            </div>
                <div class="mail-box">
	                <table class="table table-hover table-mail">
	                <tbody>
	                @foreach($mails->all() as $mail)
	                <tr class="{{$mail->status}}">
	                    <td class="check-mail">
	                        <input type="checkbox" class="i-checks">
	                    </td>
	                    <td class="mail-ontact"><a href="message/detail">{{$mail->name}}</a></td>
	                    <td class="mail-subject"><a href="message/detail">{{$mail->subject}}</a></td>
	                    @if($mail->hasAttached)
	                    <td class=""><i class="fa fa-paperclip"></i></td>
	                    @endif
	                    <td class="text-right mail-date">{{$mail->receiveTime}}</td>
	                </tr>
					@endforeach
	                </tbody>
	                </table>
                </div>
            </div>
        </div>
        </div>


     </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>




@endsection

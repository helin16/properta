@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <button type="submit" class="btn btn-primary" onclick="window.location.href='/messages/create'" style="width: 100%">Create</button>
                </div>
            </div>
            <div class="col-lg-12 animated fadeInRight">
                <div class="mail-box-header">
                    <form method="get" action="index.html" class="pull-right mail-search">
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
                        Inbox ({{ $data->total() }})
                    </h2>
                    <div class="mail-tools tooltip-demo m-t-md">
                        @include('message::message.pagination')
                        {!! Form::open(['method' => 'GET', 'url' => $data->url(1), 'style'=>'display:inline-block']) !!}
                            {!! Form::button(' Refresh', array('type' => 'submit', 'title' => 'Refresh inbox', 'class' => 'btn btn-white btn-sm fa fa-refresh', 'data-toggle' => 'tooltip', 'data-placement' => 'left')) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['method' => 'GET', 'url' => $data->url(1), 'style'=>'display:inline-block']) !!}
                            {!! Form::button(' Delete', array('type' => 'submit', 'title' => 'Delete Selected Message', 'class' => 'btn btn-white btn-sm fa fa-trash-o', 'data-toggle' => 'tooltip', 'data-placement' => 'top')) !!}
                        {!! Form::close() !!}

                    </div>
                </div>
                <div class="mail-box">

                    <table class="table table-hover table-mail">
                        <tbody>
                        @foreach($data->all() as $message)
                            <tr class="read">
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks">
                                </td>
                                <td class="mail-ontact">
                                    <a href="/messages/detail/?id= {{ $message->id }}">
                                        {!! $message->from_user->details->first() ? $message->from_user->details->first()->fullName() : '<i class="text-muted">Anonymous</i>' !!}
                                    </a>
                                </td>
                                <td class="mail-subject">
                                    <a href="/messages/detail/?id= {{ $message->id }}">
                                        {{ $message->subject }}
                                    </a>
                                </td>
                                <td class="">
                                    @if($message->media()->count() > 0)
                                        <i class="fa fa-paperclip"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
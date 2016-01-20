@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="alert-box success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                     <!--{!! Form::open(['route' => 'issue.store', 'files' => true]) !!}-->
                     {!! Form::open(array('url' => 'messages/post-create')) !!}
                        <div class="controls">
                            To User of
                            <div class="col-lg-12"">
                                <select name="to_user_id">
                                    @foreach($data as $person)
                                        <option value="{{ $person->user_id }}">
                                            {{ $person->firstName}}
                                            {{ $person->lastName}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="controls">
                            Subject
                            {!! Form::text('subject','',array('id'=>'','class'=>'form-control span6','placeholder'
                                => 'Please enter your subject of message')) !!}
                            <p class="errors">{{$errors->first('subject')}}</p>
                        </div>
                        <div class="controls">
                            Content

                        </div>
                        <div class="controls">
                            {!! Form::textarea('content', null, ['class' => 'field form-control']) !!}
                            <p class="errors">{{$errors->first('content')}}</p>
                        </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                {!! Form::button('Post', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
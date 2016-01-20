@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="alert-box success">
        <h2>{{ Session::get('success') }}</h2>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="controls">
                    From
                    <div class="ibox-content">
                        {{ $data->subject }}
                    </div>
                </div>
                <div class="controls">
                    Subject
                    <div class="ibox-content">
                       {{ $data->subject }}
                    </div>
                </div>
                <div class="controls">
                    Content
                    <div class="ibox-content">
                        {{ $data->content }}
                        {{ $data->id }}
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                {!! Form::open(array('url' => 'messages/delete')) !!}
                    <div class="form-group">
                        {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                    </div>
                    <input name="id" type="hidden" value="{{ $data->id }}">
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(['route' => 'issue.store', 'files' => true]) !!}
                            @include('issue::issue.form', ['issue' => $issue])
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @include('abstracts::base.errors', ['errors' => $errors])
    </div>
@endsection
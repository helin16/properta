@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(['url' => '/rental', 'files' => true, 'role' => 'form']) !!}
                            <div class="form-group">
                                {!! Form::label('property_id', 'Property') !!}
                                @include('rental::property.select', ['property' => $rental ? $rental->property : null, 'properties' => $properties, 'options' => ['class' => 'form-control']])
                            </div>
                            @include('rental::rental.form', ['rental' => $rental])
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
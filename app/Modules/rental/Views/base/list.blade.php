@extends('rental::base.base')
@section('page_body')
    <div class="wrapper wrapper-content animated fadeIn">
        @section('item-list')
        @show
        @section('pagination')
            @include('rental::base.pagination')
        @show
    </div>
@endsection
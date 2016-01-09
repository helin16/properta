@extends('rental::base.base')
@section('page_body')
    <ul class="list-group">
        @section('item-list')
        @show
    </ul>
    @section('pagination')
        @include('rental::base.pagination')
    @show
@endsection
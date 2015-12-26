@extends('rental::base.base')
@section('container')
    <ul class="list-group">
        @section('item-list')
        @show
    </ul>
    @section('pagination')
        @include('rental::base.pagination')
    @show
@endsection
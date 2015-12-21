@extends('rental::list.base')
@section('content')
    @foreach($items['data'] as $item)
        @include('rental::list.rental', compact('item'))
        <hr/>
    @endforeach
    @include('rental::list.pagination')
@endsection
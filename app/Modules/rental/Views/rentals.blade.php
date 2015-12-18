@extends('rental::base')
@section('content')
    @foreach($items['data'] as $item)
        @include('rental::rental', compact('item'))
        <hr/>
    @endforeach
    @include('rental::pagination')
@endsection
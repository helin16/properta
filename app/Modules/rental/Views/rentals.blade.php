@extends('rental::base')
@section('content')
    @foreach($items as $item)
        @include('rental::rental', compact('item'))
        <hr/>
    @endforeach
@endsection
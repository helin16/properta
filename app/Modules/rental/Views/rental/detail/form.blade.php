@extends('rental::base.base')
@section('content')
    {{--{{ var_dump($item) }}--}}
    {!! Form::open(['url' => ('rental' . ($item ? '.' . $item['id'] : '')), 'method' => ($item ? 'PUT': 'POST')]) !!}
        {!! Form::label('', 'From') !!}
        {!! Form::text('from', $item ? $item['from'] : null) !!}
        {!! Form::label('', 'To') !!}
        {!! Form::text('to', $item ? $item['from'] : null) !!}
    {!! Form::close() !!}
    @if($item)
        <h4>Property</h4>
        <div class="sub-list-item">
            @include('rental::property.list.single', ['item' => $item['property']])
        </div>
        <h4>Media</h4>
        <div class="sub-list-item">
            @include('rental::media.list.multiple', ['items' => $item['media']])
        </div>
    @endif
@endsection
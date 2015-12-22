@extends('rental::base.base')
@section('content')
    {{--{{ var_dump($item) }}--}}
    {!! Form::open(['url' => ('peroperty' . ($item ? '.' . $item['id'] : '')), 'method' => ($item ? 'PUT': 'POST')]) !!}
        {!! Form::label('', 'Description') !!}
        {!! Form::textarea('description', $item ? $item['description'] : null, ['style' => 'width: 100%;']) !!}
    {!! Form::close() !!}
    @if($item)
        <h4>Address</h4>
        <div class="sub-list-item">
            @include('rental::address.list.single', ['item' => $item['address']])
        </div>
    @endif
@endsection
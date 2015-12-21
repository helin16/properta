@extends('rental::list.base')
@section('content')
    <h3>{{ $item['id'] ? 'Editing' : 'Creating' }} Rental</h3>
    @if(isset($item['property']))
        <h4>Property Info</h4>
        <div class="sub-list-item">@include('rental::list.property', ['item' => $item['property']])</div>
    @endif
    <hr/>
    {!! Form::open() !!}
    <div class="container"><div class="row"><div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('dailyAmount', 'Daily Amount') !!}
            {!! Form::text('dailyAmount', $item['dailyAmount'] ?: null, ['class' => 'form-control']) !!}
            {!! Form::label('from', 'From') !!}
            {!! Form::text('from', $item['from'] ?: null, ['class' => 'form-control datetimepicker']) !!}
            {!! Form::label('to', 'To') !!}
            {!! Form::text('to', $item['to'] ?: null, ['class' => 'form-control datetimepicker']) !!}
        </div>
    </div></div></div>
    {!! Form::close() !!}
    <hr/>
    @if(isset($item['media']))
        @foreach($item['media'] as $media)
            @include('rental::list.media', ['item' => $media])
            <hr/>
        @endforeach
    @endif
@endsection
@section('style')
    @parent
    <style>
        [media_id] img {
            max-width: 200px;
        }
        .datetimepicker {
            position: relative;
        }
    </style>
@endsection
@section('script')
    @parent
    <script>
        $( document).ready(function(){
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:MM:SS'
            });
        });
    </script>
@endsection
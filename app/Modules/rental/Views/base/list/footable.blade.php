@extends('rental::base.base.base')
@section('css')
    @parent
    {!! HTML::style('bower_components\footable\css\footable.core.css') !!}
@endsection
@section('script')
    @parent
    {!! HTML::script('bower_components\footable\dist\footable.all.min.js') !!}
    <script>
        $(document).ready(function() {
            $('.footable').footable();
        });
    </script>
@endsection
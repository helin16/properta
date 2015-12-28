@foreach($items as $item)
    @include('rental::media.single', compact('item'))
    <hr/>
@endforeach
@foreach($items as $item)
    @include('rental::media.list.single', compact('item'))
    <hr/>
@endforeach
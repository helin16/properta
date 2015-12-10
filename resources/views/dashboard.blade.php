@extends('app')
@section('content')
    <div class="jumbotron jumbotron-fluid">
        <h1 class="display-3">Project A Dashboard</h1>
        <p class="lead">Welcome {{ Auth::user()->email }}</p>
    </div>
<ul class="nav">
    @foreach($items as $groupName =>$groupItems)
        <h3>{{ $groupName }}</h3>
        @foreach($groupItems as $itemName =>$item)
            <li class="nav-item">
                <a class="nav-link" href="{{$item['url']}}">{{$item['name']}}</a>
            </li>
        @endforeach
    @endforeach
</ul>
@stop
@foreach($data->all() as $detail)
    <div class="row" issue_detail_id="{{ $detail->id }}">
        <div class="col-sm-11">
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('type')], 'body' => ['content' => $detail->type]])
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('priority')], 'body' => ['content' => $detail->priority]])
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('3rd Party')], 'body' => ['content' => $detail['3rdParty']]])
            @include('rental::base.list_row', ['title' => ['content' => ucfirst('content')], 'body' => ['content' => $detail->content]])
            @include('message::media.list', ['media' => $detail->media()->get()->all()])
        </div>
        <div class="col-sm-1">
            {!! Form::open(['method' => 'GET', 'url' => URL::route('issue_detail.show', $detail->id), 'style'=>'display:inline-block']) !!}
            {!! Form::button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
            {!! Form::open(['method' => 'DELETE', 'url' => URL::route('issue_detail.destroy', $detail->id), 'style'=>'display:inline-block']) !!}
            {!! Form::button('Delete', array('type' => 'submit', 'class' => 'btn btn-warning')) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endforeach
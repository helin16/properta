{!! Form::hidden('issue_id', $issue ? $issue->id : null) !!}
{!! Form::hidden('issue_detail_id', $issue_detail ? $issue_detail->id : null) !!}
<h4>{{ $issue->inline() }}</h4>

<div class="form-group">
    {!! Form::label('issue_detail' . '_type', ucfirst('type')) !!}
    {!! Form::text('issue_detail' . '_type', $issue_detail ? $issue_detail->type : '', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('issue_detail' . '_priority', ucfirst('priority')) !!}
    {!! Form::text('issue_detail' . '_priority', $issue_detail ? $issue_detail->priority : '', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('issue_detail' . '_content', ucfirst('content')) !!}
    {!! Form::textarea('issue_detail' . '_content', $issue_detail ? $issue_detail->content : '', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('issue_detail' . '_3rdParty', ucfirst('3rdParty')) !!}
    {!! Form::text('issue_detail' . '_3rdParty', $issue_detail ? $issue_detail['3rdParty'] : '', ['class' => 'form-control']) !!}
</div>
@include('message::media.form', ['media' => $issue_detail ? $issue_detail->media()->get()->all() : [], 'saveItem' => 'issue_detail' . '_'])
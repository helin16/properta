{!! Form::label('rental_id', ucfirst('rental')) !!}
@include('rental::rental.select', ['rental' => $issue ? $issue->rental : null, 'rentals' => $rentals])
{!! Form::label('issue_status', ucfirst('status')) !!}
{!! Form::text('issue_status', $issue ? $issue->status : '', ['class' => 'form-control']) !!}
{!! Form::label('user_id', ucfirst('requester')) !!}
@include('user::user.select', ['user' => $issue ? $issue->requester : null, 'users' => $users])
@foreach($issue ? $issue->details->all() : [null] as $detail)
    <hr/>
    {!! Form::label('user_detail_' . ($detail ? $detail->id : '') . '_type', ucfirst('type')) !!}
    {!! Form::text('user_detail_' . ($detail ? $detail->id : '') . '_type', $detail ? $detail->type : '', ['class' => 'form-control']) !!}
    {!! Form::label('user_detail_' . ($detail ? $detail->id : '') . '_priority', ucfirst('priority')) !!}
    {!! Form::text('user_detail_' . ($detail ? $detail->id : '') . '_priority', $detail ? $detail->priority : '', ['class' => 'form-control']) !!}
    {!! Form::label('user_detail_' . ($detail ? $detail->id : '') . '_content', ucfirst('content')) !!}
    {!! Form::textarea('user_detail_' . ($detail ? $detail->id : '') . '_content', $detail ? $detail->content : '', ['class' => 'form-control']) !!}
    {!! Form::label('user_detail_' . ($detail ? $detail->id : '') . '_3rdParty', ucfirst('3rdParty')) !!}
    {!! Form::text('user_detail_' . ($detail ? $detail->id : '') . '_3rdParty', $detail ? $detail['3rdParty'] : '', ['class' => 'form-control']) !!}
    @include('message::media.form', ['media' => $detail ? $detail->media()->get()->all() : [], 'saveItem' => $detail ? ('user_detail_' . $detail->id) : ''])
@endforeach
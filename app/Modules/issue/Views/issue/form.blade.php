{!! Form::hidden('issue_id', $issue ? $issue->id : null) !!}
<div class="form-group">
    {!! Form::label('rental_id', ucfirst('rental')) !!}
    @include('rental::rental.select', ['rental' => $issue ? $issue->rental->first() : null, 'rentals' => $rentals])
</div>
<div class="form-group">
    {!! Form::label('issue_status', ucfirst('status')) !!}
    {!! Form::text('issue_status', $issue ? $issue->status : '', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('user_id', ucfirst('requester')) !!}
    @include('user::user.select', ['user' => $issue ? $issue->requester : null, 'users' => $users, 'saveItem' => 'requester_'])
</div>
{!! Form::hidden('rental_id', $rental['id']) !!}
<div class="form-group">
    {!! Form::label('rental_dailyAmount', 'Daily Amount') !!}
    {!! Form::text('rental_dailyAmount', $rental ? $rental['dailyAmount'] : '', ['class' => 'form-control']) !!}
    {!! Form::label('rental_from', 'From') !!}
    {!! Form::text('rental_from', $rental ? $rental['from'] : '', ['class' => 'form-control']) !!}
    {!! Form::label('rental_to', 'To') !!}
    {!! Form::text('rental_to', $rental ? $rental['to'] : '', ['class' => 'form-control']) !!}
</div>
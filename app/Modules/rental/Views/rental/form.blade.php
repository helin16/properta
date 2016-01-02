<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>
{!! Form::hidden('rental_id', $rental ? $rental->id : 0) !!}
<div class="form-group">
    {!! Form::label('rental_dailyAmount', 'Daily Amount') !!}
    {!! Form::text('rental_dailyAmount', $rental ? money_format('%.2n',$rental->dailyAmount) : '', ['class' => 'form-control']) !!}
    {!! Form::label('rental_from', 'From') !!}
    {!! Form::input('datetime-local', 'rental_from', ($rental && $rental->from) ? $rental->from->format('Y-m-d\\Th:m') : '', ['class' => 'form-control']) !!}
    {!! Form::label('rental_to', 'To') !!}
    {!! Form::input('datetime-local', 'rental_to', ($rental && $rental->to) ? $rental->to->format('Y-m-d\\Th:m') : '', ['class' => 'form-control']) !!}
    @include('message::media.form', ['media' => $rental ? $rental->media()->get()->all() : []])
</div>
<div class="form-group">
    {!! Form::label('status', 'Status: ') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
</div>
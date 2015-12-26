{!! Form::hidden('property_id', $property ? $property->id : 0) !!}
<div class="form-group">
    {!! Form::label('property_description', 'Description') !!}
    {!! Form::textarea('property_description', $property ? $property->description : '', ['class' => 'form-control']) !!}
</div>
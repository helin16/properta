{!! Form::hidden('property_id', $property ? $property->id : 0) !!}
{!! Form::hidden('property_detail_id', ($property && $property->details->first()) ? $property->details->first()->id : 0) !!}
<div class="form-group">
    {!! Form::label('property_description', ucfirst('description')) !!}
    {!! Form::textarea('property_description', $property ? $property->description : '', ['class' => 'form-control']) !!}
    {!! Form::label('property_details_type', ucfirst('type')) !!}
    {!! Form::text('property_details_type', ($property && $property->details->first()) ? $property->details->first()->type : '', ['class' => 'form-control']) !!}
    {!! Form::label('property_details_carParks', ucfirst('car Parks')) !!}
    {!! Form::input('number', 'property_details_carParks', ($property && $property->details->first()) ? $property->details->first()->carParks : '', ['class' => 'form-control']) !!}
    {!! Form::label('property_details_bedrooms', ucfirst('bedrooms')) !!}
    {!! Form::input('number', 'property_details_bedrooms', ($property && $property->details->first()) ? $property->details->first()->bedrooms : '', ['class' => 'form-control']) !!}
    {!! Form::label('property_details_bathrooms', ucfirst('bathrooms')) !!}
    {!! Form::input('number', 'property_details_bathrooms', ($property && $property->details->first()) ? $property->details->first()->bathrooms : '', ['class' => 'form-control']) !!}
    @if($property && $property->details->first())
        @foreach(json_decode($property->details->first()->options, true) as $option)
            {!! Form::label('property_details_option_' . key($option), ucfirst(key($option))) !!}
            {!! Form::text('property_details_option_' . key($option), $option[key($option)], ['class' => 'form-control']) !!}
        @endforeach
    @endif
</div>
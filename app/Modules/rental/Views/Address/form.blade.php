<div class="form-group">
    {!! Form::hidden('address_id', $address ? $address->id : 0) !!}
    <div class="form-group">
        {!! Form::label('address_street', 'Street') !!}
        {!! Form::text('address_street', $address ? $address->street : '', ['class' => 'form-control googleMap']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('address_suburb', 'Suburb') !!}
        {!! Form::text('address_suburb', $address ? $address->suburb : '', ['class' => 'form-control googleMap']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('address_state', 'State') !!}
        {!! Form::text('address_state', $address ? $address->state : '', ['class' => 'form-control googleMap']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('address_country', 'Country') !!}
        {!! Form::text('address_country', $address ? $address->country : '', ['class' => 'form-control googleMap']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('address_postcode', 'Postcode') !!}
        {!! Form::text('address_postcode', $address ? $address->postcode : '', ['class' => 'form-control googleMap']) !!}
    </div>
</div>
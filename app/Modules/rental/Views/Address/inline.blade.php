@if($address)
    <span address_id={{ $address['id'] }}>
        <span class="street">{{ $address['street'] }}</span>
        <span class="suburb">{{ $address['suburb'] }}</span>
        <span class="state">{{ $address['state'] }}</span>
        <span class="country">{{ $address['country'] }}</span>
        <span class="postcode">{{ $address['postcode'] }}</span>
    </span>
@endif
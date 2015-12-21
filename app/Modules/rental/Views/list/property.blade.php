<div property_id={{ $item['id'] }}>
    <li><strong>description</strong></li>
    <li>{{ $item['description'] }}</li>
    <li><strong>Address</strong></li>
    <div class="sub-list-item">@include('rental::list.address', ['item'=>$item['address']])</div>
</div>
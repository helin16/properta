<div property_id={{ $item['id'] }}>
    <a class="btn btn-info btn-sm edit-btn" href={{ '/property/' . $item['id'] }}>Edit</a>
    <li><strong>description</strong></li>
    <li>{{ $item['description'] }}</li>
    <li><strong>Address</strong></li>
    <div class="sub-list-item">@include('rental::address.list.single', ['item'=>$item['address']])</div>
</div>
<div rental_id={{ $item['id'] }}>
    <a class="btn btn-info btn-sm edit-btn" href={{ '/rental/' . $item['id'] }}>Edit</a>
    <li><strong>Daily Amount</strong></li>
    <li>{{ $item['dailyAmount'] }}</li>
    <li><strong>From</strong></li>
    <li renderdate="{{ $item['from'] }}"></li>
    <li><strong>To</strong></li>
    <li renderdate="{{ $item['to'] }}"></li>
    <li><strong>Property</strong></li>
    <div class="sub-list-item">@include('rental::property.list.single', ['item'=>$item['property']])</div>
    <li><strong>Media</strong></li>
    <div class="sub-list-item">@include('rental::media.list.multiple', ['items'=>$item['media']])</div>
</div>

<script>
    $( document ).ready(function() {
        $('[renderdate]').html(moment.utc(this.renderdate).local().format('LLLL'));
    });
</script>
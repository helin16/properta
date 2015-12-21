<div rental_id={{ $item['id'] }}>
    <li><strong>Daily Amount</strong></li>
    <li>{{ $item['dailyAmount'] }}</li>
    <li><strong>From</strong></li>
    <li renderdate="{{ $item['from'] }}"></li>
    <li><strong>To</strong></li>
    <li renderdate="{{ $item['to'] }}"></li>
    <li><strong>Property</strong></li>
    <div class="sub-list-item">@include('rental::list.property', ['item'=>$item['property']])</div>
    <li><strong>Media</strong></li>
    @foreach($item['media'] as $media)
        <div class="sub-list-item">@include('rental::list.media', ['item'=>$media])</div>
    @endforeach
</div>

<script>
    $( document ).ready(function() {
    $('[renderdate]').html(moment.utc(this.renderdate).local().format('LLLL'));
    });
</script>
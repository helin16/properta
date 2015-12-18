<div media_id={{ $item['id'] }}>
    <li><strong>MIME Type</strong></li>
    <li>{{ $item['mimeType'] }}</li>
    <li><strong>Name</strong></li>
    <li>{{ $item['name'] }}</li>
    <li><strong>Path</strong></li>
    <li>{{ $item['path'] }}
    </li>
    <li><strong>Data</strong></li>
    <li><img src="{{ 'data:' . $item['mimeType'] . ';base64,' . $item['data'] }}"></li>
</div>
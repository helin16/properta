@extends('abstracts::base.2_columns_left_nav_bar')
@section('page_body')
    <div class="wrapper wrapper-content"> {{--summernote doesn't play well with animate.css--}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::open(array('route' => 'property.store')) !!}
                            @include('rental::property.form', ['property' => $property])
                            @include('rental::address.form', ['address' => $property ? $property->address : null])
                            @foreach($property ? $property->logs->all() : [] as $log)
                                <hr/>
                                {!! Form::label('property_logs', ucfirst((trim($log->type) === '' ? '' : ($log->type . ' ')) . 'Log')) !!}
                                @include('rental::base.list_row', ['body' => ['content' => $log->content]])
                                @if(sizeof(json_decode($log->comments)) > 0)
                                    <div class="col-xs-12">&nbsp;</div>
                                @endif
                                @foreach(json_decode($log->comments) as $comments)
                                    @include('rental::base.list_row', ['title' => ['content' => ucfirst('comments')], 'body' => ['content' => $comments]])
                                @endforeach
                            @endforeach
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                {!! Form::button('Save', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    @parent
    <link rel="stylesheet/less" type="text/css" href="/bower_components/summernote/src/less/summernote.less">
    <link rel="stylesheet" href="/bower_components/summernote/dist/summernote-bs3.css">
@endsection
@section('script')
    @parent
    <script src="/bower_components/summernote/dist/summernote.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
        $(document).ready(function(){
            // summer note
            $('.summernote[name="property_description"]').summernote({
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true,                  // set focus to editable area after initializing summe
            })
            .on('summernote.change', function(we, contents, $editable) {
                $('.summernote[name="property_description"]').val(contents);
            });;
        });
            // google map
            var google_map_elements = {
                'street': $('.googleMap[name="address_street"]'),
                'suburb': $('.googleMap[name="address_suburb"]'),
                'state': $('.googleMap[name="address_state"]'),
                'country': $('.googleMap[name="address_country"]'),
                'postcode': $('.googleMap[name="address_postcode"]'),
            };
            var placeSearch, autocomplete;
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };
            function initAutocomplete() {
                autocomplete = new google.maps.places.Autocomplete((google_map_elements['street'][0]), {types: ['geocode']});
                autocomplete.addListener('place_changed', fillInAddress);
            }
            function fillInAddress() {
                var place = autocomplete.getPlace();
                var address_components = {}; // reform the address components
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    var val = place.address_components[i][componentForm[addressType]];
                    address_components[addressType] = val;
                }
                google_map_elements['street'].val(address_components['street_number'] + ' ' + address_components['route']);
                google_map_elements['suburb'].val(address_components['locality']);
                google_map_elements['state'].val(address_components['administrative_area_level_1']);
                google_map_elements['country'].val(address_components['country']);
                google_map_elements['postcode'].val(address_components['postal_code']);
            }
    </script>
@endsection
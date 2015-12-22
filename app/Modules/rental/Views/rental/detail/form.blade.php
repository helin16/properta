@extends('rental::base.base.base')
@section('css')
    @parent
    {!! HTML::style('bower_components\iCheck\skins\square\green.css') !!}
    {!! HTML::style('bower_components\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css') !!}
    {!! HTML::style('bower_components\summernote\dist\summernote.css') !!}
    {!! HTML::style('bower_components\summernote\dist\summernote-bs3.css') !!}
    {!! HTML::style('bower_components\blueimp-gallery\css\blueimp-gallery.css') !!}
@endsection
{{--{{ var_dump($item) }}--}}
@section('page_body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70"></script>
        <div class="row">
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Rental Details</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal">
                            <div class="form-group"><label class="col-lg-2 control-label">Daily Amount</label>
                                <div class="col-lg-10">
                                    <div class="input-group m-b">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control" autocomplete="off">
                                    </div>
                                    <span class="help-block m-b-none">The daily rental cost.</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">From</label>
                                <div class="col-lg-10">
                                    <div class="input-group datetimepicker date m-b">
                                        <input type="text" class="form-control" value="{{ $item['from'] }}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <span class="help-block m-b-none">The date when rental began</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">To</label>
                                <div class="col-lg-10">
                                    <div class="input-group datetimepicker date m-b">
                                        <input type="text" class="form-control" value="{{ $item['to'] }}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <span class="help-block m-b-none">The date when rental end (optional)</span>
                                </div>
                            </div>
                            <br/>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Property Description</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content no-padding">
                        <div class="summernote">
                            {{ $item['property']['description'] }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Address</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12 b-r">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <br/>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <div class="google-map" id="map1"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="google-map" id="map3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <h2>Media gallery</h2>
                        <div class="lightBoxGallery">
                            @foreach($item['media'] as $media)
                                <a href="{{ "/media/" . basename($media['path']) }}" title="{{ $media['name'] }}">
                                    <img src="{{ 'data:' . $media['mimeType'] . ';base64,' . $media['data'] }}" alt="{{ $media['name'] }}">
                                </a>
                            @endforeach
                            <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery" style="display: none;">
                                <div class="slides" style="width: 138240px;"></div>
                                <h3 class="title">Image from Unsplash</h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    @parent
    {!! HTML::script('bower_components\iCheck\icheck.js') !!}
    {!! HTML::script('bower_components\summernote\dist\summernote.js') !!}
    {!! HTML::script('bower_components\blueimp-gallery\js\blueimp-gallery.js') !!}
    <script>
        // iCheck
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        // summernote
        $(document).ready(function(){
            $('.summernote').summernote();
        });
        var edit = function() {
            $('.click2edit').summernote({focus: true});
        };
        var save = function() {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };
        // datetimepicker
        $('.datetimepicker').each(function(){
            if($(this).children('input').val() !== '') {
                $(this).children('input').val(moment.utc($(this).children('input').val()).local().format('DD-MMM-YYYY HH:MM:SS'));
            }
           $(this).datetimepicker({
               format: 'DD-MMM-YYYY HH:MM:SS'
           });
        });
        // Google Maps
        var mapOptions1 = {
            zoom: 11,
            center: new google.maps.LatLng(40.6700, -73.9400),
            // Style for Google Maps
            styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]
        };

        var mapOptions3 = {
            center: new google.maps.LatLng(36.964645, -122.01523),
            zoom: 18,
            mapTypeId: google.maps.MapTypeId.SATELLITE,
            // Style for Google Maps
            styles: [{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#fffffa"}]},{"featureType":"water","stylers":[{"lightness":50}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"lightness":40}]}]
        };

        var mapElement1 = document.getElementById('map1');
        var mapElement3 = document.getElementById('map3');

        var map1 = new google.maps.Map(mapElement1, mapOptions1);
        var map3 = new google.maps.Map(mapElement3, mapOptions3);
        // blueimp-gallery
        $( ".lightBoxGallery" ).on( "click", function( event ) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                    link = target.src ? target.parentNode : target,
                    options = {index: link, event: event},
                    links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        });
    </script>
@endsection

@section('style')
    @parent
    <style>
        .lightBoxGallery {
            text-align: center;
        }

        .lightBoxGallery img {
            margin: 5px;
        }
    </style>
@endsection
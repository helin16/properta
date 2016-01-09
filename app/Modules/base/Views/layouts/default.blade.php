<?php setlocale(LC_MONETARY, 'en_AU.UTF-8') ?>

<html>

<head>
    @include('base::includes.head')
</head>

<body>
<div id="wrapper">
    @include('base::includes.leftBar')

    <div id="page-wrapper" class="gray-bg dashbard-1">
        @include('base::includes.topBar')
        <div class="row  border-bottom white-bg dashboard-header">
            @yield('container')
        </div>
        @include('base::includes.footer')
    </div>
</div>

@section('script')
        <!-- Mainly scripts -->
{!! HTML::script('bower_components/js/jquery-2.1.1.js') !!}
{!! HTML::script('bower_components/js/bootstrap.min.js') !!}
{!! HTML::script('bower_components/js/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! HTML::script('bower_components/js/plugins/slimscroll/jquery.slimscroll.min.js') !!}

        <!-- Flot -->
{!! HTML::script('bower_components/js/plugins/flot/jquery.flot.js') !!}
{!! HTML::script('bower_components/js/plugins/flot/jquery.flot.tooltip.min.js') !!}
{!! HTML::script('bower_components/js/plugins/flot/jquery.flot.spline.js') !!}
{!! HTML::script('bower_components/js/plugins/flot/jquery.flot.resize.js') !!}
{!! HTML::script('bower_components/js/plugins/flot/jquery.flot.pie.js') !!}

        <!-- Peity -->
{!! HTML::script('bower_components/js/plugins/peity/jquery.peity.min.js') !!}
{!! HTML::script('bower_components/js/demo/peity-demo.js') !!}

        <!-- Custom and plugin javascript -->
{!! HTML::script('bower_components/js/inspinia.js') !!}
{!! HTML::script('bower_components/js/plugins/pace/pace.min.js') !!}

        <!-- jQuery UI -->
{!! HTML::script('bower_components/js/plugins/jquery-ui/jquery-ui.min.js') !!}

        <!-- GITTER -->
{!! HTML::script('bower_components/js/plugins/gritter/jquery.gritter.min.js') !!}

        <!-- Sparkline -->
{!! HTML::script('bower_components/js/plugins/sparkline/jquery.sparkline.min.js') !!}

        <!-- Sparkline demo data  -->
{!! HTML::script('bower_components/js/demo/sparkline-demo.js') !!}

        <!-- ChartJS-->
{!! HTML::script('bower_components/js/plugins/chartJs/Chart.min.js') !!}

        <!-- Toastr -->
{!! HTML::script('bower_components/js/plugins/toastr/toastr.min.js') !!}

{{--<!-- Mainly scripts -->

<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

        }, 1300);


        var data1 = [
            [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
        ];
        var data2 = [
            [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
        ];
        $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                    data1, data2
                ],
                {
                    series: {
                        lines: {
                            show: false,
                            fill: true
                        },
                        splines: {
                            show: true,
                            tension: 0.4,
                            lineWidth: 1,
                            fill: 0.4
                        },
                        points: {
                            radius: 0,
                            show: true
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#d5d5d5",
                        borderWidth: 1,
                        color: '#d5d5d5'
                    },
                    colors: ["#1ab394", "#1C84C6"],
                    xaxis:{
                    },
                    yaxis: {
                        ticks: 4
                    },
                    tooltip: false
                }
        );

        var doughnutData = [
            {
                value: 300,
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "App"
            },
            {
                value: 50,
                color: "#dedede",
                highlight: "#1ab394",
                label: "Software"
            },
            {
                value: 100,
                color: "#A4CEE8",
                highlight: "#1ab394",
                label: "Laptop"
            }
        ];

        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 45, // This is 0 for Pie charts
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false
        };

        var ctx = document.getElementById("doughnutChart").getContext("2d");
        var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);

        var polarData = [
            {
                value: 300,
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "App"
            },
            {
                value: 140,
                color: "#dedede",
                highlight: "#1ab394",
                label: "Software"
            },
            {
                value: 200,
                color: "#A4CEE8",
                highlight: "#1ab394",
                label: "Laptop"
            }
        ];

        var polarOptions = {
            scaleShowLabelBackdrop: true,
            scaleBackdropColor: "rgba(255,255,255,0.75)",
            scaleBeginAtZero: true,
            scaleBackdropPaddingY: 1,
            scaleBackdropPaddingX: 1,
            scaleShowLine: true,
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false
        };
        var ctx = document.getElementById("polarChart").getContext("2d");
        var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);

    });
</script>--}}
</body>
</html>

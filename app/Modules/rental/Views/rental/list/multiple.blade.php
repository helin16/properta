@extends('rental::base.list.footable')
{{--@foreach($items['data'] as $item)--}}
{{--{{ var_dump($items) }}--}}
{{--<hr/>--}}
{{--@endforeach--}}

@section('page_body')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>FooTable with row toggler, sorting and pagination</h5>

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

                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                            <thead>
                            <tr>
                                <th data-toggle="true">Address</th>
                                <th class="hidden-xs" data-toggle="true">Suburb</th>
                                <th class="hidden-xs" data-toggle="true">Postcode</th>
                                <th>Daily Amount</th>
                                <th >From</th>
                                <th class="hidden-xs">To</th>
                                <th data-hide="all">Address</th>
                                <th data-hide="all">Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['property']['address']['street'] }}</td>
                                    <td class="hidden-xs">{{ $item['property']['address']['suburb'] }}</td>
                                    <td class="hidden-xs">{{ $item['property']['address']['postcode'] }}</td>
                                    <td>{{ $item['dailyAmount'] }}</td>
                                    <td render_utc_datetime="{{ $item['from'] }}"></td>
                                    <td class="hidden-xs" render_utc_datetime="{{ $item['to'] }}"></td>
                                    <td>@include('rental::address.list.inline', ['item' => $item['property']['address']])</td>
                                    <td>{{ $item['property']['description'] }}</td>
                                    <td><a href="{{ '/rental/' . $item['id'] }}"><i class="fa fa-pencil-square-o"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script>
        $('[render_utc_datetime]').each(function(){
            if($(this).attr('render_utc_datetime') !== '')
                $(this).html(moment.utc($(this).attr('render_utc_datetime')).local().format('D MMM YYYY'));
        });
    </script>
@endsection
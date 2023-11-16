@extends('front.layouts.Dispatch-layout')

@section('page-title',"Dashboard")

@section('css')
    <style>
        .message-notes {
            text-align: left;
        }

        rect {
            fill: transparent !important;
        }
    </style>

@stop

@section('content')
    <main id="main" class="page-dashbaord" data-page="summary">
        <div class="pg-container container-fluid">
        @include('front.partials.errors')
        <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <section class="section">
                    <div class="container-fluid">

                        <div class="hgroup ml-0">
                            <h1 class="lh-10 main-head divider-after left">Dashboard</h1>
                        </div>
                        <!--Cards-Div-Open-->
                        <div class="summary-hightlights">
                            <div class="row align-items-center">
                                <div class="container-fluid">
                                    <div class="row">
{{--                                        @if(can_view_cards('order_graph',$dashbord_cards_rights))--}}
{{--                                            <div class="col-lg-6 col-md-12 col-12 custom_col">--}}
{{--                                                <div id="piechart" class=""--}}
{{--                                                     style="width: 900px; height: 500px;"></div>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                        @if(can_view_cards('vendor_graph',$dashbord_cards_rights))--}}
{{--                                            <div class="col-lg-6 col-md-12 col-12">--}}
{{--                                                <div class="panel panel-default custm_graph">--}}
{{--                                                    <div class="panel-body">--}}
{{--                                                        <canvas id="canvas" height="280" width="600"></canvas>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
                                        <h2>Coming Soon......</h2>
                                    </div>
                                </div>
{{--                                @if($dashbord_cards_rights == '')--}}
{{--                                    <div class="attr-wrap col-6 col-sm-4 col-md-12">--}}
{{--                                        <div class="attr link-wrap">--}}
{{--                                            <h5 class="nomargin bf-color">No Dashboard Rights Off This User.</h5>--}}
{{--                                            <div class="h2 nomargin"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}


                            </div>
                        </div>
                        <!--Cards-Div-Close-->
                        {{--                        <div class="row">--}}


                        <div class="row">
{{--                            @if(can_view_cards('joeys_list',$dashbord_cards_rights))--}}
{{--                                <div class="col-12 col-md-6 mt-4">--}}
{{--                                    <div class="box">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <h4 class="card-title">Joeys On Duty</h4>--}}
{{--                                            <table--}}
{{--                                                class="table table-striped mb_last_row_hightlight mb_last_row_center dash_respons">--}}
{{--                                                <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th width="5%" scope="col">Joey #</th>--}}
{{--                                                    <th width="10%" scope="col">Name</th>--}}
{{--                                                    <th width="20%" scope="col">Email</th>--}}
{{--                                                    <th width="15%" scope="col">Phone</th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @forelse($joeys as $joey)--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="valing-middle"><span--}}
{{--                                                                class="bold basecolor1">{{$joey->id}}</span></td>--}}
{{--                                                        <td class="valing-middle">{{$joey->full_name}}</td>--}}
{{--                                                        <td class="valing-middle">{{$joey->email}}</td>--}}
{{--                                                        <td class="valing-middle">{{$joey->phone}}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @empty--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                        <td class="message-notes">No data available</td>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforelse--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if(can_view_cards('vendor_list',$dashbord_cards_rights))--}}
{{--                                <div class="col-12 col-md-6 mt-4">--}}
{{--                                    <div class="box">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <h4 class="card-title">Vendors</h4>--}}
{{--                                            <table--}}
{{--                                                class="table table-striped mb_last_row_hightlight mb_last_row_center dash_respons">--}}
{{--                                                <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th width="5%" scope="col">Ref no#</th>--}}
{{--                                                    <th width="10%" scope="col">Name</th>--}}
{{--                                                    <th width="20%" scope="col">Email</th>--}}
{{--                                                    <th width="15%" scope="col">Phone</th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @forelse($vendors as $vendor)--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="valing-middle"><span--}}
{{--                                                                class="bold basecolor1">{{$vendor->id}}</span></td>--}}
{{--                                                        <td class="valing-middle">{{$vendor->full_name}}</td>--}}
{{--                                                        <td class="valing-middle">{{$vendor->email}}</td>--}}
{{--                                                        <td class="valing-middle">{{$vendor->phone}}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @empty--}}
{{--                                                    <tr>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                        <td class="message-notes">No data available</td>--}}
{{--                                                        <td class="message-notes"></td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforelse--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if(can_view_cards('recent_e_commerce_list',$dashbord_cards_rights))--}}

{{--                            @endif--}}

{{--                            @if(can_view_cards('recent_grocery_list',$dashbord_cards_rights))--}}

{{--                            @endif--}}
                        </div>

                        {{--                        </div>--}}
                    </div>
                </section>
            </div>
            <!-- Content Area - [/end] -->
        </div>

    </main>
@stop

@section('js')
{{--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
{{--    <script type="text/javascript">--}}
{{--        google.charts.load('current', {'packages': ['corechart']});--}}
{{--        google.charts.setOnLoadCallback(drawChart);--}}

{{--        function drawChart() {--}}
{{--            var data = google.visualization.arrayToDataTable([--}}
{{--                ['Product Name', 'Sales', 'Quantity'],--}}
{{--                @php--}}
{{--                    echo "['E-Comm Order', $ecommerceOrdersCount, $ecommerceOrdersCount],";--}}
{{--                    echo "['Grocery Order', $groceryOrdersCount, $groceryOrdersCount],";--}}
{{--                @endphp--}}
{{--            ]);--}}
{{--            var options = {--}}
{{--                title: 'Order Details',--}}
{{--                is3D: false,--}}
{{--            };--}}
{{--            var chart = new google.visualization.PieChart(document.getElementById('piechart'));--}}
{{--            chart.draw(data, options);--}}
{{--        }--}}
{{--    </script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>--}}
{{--    <script>--}}
{{--        var year = <?php echo $year; ?>;--}}
{{--        var user = <?php echo $user; ?>;--}}
{{--        var barChartData = {--}}
{{--            labels: year,--}}
{{--            datasets: [{--}}
{{--                label: 'Vendors',--}}
{{--                backgroundColor: '#e46d29',--}}
{{--                data: user--}}
{{--            }]--}}
{{--        };--}}

{{--        window.onload = function () {--}}
{{--            var ctx = document.getElementById("canvas").getContext("2d");--}}
{{--            window.myBar = new Chart(ctx, {--}}
{{--                type: 'bar',--}}
{{--                data: barChartData,--}}
{{--                options: {--}}
{{--                    elements: {--}}
{{--                        rectangle: {--}}
{{--                            borderWidth: 2,--}}
{{--                            borderColor: '#c1c1c1',--}}
{{--                            borderSkipped: 'bottom'--}}
{{--                        }--}}
{{--                    },--}}
{{--                    responsive: true,--}}
{{--                    title: {--}}
{{--                        display: true,--}}
{{--                        text: 'Yearly Vendor Joined'--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        };--}}
{{--    </script>--}}
@stop

@extends('front.layouts.Dispatch-layout')

@section('page-title',"Dispatch Orders")

@section('css')
    <style>
        /*my css*/
        .pagination {
            margin-top: 30px;
        }

        .pagination li.disabled {
            opacity: 0.5;
        }

        .pagination li a {
            text-decoration: none;
            color: #443404;
        }

        .pagination li.active .page-link {
            background: #e46d29 !important;
            color: #ffffff !important;
            border: none;
        }

        .pagination {
        }
        .tab_link.active a {
            color: #e46d29 !important;
            text-decoration: none !important;
        }
    </style>
    <style>
        /* CSS for overlay */
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        /* CSS for loading spinner */
        #loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
@stop

@section('content')
    <div id="loading-overlay">
        <div id="loading-spinner">
            <i class="fa fa-spinner fa-spin"></i>
            <div class="loader"></div>
        </div>
    </div>

    <main id="main" class="page-dispatch" data-page="dispatch">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                    <aside id="left_sidebar" class="col-12 col-lg-2">
                        <div class="inner">
                            <div class="widget_sidebar widget_filter">
                                <h5 class="widgetTitle"><i class="icofont-box"></i> Order Types</h5>
                                <div class="order_types widgetInfo">
                                    <ul class="no-list">
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(115)" class="table-reload-menu">Stuck
                                                <span class="count">({{ $stuck }})</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(13)" class="table-reload-menu">New
                                                <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(18)" class="table-reload-menu">Edit
                                                <span class="count">(0)</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(32)" class="table-reload-menu">Active
                                                <span class="count">({{ $active }})</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(113)" class="table-reload-menu">Completed
                                                <span class="count">({{ $completed }})</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(35)" class="table-reload-menu">Rejected
                                                <span class="count">({{ $rejected }})</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(101)" class="table-reload-menu">Return
                                                <span class="count">({{ $returned }})</span>
                                            </a>
                                        </li>
                                        <li class="tab_link">
                                            <a href="#" onclick="orderType(61)" class="table-reload-menu">Scheduled
                                                <span class="count">({{ $scheduled }})</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="widget_sidebar widget_filter">
                                <h5 class="widgetTitle"><i class="icofont-user-alt-5"></i> Filter Results</h5>
                                <div class="widgetInfo">
                                    <form action="" id="filter-summary" class="needs-validation" novalidate>

                                        <div class="form-group no-min-h">
                                            <label for="endDate">Select status</label>
                                            <select name="statusId" id="statusId"
                                                    class="select2 form-control-lg statusId dispatch-table-reload">
                                                <option value="" selected>Select Status</option>
                                                @foreach(getStatusCodesWithKey('status_labels') as $key => $value)
                                                    <option value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="divider sm"></div>
                                        <div class="form-group no-min-h">
                                            <label for="zone">Filter by zones</label>
                                            <select id="zone" name="zone[]" multiple="multiple"
                                                    data-placeholder="Select Zone"
                                                    class="select2 form-control-lg">
                                                @foreach($zones as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="divider sm"></div>
                                        <div class="form-group">
                                            <label for="vendor">Filter by Vendor</label>
                                            <select id="vendor" name="vendor[]" multiple="multiple"
                                                    data-placeholder="Select Vendor"
                                                    class="select2 form-control form-control-lg">
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="btn-group nomargin align-right">
                                            <button type="button" onclick="filter()"
                                                    class="btn btn-primary btn-xs submitButton mb-fluid">Filter Results
                                            </button>
                                        </div>
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <aside id="right_content" class="col-12 col-lg-10">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="row">
                                    <div class="col-md-7 col-12">
                                        <div class="hgroup divider-after left">
                                            <h1 class="lh-10">Dispatch Orders</h1>
                                        </div>
                                    </div>

                                    <div class="col-md-5 col-12 align-right">
                                        <a href="{{route('Dispatch-map')}}"
                                           class="btn btn-white btn-sm mb-fluid mb-align-center">Switch to Map View</a>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($omsCategory as $category)
                                        <button type="button" class="btn btn-sm btn-success mr-3 table-reload-menu" onclick="orderCategory({{ $category->id }})">{{ $category->name }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <section class="section-content summary-section no-border">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-12 col-sm-8">
                                                <div class="needs-validation grid_sort_controls" novalidate>
                                                    <div class="form-row">
                                                        <input type="hidden" name="orderType" id="orderType">
                                                        <input type="hidden" name="categoryId" id="categoryId">
                                                        <input type="hidden" name="order_status" id="order_status">
                                                        <input type="hidden" name="order_zones" id="order_zones">
                                                        <input type="hidden" name="order_vendors" id="order_vendors">
                                                        <div class="form-group no-min-h col-12 col-sm-12">
                                                            <label for="email">Search by</label>
                                                            <div class="row no-gutter merge-fields or-separator">
                                                                <div class="col-6">
                                                                    <div class="form-group no-min-h">
                                                                        <input type="text" name="orderId" id="orderId"
                                                                               class="form-control orderId"
                                                                               placeholder="Order Id"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group no-min-h">
                                                                        <input type="number" name="phoneNo" id="phoneNo"
                                                                               class="form-control phoneNo"
                                                                               placeholder="Phone No">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="search_btn_wrap">
                                                        <button type="button" class="submitButton"><i
                                                                class="icofont-search-1" onclick="search()"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Grid action modals [Start] -->
                                @include('front.layouts.includes.orderActions')
                                <!-- Grid action modals [/end] -->
                                    <div class=table-responsive>
                                        <table
                                            class="table tbl-responsive table-striped mb_last_row_hightlight dispatch-orders">
                                            <thead>
                                            <tr>
                                                <th scope="col" width="100px">ID</th>
                                                <th scope="col" width="100px">Date/Time</th>
                                                <th scope="col" width="100px">ETC</th>
                                                <th scope="col" width="100px">Duration</th>
                                                <th scope="col" width="100px">Distance</th>
                                                <th scope="col" width="85px">Vehicle</th>
                                                <th scope="col" width="100px">Joey</th>
                                                <th scope="col" width="155px">Vendor</th>
                                                <th scope="col" width="220px">Customer</th>
                                                <th scope="col" width="110px">Zone</th>
                                                <th scope="col" width="140px">Status</th>
                                                <th scope="col" width="290px">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </aside>
                </div>
            </div>

            @include('front.layouts.includes.footer')
        </div>
    </main>
@stop

@section('js')

    <script src="{{ asset('assets/front/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/front/assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/assets/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/front/assets/js/select2.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&callback=initMap&libraries=&v=weekly&channel=2" async></script>

    <script>

    </script>
    <script type="text/javascript">
        // Show data from datatable
        var table = $('.dispatch-orders').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ route('Grocery-Dispatch.data') }}",
                data: function (data) {
                    data.orderId = jQuery('[name=orderId]').val();
                    data.phoneNo = jQuery('[name=phoneNo]').val();
                    data.orderType = jQuery('[name=orderType]').val();
                    data.orderStatus = jQuery('[name=order_status]').val();
                    data.orderZones = jQuery('[name=order_zones]').val();
                    data.orderVendors = jQuery('[name=order_vendors]').val();
                    data.categoryId = jQuery('[name=categoryId]').val();
                }
            },

            columns: [
                {data: 'num', name: 'num', orderable: true, searchable: true},
                {data: 'date', name: 'date', orderable: true, searchable: true},
                {data: 'dropoff_etc', name: 'dropoff_etc', orderable: true, searchable: true},
                {data: 'sprint_duration', name: 'sprint_duration', orderable: true, searchable: true},
                {data: 'distance', name: 'distance', orderable: true, searchable: true},
                {data: 'vehicle_name', name: 'vehicle_name', orderable: true, searchable: true},
                {data: 'joey_name', name: 'joey_name', orderable: true, searchable: true},
                {data: 'vendor_name', name: 'vendor_name', orderable: false, searchable: false},
                {data: 'customer_name', name: 'customer_name', orderable: false, searchable: false},
                {data: 'zone_name', name: 'zone_name', orderable: true, searchable: true},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ]
        });

        $(document).on('change', '.dispatch-table-reload', function () {
            table.ajax.reload();
        });

        $(document).on('click', '.table-reload-menu', function () {
            table.ajax.reload();
        });

        function orderType(id) {
            $('#orderType').val(id);
        }

        function orderCategory(id) {
            $('#categoryId').val(id);
        }

        function search(){
            table.ajax.reload();
        }

        function filter() {
            var status = $('#statusId').val();
            $('#order_status').val(status);
            var zones = $('#zone').val();
            $('#order_zones').val(zones);
            var vendors = $('#vendor').val();
            $('#order_vendors').val(vendors);
            table.ajax.reload();
        }

        $(document).ready(function () {
            $('.select2').select2();
        });

        //popup modals of transfer, assign and pre broadcast
        function assignTransferAndPreBroadcastModalData(id) {
            $.ajax({
                url: "order/modals/" + id,
                type: "GET",
                success: function (result) {
                    result = JSON.parse(result)
                    $('.joeys').children().remove();
                    result.joeys.forEach((key, index) => {
                        $('.joeys').append('<option value="' + key.id + '">' + key.first_name + '</option>')
                    });
                    $('#dispatch_id').val(result.dispatch.id);
                    $('#sprint_id').val(result.dispatch.sprint_id);
                    $('.CR-num').text(result.dispatch.num)
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // transfer order from joey to joey
        function transferOrderToJoey() {
            var joey = $('#transfer-joey').val();
            var dispatchId = $('#dispatch_id').val();
            $.ajax({
                url: "order/transfer/" + joey + "/dispatch/" + dispatchId,
                type: "GET",
                success: function (result) {
                    table.ajax.reload();
                    $('#transferJoeySprint').modal('hide');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // assign order to joey
        function assignOrderToJoey() {
            var joey = $('#assign-joey').val();
            var dispatchId = $('#dispatch_id').val();

            $('#loading-overlay').show();
            $.ajax({
                url: "order/assign/" + joey + "/dispatch/" + dispatchId,
                type: "GET",
                success: function (result) {

                    var res = JSON.parse(result);

                    $('#returnMessage').text(res.message)
                    $('#messages').modal();
                    // alert(result.message)
                    console.log(result);
                    table.ajax.reload();
                    $('#assignJoeySprint').modal('hide');
                    $('#loading-overlay').hide();
                },
                error: function (error) {
                    console.log(error);
                    $('#loading-overlay').hide();
                    $('#assignJoeySprint').modal('hide');

                }
            });
        }

        //Rebroadcast popup modal
        function reBroadcast(id, dispatchId) {
            $('#dispatch_id').val(dispatchId);
            $('#sprint_id').val(id);
        }

        //reBroadcast order request submit
        function reBroadcastSubmit() {
            var sprintId = $('#sprint_id').val();
            var hours = $('#hours').val();
            var minutes = $('#minutes').val();
            var dispatchId = $('#dispatch_id').val();
            $.ajax({
                url: "order/rebroadcast/" + sprintId,
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {'hours': hours, 'minutes': minutes, 'dispatch_id': dispatchId},
                success: function (result) {
                    table.ajax.reload();
                    $('.fade').modal('hide');
                    $('#orderBroadcastSuccess').modal('show');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        //preBroadcast OrderRequest
        function preBroadcastOrderToMultiJoeys() {
            var sprintId = $('#sprint_id').val();
            var multiJoeys = $('#multi_joeys').val();
            $.ajax({
                url: "order/pre_broadcast",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {'sprint_id': sprintId, 'joey_ids': multiJoeys},
                success: function (result) {

                    table.ajax.reload();
                    $('.fade').modal('hide');
                    // $('#orderBroadcastSuccess').modal('show');
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        //cancel Order Popup
        function cancelOrderPopUp(sprintId, dispatchId, status) {
            $('#sprint_id').val(sprintId);
            $('#dispatch_id').val(dispatchId);
            $('#status_id').val(status);
        }

        // dispatch cancel order request
        function sprintCancel() {
            var sprintId = $('#sprint_id').val();
            var reason = $('#reason').val();
            var dispatchId = $('#dispatch_id').val();
            var status = $('#status_id').val();
            $.ajax({
                url: "order/cancel/" + sprintId,
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {'reason': reason, 'dispatch_id': dispatchId, 'status_id': status},
                success: function (result) {
                    table.ajax.reload();
                    $('.fade').modal('hide');

                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        //Show OrderNote Popup Modal
        function showModalOfOrderNote(sprintId){
            $('#sprint_id').val(sprintId);
        }

        // order note submit to order dispatch
        function orderNoteSubmit() {
            var sprintId = $('#sprint_id').val();
            var note = $('#note').val();
            $.ajax({
                url: "order/" + sprintId + "/note",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {'note': note},
                success: function (result) {
                    console.log(result)
                    table.ajax.reload();
                    $('.fade').modal('hide');

                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        // initialize map in popup modal and show marker on order tasks
        function showOrderTaskMarkers(sprintId){
            $.ajax({
                url: "order/" + sprintId + "/map",
                type: "GET",
                success: function (result) {
                    initMap(result);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        // function initMap(result) {
        //     const map = new google.maps.Map(document.getElementById("mapDoom"), {
        //         zoom: 10,
        //         center: { lat: 43.9212, lng: -79.23123 },
        //     });
        //     setMarkers(map, result);
        // }
        // function setMarkers(map, result) {
        //     // Adds markers to the map.
        //     // Marker sizes are expressed as a Size of X,Y where the origin of the image
        //     // (0,0) is located in the top left of the image.
        //     // Origins, anchor positions and coordinates of the marker increase in the X
        //     // direction to the right and in the Y direction down.
        //     const image = {
        //         url: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
        //         // This marker is 20 pixels wide by 32 pixels high.
        //         size: new google.maps.Size(20, 32),
        //         // The origin for this image is (0, 0).
        //         origin: new google.maps.Point(0, 0),
        //         // The anchor for this image is the base of the flagpole at (0, 32).
        //         anchor: new google.maps.Point(0, 32),
        //     };
        //     // Shapes define the clickable region of the icon. The type defines an HTML
        //     // <area> element 'poly' which traces out a polygon as a series of X,Y points.
        //     // The final coordinate closes the poly by connecting to the first coordinate.
        //     const shape = {
        //         coords: [1, 1, 1, 20, 18, 20, 18, 1],
        //         type: "poly",
        //     };
        //
        //     for (let i = 0; i < result.length; i++) {
        //         const beach = result[i];
        //
        //         new google.maps.Marker({
        //             position: { lat: beach[1], lng: beach[2] },
        //             map,
        //             icon: image,
        //             shape: shape,
        //             title: beach[4],
        //             zIndex: beach[3],
        //         });
        //     }
        // }

        // order Details
        function orderDetails(sprintId){
            $.ajax({
                url: "order/" + sprintId + "/detail",
                type: "GET",
                success: function (result) {
                    result = JSON.parse(result)
                    result.tasks.forEach((key, index) => {
                        console.log(key.contact.name);
                        $('#sprint-order-detail-cr-num').text('Sprint Id # '+key.sprint_id);

                        $('#currentStatus').text(result.status)
                        if(key.type == 'pickup'){
                            $('#cr-pickup').text(result.dispatch[0].num + '-' + 'A');
                            $('#pickup-pin').text(key.pin);
                            $('#pickup-name').text(key.contact.name);
                            $('#pickup-contact').text(key.contact.phone);
                            $('#pickup-email').text(key.contact.email);
                            $('#pickup-address').text(key.location.address);
                            $('#pickup-postal_code').text(key.address.postal_code);
                            $('#pickup-merchant-order-num').text(key.merchant.merchant_order_num);
                        }
                        if(key.type == 'dropoff'){
                            $('#cr-dropoff').text(result.dispatch[0].num + '-' + '1');
                            $('#dropoff-pin').text(key.pin);
                            $('#dropoff-name').text(key.contact.name);
                            $('#dropoff-contact').text(key.contact.phone);
                            $('#dropoff-email').text(key.contact.email);
                            $('#dropoff-address').text(key.location.address);
                            $('#dropoff-postal_code').text(key.address.postal_code);
                            $('#dropoff-merchant-order-num').text(key.merchant.merchant_order_num);
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    </script>
    <script>
        function toggleItem(elem) {
            for (var i = 0; i < elem.length; i++) {
                elem[i].addEventListener("click", function(e) {
                    var current = this;
                    for (var i = 0; i < elem.length; i++) {
                        if (current != elem[i]) {
                            elem[i].classList.remove('active');
                        } else if (current.classList.contains('active') === true) {
                            current.classList.remove('active');
                        } else {
                            current.classList.add('active')
                        }
                    }
                    e.preventDefault();
                });
            };
        }
        toggleItem(document.querySelectorAll('.tab_link'));
    </script>
@stop

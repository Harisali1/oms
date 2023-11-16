@extends('front.layouts.Dispatch-layout')

@section('page-title',"Jobs Map View")

@section('css')
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

        .joeys-li{
            display: inline-block;
            background-color: #3657b9;
            padding: 5px;
            border-radius: 5px;
            margin-right: 4px;
        }
        .joeys-li a{
            color: white;
            text-decoration: none;
        }
        .active{
            background-color: #edb900;
        }
        .active a{
            color: #fff;
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
            <div id="main_content_area" class="style_2">
                <div class="heading_area">
                    <div class="container">
                        <div class="hgroup divider-after center align-center">
                            <h1 class="lh-10">Grocery Dispatch Joey Route View</h1>
                        </div>
                    </div>
                </div>
                <div class="disp_map_view_wrap">
                    <div class="row no-gutters">
                        <aside id="left_sidebar" class="col-12 col-lg-4">
                            <div class="inner">
                                <div class="widget_sidebar widget_filter">
                                    <div class="widgetInfo">
                                        <form action="" id="filter-summary" class="needs-validation" novalidate>
                                            <div class="form-group no-min-h">
                                                <label for="endDate">Joeys</label>
                                                <ul class="myUl">
                                                @foreach($joeys as $joey)
                                                        <li class="joeys-li">
                                                            <a href="javascript:void(0)" onclick="MyFunction({{ $joey->id }})">
                                                                {{ $joey ->first_name .' '. $joey->last_name}}
                                                            </a>
                                                        </li>

                                                @endforeach
                                                </ul>

{{--                                                <select id="job_id" name="job_id"--}}
{{--                                                        data-placeholder="Please Select Option"--}}
{{--                                                        class="form-control">--}}
{{--                                                    @foreach($joeys as $joey)--}}
{{--                                                        <option value="{{ $joey->id }}">{{ $joey->first_name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
                                            </div>
{{--                                            <div class="btn-group nomargin align-right">--}}
{{--                                                <button type="button" id="go" value="Draw Path"--}}
{{--                                                        class="btn btn-primary btn-xs submitButton mb-fluid mb-align-center">--}}
{{--                                                    Filter--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
                                            <div class="orders_result"></div>
                                        </Form>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <aside id="right_content" class="col-12 col-lg-8">
                            <div id="map-layer" class="inner google_map">
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
            @include('front.layouts.includes.footer')
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop

@section('js')

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&callback=initMap&libraries=&v=weekly&channel=2"
        async></script>
    <script>
        var map;
        var waypoints;
        var locations = [];

        function initMap() {
            var mapLayer = document.getElementById("map-layer");
            var centerCoordinates = new google.maps.LatLng(24.716438736567383, 46.67320997799136);
            var defaultOptions = {center: centerCoordinates, zoom: 8}
            map = new google.maps.Map(mapLayer, defaultOptions);
        }

        function MyFunction(id) {
            var list = document.getElementsByClassName("joeys-li");
            for (var i = 0; i < list.length; i++) {
                list[i].addEventListener("click", function() {
                    var current = document.getElementsByClassName("active");
                    if (current.length > 0) {
                        current[0].className = current[0].className.replace(" active", "");
                    }
                    this.className += " active";
                });
            }

            $('#loading-overlay').show();
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
            directionsDisplay.setMap(map);
            waypoints = [];
            $.ajax({
                url: "jobs/" + id,
                type: "GET",
                success: function (result) {
                    $('#loading-overlay').hide();
                    result = JSON.parse(result)
                    if (result.output.length == 0) {
                        return alert(result.message);
                    }
                    result.output.forEach(function (element, index) {
                        locations.push([element.lat, element.lng, element.location_name, element.type, element.sprint_id]);
                        waypoints.push({
                            location: element.location_name,
                            stopover: true,
                        });
                    });
                    var locationCount = locations.length;
                    if (locationCount > 0) {
                        var start = locations[0][2];
                        var end = locations[locationCount - 1][2];
                        drawPath(directionsService, directionsDisplay, start, end);
                    }
                },
                error: function (error) {
                    console.log(error);
                    $('#loading-overlay').hide();
                }
            });
        }

        function drawPath(directionsService, directionsDisplay, start, end) {

            directionsService.route({
                origin: start,
                destination: end,
                waypoints: waypoints,
                optimizeWaypoints: true,
                travelMode: 'DRIVING'

            }, function (response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                    for (i = 0; i < locations.length; i++) {
                        var icon = '';
                        // console.log(locations.length);
                        // console.log(locations);
                        if (locations[i][3] == 'pickup') {
                            icon = "<?=url('/')?>/assets/front/assets/images/default.png";
                            var marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                                map: map,
                                icon: icon,
                                zIndex: locations[i][5],
                                title: "Pickup Point",
                                // animation: google.maps.Animation.DROP
                            });

                            var type = locations[i][3];
                            var title = locations[i][2];
                            var sprintId = locations[i][4];

                            var infoWindow1 = new google.maps.InfoWindow();

                            google.maps.event.addListener(marker1, 'click', (function(marker1, i) {

                                return function() {
                                    var markerContent1 = '<div id="content">' +
                                        '<div id="siteNotice">' +
                                        '</div>' +
                                        '<h3 id="firstHeading" class="firstHeading">' + type + '</h3>' +
                                        '<div id="bodyContent">' +
                                        '<p><b>Order Id: </b>' + title + '</p>' +
                                        '<p><b>Address: </b>' + sprintId + '</p>' +
                                        '</div>';
                                    infoWindow1.setContent(markerContent1);
                                    infoWindow1.open(map, marker1);
                                }
                            })(marker1, i));

                            // google.maps.event.addListener(marker1, 'click', function () {
                            //     var markerContent1 = '<div id="content">' +
                            //         '<div id="siteNotice">' +
                            //         '</div>' +
                            //         '<h3 id="firstHeading" class="firstHeading">' + type + '</h3>' +
                            //         '<div id="bodyContent">' +
                            //         '<p><b>Order Id: </b>' + title + '</p>' +
                            //         '<p><b>Address: </b>' + sprintId + '</p>' +
                            //         '</div>';
                            //     infoWindow1.setContent(markerContent1);
                            //     infoWindow1.open(map, this);
                            // });
                            // makeMarker(new google.maps.LatLng(locations[i][0], locations[i][1]), icon, "Pick Up Point");
                        } else {
                            icon = "<?=url('/')?>/assets/front/assets/images/pet-store.png";

                            var marker2 = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                                map: map,
                                icon: icon,
                                zIndex: locations[i][5],
                                title: "Drop Off Point",
                                // animation: google.maps.Animation.DROP
                            });
                            // console.log(locations);
                            var droptype = locations[i][3];
                            var droptitle = locations[i][2];
                            var dropsprintId = locations[i][4];

                            // console.log(droptitle)

                            var infoWindow2 = new google.maps.InfoWindow();
                            google.maps.event.addListener(marker2, 'click', (function(marker2, i) {

                                return function() {
                                    var markerContent2 = '<div id="content">' +
                                        '<div id="siteNotice">' +
                                        '</div>' +
                                        '<h3 id="firstHeading" class="firstHeading">' + droptype + '</h3>' +
                                        '<div id="bodyContent">' +
                                        '<p><b>Order Id: </b>' + droptitle + '</p>' +
                                        '<p><b>Address: </b>' + dropsprintId + '</p>' +
                                        '</div>';
                                    infoWindow2.setContent(markerContent2);
                                    infoWindow2.open(map, marker2);
                                }
                            })(marker2, i));
                            // google.maps.event.addListener(marker2, 'click', function () {
                            //     var markerContent = '<div id="content">' +
                            //         '<div id="siteNotice">' +
                            //         '</div>' +
                            //         '<h3 id="firstHeading" class="firstHeading">' + droptype + '</h3>' +
                            //         '<div id="bodyContent">' +
                            //         '<p><b>Order Id: </b>' + dropsprintId + '</p>' +
                            //         '<p><b>Address: </b>' + droptitle + '</p>' +
                            //         '</div>';
                            //     infoWindow2.setContent(markerContent);
                            //     infoWindow2.open(map, this);
                            // });
                            // makeMarker(new google.maps.LatLng(locations[i][0], locations[i][1]), icon, "Drop Off Point");
                        }
                    }
                } else {
                    window.alert('Problem in showing direction due to ' + status);
                }
            });
        }
    </script>

@stop

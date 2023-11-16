@extends('front.layouts.Dispatch-layout')

@section('page-title',"Dispatch Map View")

@section('css')
	<style>
		/*my css*/
	</style>
@stop

<?php

$statusIds = array("136" => "Client requested to cancel the order",
    "137" => "Delay in delivery due to weather or natural disaster",
    "118" => "left at back door",
    "117" => "left with concierge",
    "135" => "Customer refused delivery",
    "108" => "Customer unavailable-Incorrect address",
    "106" => "Customer unavailable - delivery returned",
    "107" => "Customer unavailable - Left voice mail - order returned",
    "109" => "Customer unavailable - Incorrect phone number",
    "142" => "Damaged at hub (before going OFD)",
    "143" => "Damaged on road - undeliverable",
    "144" => "Delivery to mailroom",
    "103" => "Delay at pickup",
    "139" => "Delivery left on front porch",
    "138" => "Delivery left in the garage",
    "114" => "Successful delivery at door",
    "113" => "Successfully hand delivered",
    "120" => "Delivery at Hub",
    "110" => "Delivery to hub for re-delivery",
    "111" => "Delivery to hub for return to merchant",
    "121" => "Pickup from Hub",
    "102" => "Joey Incident",
    "104" => "Damaged on road - delivery will be attempted",
    "105" => "Item damaged - returned to merchant",
    "129" => "Joey at hub",
    "128" => "Package on the way to hub",
    "140" => "Delivery missorted, may cause delay",
    "116" => "Successful delivery to neighbour",
    "132" => "Office closed - safe dropped",
    "101" => "Joey on the way to pickup",
    "32"  => "Order accepted by Joey",
    "14"  => "Merchant accepted",
    "36"  => "Cancelled by JoeyCo",
    "124" => "At hub - processing",
    "38"  => "Draft",
    "18"  => "Delivery failed",
    "56"  => "Partially delivered",
    "17"  => "Delivery success",
    "68"  => "Joey is at dropoff location",
    "67"  => "Joey is at pickup location",
    "13"  => "Waiting for merchant to accept",
    "16"  => "Joey failed to pickup order",
    "57"  => "Not all orders were picked up",
    "15"  => "Order is with Joey",
    "112" => "To be re-attempted",
    "131" => "Office closed - returned to hub",
    "125" => "Pickup at store - confirmed",
    "61"  => "Scheduled order",
    "37"  => "Customer cancelled the order",
    "34"  => "Customer is editting the order",
    "35"  => "Merchant cancelled the order",
    "42"  => "Merchant completed the order",
    "54"  => "Merchant declined the order",
    "33"  => "Merchant is editting the order",
    "29"  => "Merchant is unavailable",
    "24"  => "Looking for a Joey",
    "23"  => "Waiting for merchant(s) to accept",
    "28"  => "Order is with Joey",
    "133" => "Packages sorted",
    "55"  => "ONLINE PAYMENT EXPIRED",
    "12"  => "ONLINE PAYMENT FAILED",
    "53"  => "Waiting for customer to pay",
    "141" => "Lost package",
    "60"  => "Task failure");

?>

@section('content')
    <main id="main" class="page-dispatch" data-page="dispatch">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area" class="style_2">
				<div class="heading_area">
					<div class="container">
						<div class="hgroup divider-after center align-center">
							<h1 class="lh-10">Dispatch Map View</h1>
						</div>
					</div>
				</div>
				<div class="disp_map_view_wrap">
					<div class="row no-gutters">
						<!-- Sidebar -->
						<aside id="left_sidebar" class="col-12 col-lg-3">
							<div class="inner pr-30">
								<div class="widget_sidebar widget_filter">
									<h5 class="widgetTitle"><i class="icofont-user-alt-5"></i> Filter Results</h5>
									<div class="widgetInfo">
										<form action="" id="filter-summary" class="needs-validation" novalidate>

											<div class="form-group no-min-h">
                                                <label for="status">Filter by Status</label>
                                                <select id="status" name="status" required="" data-placeholder="Select Status" class="select2 form-control form-control-lg">
												<option value="" selected>Select Status *</option>
                                                    @foreach($statusIds as $key => $oc)
                                                        <option value="{{ $key }}">{{ $oc }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="divider sm"></div>

                                            <div class="form-group no-min-h">
                                                <label for="endDate">Select Joey</label>
                                                <select name="joeyId" id="joeyId"  data-placeholder="Select Joey" class="select2 form-control joeyId dispatch-table-reload">
                                                    <option value="" selected>Select Joey</option>
                                                    @foreach($joeys as $key => $joey)
                                                        <option value="{{ $joey->id }}">{{ $joey->first_name }} {{ $joey->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="divider sm"></div>
                                            <div class="form-group no-min-h">
                                                <label for="zone">Filter by zones</label>
                                                <select id="zone" name="zone[]" multiple="multiple"
                                                        data-placeholder="Select Zone"
                                                        class="select2 form-control form-control-lg">
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
                                                        <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="btn-group nomargin align-right">
                                                <button type="button" onclick="showMarkersOfOrders()"
                                                        class="btn btn-primary btn-xs submitButton mb-fluid">Filter Results
                                                </button>
                                            </div>
										</Form>
									</div>
								</div>
							</div>
						</aside>
						<aside id="right_content" class="col-12 col-lg-9">
							<div id="map" class="inner google_map">
							</div>
						</aside>
					</div>
				</div>
            </div>
			<!-- Content Area - [/end] -->

			@include('front.layouts.includes.footer')
        </div>
    </main>
@stop

@section('js')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&callback=initMap&libraries=&v=weekly&channel=2" async></script>
	<script>

        $(document).ready(function () {
            $('.select2').select2();
        });

        function showMarkersOfOrders(){

			var statuses = $('#status').val();
			var joeyId = $('#joeyId').val();
            var vendors = $('#vendor').val();
            var zones = $('#zone').val();

            $.ajax({
                url: "dispatch/map-view",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {'statuses': statuses,'joey': joeyId, 'vendors': vendors, 'zones': zones},
                success: function (result) {
                    console.log(result)
                    initMap(result);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }


        var map;
        function initMap(result) {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: { lat: 23.668768790667194, lng: 44.926049864035406 },
                clickable: true
            });
            setMarkers(map, result);
        }
        const alphabet = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
        const num = ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26"];
        function setMarkers(map, result) {
            for (let i = 0; i < result.length; i++) {
                const beach = result[i];
                var image = '<?=url('/')?>/assets/front/assets/images/default.png';

                //if(result[i][4] === 'pickup'){
                //    var image = {
                //        url: "<?=url('/')?>/assets/front/assets/images/pet-store.png",
                //    };
                //}else{
                //    var image = {
                //        url: "<?=url('/')?>/assets/front/assets/images/default.png",
                //    };
                //}
                // console.log(num++);

                // console.log(num++);

                var marker = new google.maps.Marker({
                    position: { lat: beach[1], lng: beach[2] },
                    map,
                    // icon: image,
                    label: result[i][4] == 'pickup' ? alphabet[i] : num[i],
                    title: beach[5],
                    zIndex: beach[3],
                    animation: google.maps.Animation.DROP
                });

                var infoWindow = new google.maps.InfoWindow();

                google.maps.event.addListener(marker, 'click', function () {
                    var markerContent = '<div id="content">'+
                        '<div id="siteNotice">'+
                        '</div>'+
                        // '<h3 id="firstHeading" class="firstHeading">'+ result[i][4] +'</h3>'+
                        '<div id="bodyContent">'+
                        '<p><b>Status: </b>' + result[i][6] + '</p>'+
                        '<p><b>Order Id: </b>' + result[i][5] + '</p>'+
                        '<p><b>Address: </b>' + result[i][0] + '</p>' +
                        '</div>';
                    infoWindow.setContent(markerContent);
                    infoWindow.open(map, this);
                });

            }
        }
	</script>
@stop

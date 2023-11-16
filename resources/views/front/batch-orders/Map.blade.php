<style>
    .form-group:not(.has-radio):not(.has-checkbox):not(.no-min-h) {
        min-height: 60px;
    }

    .modal-dialog.modal-md {
        margin: 365px 0px 0px 279px;
    }

    .modal-content {
        width: 90%;
    }

    #main .pg-container {
        min-height: unset !important;
    }

    .unsetBox {
        display: none;
    }
</style>
<div class="modal-content">
    <main id="main" class="page-dispatch align-content-center" data-page="dispatch">
        <div class="container-fluid">
            <div class="pg-container container-fluid">
                <!-- Content Area - [Start] -->
                <div id="main_content_area" class="style_2">
                    <div class="modal-header">
                        <div class="hgroup divider-after left">
                            <h2 class="">Map</h2>
                        </div>
                    </div>
                    <div class="disp_map_view_wrap">
                        <div class="row no-gutters" style="display: block">
                            <!-- Sidebar -->
                            <div class="unsetBox">
                                <div class="container-fluid inner pr-30">
                                    <h2 class="sidebar-header "></h2>
                                    <span value="{{$vendorLocation->id }}"></span>
                                    <input type="hidden" id="VendorName" value="{{ $vendorName}}">
                                    <input type="hidden" id="VendorAddress"
                                           value="{{$vendorLocation->address .', '. $vendorLocation->city->name .', '. $vendorLocation->postal_code}}">

                                    {{--pick up detials--}}
                                    <input type="hidden" id="vlongitude" value="{{$Vlongitude}}">
                                    <input type="hidden" id="vlatitude" value="{{$Vlatitude}}">

                                </div>
                            </div>
                            {{--Drop Off location content--}}
                            <input type="hidden" id="dropOfflongitude_one"
                                   value="{{isset($droplongitude_one) ? $droplongitude_one : ''}}">
                            <input type="hidden" id="dropOfflatitude_one"
                                   value="{{isset($dropOfflatitude_one) ? $dropOfflatitude_one : ''}}">
                            <input type="hidden" id="dropoff_address_one"
                                   value="{{isset($dropoff_address_one) ? $dropoff_address_one : ''}}">

                            <input type="hidden" id="dropOfflongitude_two"
                                   value="{{isset($droplongitude_two) ? $droplongitude_two : ''}}">
                            <input type="hidden" id="dropOfflatitude_two"
                                   value="{{isset($dropOfflatitude_two) ? $dropOfflatitude_two : ''}}">
                            <input type="hidden" id="dropoff_address_two"
                                   value="{{isset($dropoff_address_two) ? $dropoff_address_two : ''}}">

                            <aside id="right_content" class="col-12 col-lg-9"
                                   style="max-height: 400px; min-height: 400px !important;max-width: 100% !important; ">
                                <div id="dvMap" class="inner google_map container-fluid"
                                     style="width: 100%; height: 380px !important; margin: 0; max-width: 100% !important;">
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Area - [/end] -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-xs mb-fluid" data-dismiss="modal">Close</button>
            </div>
        </div>
    </main>
</div>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTK4viphUKcrJBSuoidDqRhVA4AWnHOo0&callback=initMap&libraries=&v=weekly&channel=2"
    async></script>

<script type="text/javascript">

    // Pick up location
    var vlatitude = $('#vlatitude').val();
    var vlongitude = $('#vlongitude').val();
    var VendorAddress = $('#VendorAddress').val();


    // drop off addresses
    var dropoff_address_one = $('#dropoff_address_one').val();
    var dropoff_address_two = $('#dropoff_address_two').val();

    var arr = [dropoff_address_one, dropoff_address_two];
    var a = JSON.stringify(arr);


    var dropOfflatitude_one = $('#dropOfflatitude_one').val();
    var dropOfflongitude_one = $('#dropOfflongitude_one').val();
    var one_dropoff_address = arr[0];

    var dropOfflatitude_two = $('#dropOfflatitude_two').val();
    var dropOfflongitude_two = $('#dropOfflongitude_two').val();
    var two_dropoff_address = arr[1];

    var markers = [
        {
            "title": '<h4> Pick up Address:  </h4> ' + VendorAddress,
            "detail": 'Pick up',
            "lat": vlatitude,
            "lng": vlongitude,
            "icon": "/assets/front/assets/images/default.png",
        },
        {
            "title": '<h4> Drop off Address One:  </h4>  ' + one_dropoff_address,
            "detail": 'Drop off',
            "lat": dropOfflatitude_one,
            "lng": dropOfflongitude_one,
            "icon": "/assets/front/assets/images/pet-store.png",
        },
        {
            "title": '<h4> Drop off Address Two:  </h4>  ' + two_dropoff_address,
            "detail": 'Drop off',
            "lat": dropOfflatitude_two,
            "lng": dropOfflongitude_two,
            "icon": "/assets/front/assets/images/pet-store.png",
        }
    ];

    window.initMap = initMap;

    function initMap() {
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            zoom: 10,
            gestureHandling: "greedy",
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);

        //Create and open InfoWindow.
        var infoWindow = new google.maps.InfoWindow();

        for (var i = 0; i < markers.length; i++) {
            var data = markers[i];
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: data.icon,
                title: data.detail
            });

            //Attach click event to the marker.
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                    infoWindow.setContent("<div style = 'width:100% ;height:25%'>" + data.title + "</div>");
                    infoWindow.open(map, marker);
                });
            })(marker, data);
        }
    }
</script>


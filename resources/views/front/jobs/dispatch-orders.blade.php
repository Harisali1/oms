@extends('front.layouts.Dispatch-layout')

@section('page-title',"Dispatch Orders")

@section('css')
	<style>
		/*my css*/

		.pagination{ margin-top: 30px;}
		.pagination li.disabled{opacity: 0.5;}
		.pagination li a{text-decoration: none; color: #443404;}
		.pagination li.active .page-link{ background: #e46d29 !important; color: #ffffff !important; border: none;}
		.pagination{}
	</style>
@stop

@section('content')
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
										<li><a href="#" data-status_id="{{115}}" name="stuck" class="table-reload-menu">Stuck <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">New <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Edit <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Active <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Completed <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Rejected <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Return <span class="count">(12)</span> </a></li>
										<li><a href="#" class="table-reload-menu">Scheduled <span class="count">(12)</span> </a></li>
									</ul>
								</div>
							</div>
							<div class="widget_sidebar widget_filter">
								<h5 class="widgetTitle"><i class="icofont-user-alt-5"></i> Filter Results</h5>
								<div class="widgetInfo">
									<form action="" id="filter-summary" class="needs-validation" novalidate>
										<div class="form-group no-min-h">
											<label for="startDate">Records per page</label>
											<select id="recordsPerPage" name="recordsPerPage" class="form-control form-control-lg" required>
												<option value="0" disabled selected>Select Record</option>
												<option value="">10 Records</option>
												<option value="">20 Records</option>
												<option value="">30 Records</option>
												<option value="">40 Records</option>
												<option value="">50 Records</option>
												<option value="">70 Records</option>
												<option value="">100 Records</option>
												<option value="">200 Records</option>
												<option value="">500 Records</option>
												<option value="">600 Records</option>
											</select>
										</div>
										<div class="divider sm"></div>
										<div class="form-group no-min-h">
											<label for="endDate">Filter by zones</label>
											<select id="filterByzone" name="filterByzone" class="form-control form-control-lg">
												<option value="0" disabled selected>Select Zone</option>
												<option value="">Zone 1</option>
												<option value="">Zone 2</option>
												<option value="">Zone 3</option>
											</select>

											<div class="selected_list">
												<h5>Selected Zones</h5>
												<ul>
													<li><span class="selected_lbl">Zone 1</span></li>
													<li><span class="selected_lbl">Zone 2</span></li>
													<li><span class="selected_lbl">Zone 3</span></li>
													<li><span class="selected_lbl">Zone 4</span></li>
												</ul>
											</div>
										</div>
										<div class="divider sm"></div>
										<div class="form-group">
											<label for="endDate">Filter by Vendor</label>
											<select id="filterByvendor" name="filterByvendor" class="form-control form-control-lg">
												<option value="0" disabled selected>Select Vendor</option>
												<option value="">Vendor 1</option>
												<option value="">Vendor 2</option>
												<option value="">Vendor 3</option>
											</select>

											<div class="selected_list">
												<h5>Selected Vendor</h5>
												<ul>
													<li><span class="selected_lbl">Vendor 1</span></li>
													<li><span class="selected_lbl">Vendor 2</span></li>
													<li><span class="selected_lbl">Vendor 3</span></li>
													<li><span class="selected_lbl">Vendor 4</span></li>
												</ul>
											</div>
										</div>
										<div class="btn-group nomargin align-right">
											<button type="submit" disabled class="btn btn-primary btn-xs submitButton mb-fluid">Filter Results</button>
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
											<a href="{{route('Dispatch-map')}}" class="btn btn-white btn-sm mb-fluid mb-align-center">Switch to Map View</a>
										</div>
									</div>
								</div>

								<section class="section-content summary-section no-border">
									<div class="section-inner">
										<div class="grid_controls">
											<div class="row align-items-end">
												{{--<div class="col-12 col-sm-4">
													<div class="cs_pagination">
														<ul class="no-list d-flex">
															<li><a href="#" class="cs_btn">Previous</a></li>
															<li><select name="" id="" class="form-control pages-dd">
																<option value="1">Page 1</option>
																<option value="2">Page 2</option>
																<option value="3">Page 3</option>
																<option value="4">Page 4</option>
															</select></li>
															<li><a href="#" class="cs_btn">Next</a></li>
														</ul>
													</div>
												</div>--}}
												<div class="col-12 col-sm-8">
													<form method="get" action="grocery-dispatch" class="needs-validation grid_sort_controls" novalidate>
														<div class="form-row">
															<div class="form-group no-min-h col-12 col-sm-4">
																<label for="endDate">Select status</label>
																{{--<select name="statusId" id="statusId" class="form-control statusId" >
																	<option value="0" disabled selected>Select Status</option>
																	@foreach(getStatusCodesWithKey('status_labels') as $key => $value)
																	<option value="{{$key}}">{{$value}}</option>
																	@endforeach
																</select>--}}
																<select name="statusId" id="statusId" class="form-control statusId dispatch-table-reload" >
																	<option value="0" disabled selected>Select Status</option>
																	@foreach(getStatusCodesWithKey('status_labels') as $key => $value)
																		<option value="{{ $key }}">{{$value}}</option>
																	@endforeach
																</select>
															</div>

															<div class="form-group no-min-h col-12 col-sm-8">
																<label for="email">Search by</label>
																<div class="row no-gutter merge-fields or-separator">
																	<div class="col-6">
																		<div class="form-group no-min-h">
																			<input type="text" name="orderId" id="orderId" class="form-control orderId dispatch-table-reload" placeholder="Order Id"/>
																		</div>
																	</div>
																	<div class="col-6">
																		<div class="form-group no-min-h">
																			<input type="number" name="phoneNo" id="phoneNo" class="form-control phoneNo dispatch-table-reload" placeholder="Phone No"/>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="search_btn_wrap">
															<button type="submit" class="submitButton"><i class="icofont-search-1"></i></button>
														</div>
													</form>
												</div>
											</div>
										</div>


										<!-- Grid action modals [Start] -->
									@include('front.layouts.includes.orderActions')
										<!-- Grid action modals [/end] -->


										<div class=table-responsive>
											<table class="table tbl-responsive table-striped mb_last_row_hightlight dispatch-orders">
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
											{{--<div class="d-flex justify-content-center">
												{!! $dispatchOrders->links() !!}
											</div>--}}
										</div>

										{{--<div class="cs-pagination dp-table marginauto mt-20">--}}
											{{--<nav>--}}
												{{--<ul class="pagination">--}}
													{{--<li class="page-item"><span class="page-link"><i class="icofont-double-left"></i></span></li>--}}
													{{--<li class="page-item"><span class="page-link"><i class="icofont-simple-left"></i></span></li>--}}
													{{--<li class="page-item">--}}
														{{--<select name="" id="" class="form-control">--}}
															{{--<option>Page 1</option>--}}
															{{--<option>Page 2</option>--}}
															{{--<option>Page 3</option>--}}
														{{--</select>--}}
													{{--</li>--}}
													{{--<li class="page-item"><span class="page-link"><i class="icofont-simple-right"></i></span></li>--}}
													{{--<li class="page-item"><span class="page-link"><i class="icofont-double-right"></i></span></li>--}}
												{{--</ul>--}}
											{{--</nav>--}}
										{{--</div>--}}
									</div>
								</section>
                            </div>
                    </aside>
                </div>
            </div>
			<!-- Content Area - [/end] -->

		@include('front.layouts.includes.footer')
        </div>
    </main>
@stop

@section('js')
	<script src="{{ asset('assets/front/assets/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/front/assets/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/front/assets/js/dataTables.responsive.js') }}"></script>
	<script src="{{ asset('assets/front/assets/js/select2.min.js') }}"></script>
	<script type="text/javascript">


            var table = $('.dispatch-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url:"{{ route('Grocery-Dispatch.data') }}",
					data:function (data) {
                        data.statusId = jQuery('[name=statusId]').val();
                        data.orderId = jQuery('[name=orderId]').val();
                        data.phoneNo = jQuery('[name=phoneNo]').val();
                        let state_filter = function element() { $( '.table-reload-menu' ).click( function() { return 0; } )}
                        console.log(state_filter);
                        if(state_filter == 0 ) {
                            alert('if');
                            data.stuck =  $('.table-reload-menu').attr('data-status_id');
                        } else {
                            data.phoneNo = null;
                        }
                        /*data.stuck =  $('.table-reload-menu').attr('data-status_id');*/

                    }
				} ,
                columns: [
                    {data: 'order_id', name: 'order_id', orderable: true, searchable: true},
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

            
            $(document).on('change','.dispatch-table-reload',function () {
                table.ajax.reload();
            });

            $(document).on('click','.table-reload-menu',function () {
                table.ajax.reload();
            });



            /*setInterval( function () {
                table.ajax.reload();
            }, 10000 );*/

	</script>
@stop
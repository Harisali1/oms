@extends('front.layouts.Dispatch-layout')

@section('page-title',"Edit Custom Run")

@section('css')
	<style>
		/*my css*/
	</style>
@stop

@section('content')
    <main id="main" class="page-dispatch" data-page="dispatch">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
				<section class="section-padding">
					<div class="container">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="hgroup">
									<h2>CR-7862341</h2>
								</div>
								<div class=table-responsive>
									<table class="table tbl-responsive table-striped mb_last_row_hightlight">
										<thead>
											<tr>
												<th>Status</th>
												<th>Delivery success</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Date/Time</td>
												<td><input type="text" value="2021-08-26 10:30:00" class="form-control" name="name" required></td>
											</tr>
											<tr>
												<td>Order Ready Date:</td>
												<td>2021-08-26 10:30:00</td>
											</tr>
											<tr>
												<td>Joey Accept Date:</td>
												<td>2021-08-26 10:30:00</td>
											</tr>
											<tr>
												<td>Completion Date:</td>
												<td>2021-08-26 10:30:00</td>
											</tr>
											<tr>
												<td>Joey:</td>
												<td>Mujahed Ali Mohammed
													<br/><a href="transfer-joey.php" class="btn btn-basecolor1 btn-mb">Transfer Joey</a>
												</td>
											</tr>
											<tr>
												<td>Joey shift:</td>
												<td>SH-132688</td>
											</tr>
											<tr>
												<td>Vehicle:</td>
												<td>
													<select name="" class="form-control">
														<option value="">Bicycle</option>
														<option value="">Car</option>
														<option value="">Scooter</option>
														<option value="">SUV</option>
														<option value="">Truck</option>
														<option value="">Van</option>
													</select>
												</td>
											</tr>
											<tr>
												<td td="name">Distance:</td>
												<td>8.40 km</td>
											</tr>
											<tr>
												<td td="name">Distance Charge:</td>
												<td>$0.00</td>
											</tr>
											<tr>
												<td>Task Total:</td>
												<td>$12.00</td>
											</tr>
											<tr>
												<td>Tax:</td>
												<td>$1.56</td>
											</tr>
											<tr>
												<td>Tip:</td>
												<td>
													<input type="text" value="$0.00" class="form-control" name="name" required>
													<a href="transfer-joey.php" class="btn btn-basecolor1 btn-mb mt-10">Update Pickup</a>
												</td>
											</tr>
											<tr>
												<td>Customer Credits:</td>
												<td>$0.00</td>
											</tr>
											<tr>
												<td>Total:</td>
												<td>$13.56</td>
											</tr>
											<tr>
												<td>Grand Total:</td>
												<td>$13.56</td>
											</tr>
											<tr>
												<td>Customer Charge:</td>
												<td>$0.00</td>
											</tr>
											<tr>
												<td>Merchant Charge:</td>
												<td>$13.56</td>
											</tr>
											<tr>
												<td>Joey Pay:</td>
												<td>$9.60</td>
											</tr>
											<tr>
												<td>Joey Tax Pay:</td>
												<td>$0.00</td>
											</tr>
											<tr>
												<td>JoeyCo Pay:</td>
												<td>$3.9</td>
											</tr>
											<tr>
												<td>Joey at pickup location:</td>
												<td>2021-08-26 11:40:20</td>
											</tr>
											<tr>
												<td>Joey at dropoff location:</td>
												<td>$0.00</td>
											</tr>
											<tr>
												<td>Pickup completed:</td>
												<td>2021-08-26 12:01:18</td>
											</tr>
											<tr>
												<td>Dropoff completed:</td>
												<td>$3.9</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="hgroup">
									<h2>CR-7862341-A</h2>
								</div>
								<div class=table-responsive>
									<table class="table tbl-responsive table-striped mb_last_row_hightlight">
										<tbody>
											<tr>
												<td>Pin</td>
												<td><input type="text" value="2021-08-26 10:30:00" class="form-control" name="name" required></td>
											</tr>
											<tr>
												<td>Payment:</td>
												<td>
													<select name="" class="form-control">
														<option value="">None</option>
														<option value="">Make</option>
														<option value="">Collect</option>
													</select>
													<input type="text" value="$0.00" class="form-control mt-10">
												</td>
											</tr>
											<th colspan="2">
												<span class="f18">Location:</span><br/>
												<span class="regular bf-color">Updating this will affect distance if it was wrong.</span>
											</th>
											<tr>
												<td>Address</td>
												<td><input type="text" value="" class="form-control"></td>
											</tr>
											<tr>
												<td>Postal code</td>
												<td><input type="text" value="" class="form-control"></td>
											</tr>
											<tr>
												<td>Buzzer</td>
												<td><input type="text" value="" class="form-control"></td>
											</tr>
											<tr>
												<td>Suite</td>
												<td><input type="text" value="" class="form-control"></td>
											</tr>
											<th colspan="2">
												<span class="f18">Contact:</span><br/>
											</th>
											<tr>
												<td>Name</td>
												<td><input type="text" value="Walmart -Dixie and Dundas- 1126" class="form-control"></td>
											</tr>
											<tr>
												<td>Phone</td>
												<td><input type="text" value="(905) 270-2547" class="form-control"></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><input type="text" value="g8929qh5m635c66832ajlk049x0612@mailinator.com" class="form-control"></td>
											</tr>
											<tr>
												<td colspan="2" class="align-center">
													<button type="submit" class="btn btn-basecolor1">Update CR-7862341-A</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="divider"></div>

								<div class=table-responsive>
									<table class="table tbl-responsive table-striped mb_last_row_hightlight">
										<tr>
											<td>Joey at pickup location:</td>
											<td>2021-08-26 11:40:20</td>
										</tr>
										<tr>
											<td>Joey at dropoff location:</td>
											<td>$0.00</td>
										</tr>
										<tr>
											<td>Pickup completed:</td>
											<td>2021-08-26 12:01:18</td>
										</tr>
										<tr>
											<td>Dropoff completed:</td>
											<td>$3.9</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
            </div>
			<!-- Content Area - [/end] -->

			<?php include('./includes/footer.php') ?>
        </div>
    </main>
@stop

@section('js')
	<script src="{{ asset('assets/front/assets/js/select2.min.js') }}"></script>
	<script>
        /*my js*/
	</script>
@stop
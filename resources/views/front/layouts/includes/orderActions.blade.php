{{--Transfer Order from joey to joey--}}
<div class="modal fade" id="transferJoeySprint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transfer Joey Sprint</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  	<h5 class="bf-color">Transferring <strong class="basecolor1 CR-num" id="transfer-CR-num"></strong></h5>
		<form action="" class="needs-validation" novalidate>
			<div class="form-group">
                <label for="transfer-joey">Select Joey</label>
                <select class="select2 form-control form-control-lg joeys" name="joey" id="transfer-joey">
				</select>
                <input type="hidden" name="dispatch_id" id="dispatch_id">
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-xs btn-primary" onclick="transferOrderToJoey()">Transfer</button>
      </div>
    </div>
  </div>
</div>

{{--Assign Order To Joey--}}
<div class="modal fade" id="assignJoeySprint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Joey Sprint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="bf-color">Assigning <strong class="basecolor1 CR-num" id="assign-CR-num"></strong></h5>
                <form action="" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="assign-joey">Select Joey</label>
                        <select class="select2 form-control form-control-lg joeys" name="joey" id="assign-joey">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-xs btn-primary" onclick="assignOrderToJoey()">Assign</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="messages">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
{{--                <h5 class="modal-title text-center" id="exampleModalLabel">Assign Joey Sprint</h5>--}}
                <h5 id="returnMessage" class="text-center"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
{{--            <div class="modal-body">--}}
{{--                <h5 class="bf-color">Assigning <strong class="basecolor1 CR-num" id="assign-CR-num"></strong></h5>--}}
{{--                <form action="" class="needs-validation" novalidate>--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="assign-joey">Select Joey</label>--}}
{{--                        <select class="select2 form-control form-control-lg joeys" name="joey" id="assign-joey">--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Done</button>
{{--                <button type="button" class="btn btn-xs btn-primary" onclick="assignOrderToJoey()">Assign</button>--}}
            </div>
        </div>
    </div>
</div>

{{--Re Broadcast Order--}}
<div class="modal fade" id="orderBroadcast" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rebroadcast</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="sprint_id" id="sprint_id">
		<h6 class="bf-color">Select time to rebroadcast <span>CR-7868924</span></h6>
		<div class="form-row">
			<div class="form-group no-min-h col-6">
				<label>Hours</label>
				<select name="hours" id="hours" class="form-control">
					<option value="0">00</option>
					<option value="1">01</option>
					<option value="3">03</option>
                    <option value="4">04</option>
                    <option value="5">05</option>
                    <option value="6">06</option>
                    <option value="7">07</option>
                    <option value="8">08</option>
                    <option value="9">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
				</select>
			</div>
			<div class="form-group no-min-h col-6">
				<label>Minutes</label>
				<select name="minutes" id="minutes" class="form-control">
					<option value="0">00</option>
					<option value="0.015">01</option>
					<option value="0.030">02</option>
                    <option value="0.045">03</option>
                    <option value="0.060">04</option>
                    <option value="0.075">05</option>
                    <option value="0.090">06</option>
                    <option value="0.0105">07</option>
                    <option value="0.0120">08</option>
                    <option value="0.135">09</option>
                    <option value="0.150">10</option>
                    <option value="0.165">11</option>
                    <option value="0.180">12</option>
                    <option value="0.195">13</option>
                    <option value="0.210">14</option>
                    <option value="0.225">15</option>
                    <option value="0.240">16</option>
                    <option value="0.255">17</option>
                    <option value="0.270">18</option>
                    <option value="0.285">19</option>
                    <option value="0.300">20</option>
                    <option value="0.315">21</option>
                    <option value="0.330">22</option>
                    <option value="0.345">23</option>
                    <option value="0.360">24</option>
                    <option value="0.375">25</option>
                    <option value="0.390">26</option>
                    <option value="0.405">27</option>
                    <option value="0.420">28</option>
                    <option value="0.435">29</option>
                    <option value="0.450">30</option>
                    <option value="0.465">31</option>
                    <option value="0.">32</option>
                    <option value="0.015">33</option>
                    <option value="0.030">34</option>
                    <option value="0.015">35</option>
                    <option value="0.030">36</option>
                    <option value="0.015">37</option>
                    <option value="0.030">38</option>
                    <option value="0.015">39</option>
                    <option value="0.030">40</option>
                    <option value="0.015">41</option>
                    <option value="0.030">42</option>
                    <option value="0.015">43</option>
                    <option value="0.030">44</option>
                    <option value="0.015">45</option>
                    <option value="0.030">46</option>
                    <option value="0.015">47</option>
                    <option value="0.030">48</option>
                    <option value="0.015">49</option>
                    <option value="0.030">50</option>
                    <option value="0.015">51</option>
                    <option value="0.030">52</option>
                    <option value="0.015">53</option>
                    <option value="0.030">54</option>
                    <option value="0.015">55</option>
                    <option value="0.030">56</option>
                    <option value="0.030">57</option>
                    <option value="0.030">58</option>
                    <option value="0.030">59</option>
				</select>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-xs btn-primary" onclick="reBroadcastSubmit()">Rebroadcast</button>
      </div>
    </div>
  </div>
</div>

{{--success of rebroadcast modal--}}
<div class="modal fade" id="orderBroadcastSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">ReBroadcast Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="bf-color">Successfully Rebroadcast order</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

{{--pre braodcast --}}
<div class="modal fade" id="exclusive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">exclusive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="bf-color">Only broadcast <span class="CR-num"></span> order to:</h5>
                <form action="" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="emailInput">Select Joey</label>
                        <select multiple="multiple" id="multi_joeys" name="joey[]"
                                class="select2 joeys joey_select2_multiple form-control form-control-lg">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-xs btn-primary" onclick="preBroadcastOrderToMultiJoeys()">Submit</button>
            </div>
        </div>
    </div>
</div>

{{--Cancel order --}}
<div class="modal fade" id="cancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="needs-validation" novalidate>
                    <input type="hidden" name="status_id" id="status_id">
                    <div class="form-group">
                        <label>Select reason to cancel your order</label>
                        <select class="form-control form-control-lg" name="reason" id="reason">
                            <option value="">Select Reason</option>
                            <option value="Cancel Order due to Associate Delay">Cancel Order due to Associate Delay</option>
                            <option value="Cancel Order due to poor weather">Cancel Order due to poor weather</option>
                            <option value="Cancel Order due to order not available at pick up">Cancel Order due to order not available at pick up</option>
                            <option value="Cancel Order due to Duplicate">Cancel Order due to Duplicate</option>
                            <option value="Cancel Order due to Joey Unavailable">Cancel Order due to Joey Unavailable</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-xs btn-primary" onclick="sprintCancel()">Submit</button>
            </div>
        </div>
    </div>
</div>

{{--Detail--}}
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sprint-order-detail-cr-num">Sprint Tasks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <div class="order">
			<h5 class="mb-5" id="cr-pickup"></h5>
			<p><a href="#" class="btn btn-primary btn-xs hide">Notify Contact</a></p>
			<div class="divider sm"></div>
			<p id="currentStatus"></p>
			<div class="attr-list2">
				<div class="attr">
					<div class="lbl">PIN:</div>
					<div class="value" id="pickup-pin"></div>
				</div>
			</div>

			<h6>Description:</h6>
			<div class="attr-list2">
				<div class="row">
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Name:</div>
							<div class="value" id="pickup-name"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Phone:</div>
							<div class="value" id="pickup-phone"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Email:</div>
							<div class="value" id="pickup-email"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Address:</div>
							<div class="value" id="pickup-address"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Postal_code:</div>
							<div class="value" id="pickup-postal_code"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Buzzer:</div>
							<div class="value">When you arrive at the store, park in one of the designated PC Express spots and call us at 416-588-5184</div>
						</div>
					</div>
				</div>
			</div>
			<div class="divider"></div>
			<div class="form-row align-items-end">
				<div class="form-group no-min-h nomargin col-6">
					<div class="lbl">Suite:</div>
					<input type="date" class="form-control">
				</div>
				<div class="col-sm-6">
					<button class="btn btn-basecolor1 btn-xs">Mark At Pickup</button>
				</div>
			</div>

			<div class="divider"></div>

			<div class="attr-list2">
				<div class="attr">
					<div class="lbl">Confirm pickup:</div>
					<div class="value">
						<a href="#" class="btn btn-basecolor1 btn-xs btn-border mt-10">Confirmed</a>
					</div>
				</div>
				<div class="divider"></div>
				<h5 id="pickup-merchant-order-num"><span class="bf-color">Merchant Order Number:</span> </h5>
				<div class="attr">
					<div class="lbl">End Time:</div>
					<div class="value">13:00</div>
				</div>
			</div>
		  </div>

		  <div class="divider thick"></div>

          <div class="order">
			<h5 class="mb-5" id="cr-dropoff"></h5>
			<p><a href="#" class="btn btn-primary btn-xs hide">Notify Contact</a></p>
			<div class="divider sm"></div>
			<div class="attr-list2">
				<div class="attr">
					<div class="lbl">PIN:</div>
					<div class="value" id="dropoff-pin"></div>
				</div>
			</div>

			<h6>Description:</h6>

			<div class="attr-list2">
				<div class="row">
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Name:</div>
							<div class="value" id="dropoff-name"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Phone:</div>
							<div class="value" id="dropoff-phone"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Email:</div>
							<div class="value" id="dropoff-email"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Address:</div>
							<div class="value" id="dropoff-address"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Postal_code:</div>
							<div class="value" id="dropoff-postal_code"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<div class="attr">
							<div class="lbl">Buzzer:</div>
							<div class="value">When you arrive at the store, park in one of the designated PC Express spots and call us at 416-588-5184</div>
						</div>
					</div>
				</div>
			</div>
			<div class="divider"></div>
			<div class="form-row align-items-end">
				<div class="form-group no-min-h nomargin col-6">
					<div class="lbl">Suite:</div>
					<input type="date" class="form-control">
				</div>
				<div class="col-sm-6">
					<button class="btn btn-basecolor1 btn-xs">Mark At Pickup</button>
				</div>
			</div>

			<div class="divider"></div>

			<div class="attr-list2">
				<div class="attr">
					<div class="lbl">Confirm pickup:</div>
					<div class="value">
						<a href="#" class="btn btn-basecolor1 btn-xs btn-border mt-10">Confirmed</a>
					</div>
				</div>
				<div class="divider"></div>
				<h5 id="dropoff-merchant-order-num"><span class="bf-color">Merchant Order Number:</span> </h5>
				<div class="attr">
					<div class="lbl">End Time:</div>
					<div class="value">13:00</div>
				</div>
			</div>
		  </div>

		  <div class="divider thick"></div>

			<div class=table-responsive>
				<h5>Status History</h5>
				<table class="table tbl-responsive table-striped mb_last_row_hightlight">
					<thead>
						<tr>
							<th>Status</th>
							<th>Delivery success</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Draft</td>
							<td>20:45:03 08-25</td>
						</tr>
						<tr>
							<td>Scheduled order</t
							d><td>20:45:08 08-25</td>
						</tr>
						<tr>
							<td>Looking for a Joey</td><td>20:29:10 08-26</td>
						</tr>
						<tr>
							<td>Order accepted by Joey</td><td>21:37:58 08-26</td>
						</tr>
						<tr>
							<td>Joey is at pickup location</td><td>21:47:02 08-26</td>
						</tr>
						<tr>
							<td>Order is with Joey</td><td>21:58:27 08-26</td>
						</tr>
						<tr>
							<td>Joey is at dropoff location</td><td>23:19:42 08-26</td>
						</tr>
						<tr>
							<td>Successfully hand delivered</td><td>23:21:26 08-26</td>
						</tr>
						<tr>
							<td>Order is with Joey (From 650 Dupont Street)</td><td>21:58:27 08-26</td>
						</tr>
						<tr>
						<td>Delivery success (To 124 Lansdowne Ave)</td><td>23:21:48 08-26</td></tr>
					</tbody>
				</table>
			</div>
    	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
{{--        <button type="button" class="btn btn-xs btn-primary">Transfer</button>--}}
      </div>
    </div>
  </div>
</div>

{{--map--}}
<div class="modal fade" id="map" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">map</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="mapDoom" style="height: 400px"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
{{--        <button type="button" class="btn btn-xs btn-primary">Transfer</button>--}}
      </div>
    </div>
  </div>
</div>

{{--flags--}}
<div class="modal fade" id="flag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">flag</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Comming Soon
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
{{--        <button type="button" class="btn btn-xs btn-primary">Transfer</button>--}}
      </div>
    </div>
  </div>
</div>

{{--Order Note--}}
<div class="modal fade" id="notes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Note for CR-7868690 to:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="" class="needs-validation" novalidate>
			<div class="form-group">
				<label for="emailInput">Write your note:</label>
				<textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-xs btn-primary" onclick="orderNoteSubmit()">Submit</button>
      </div>
    </div>
  </div>
</div>

{{--<div class="modal fade" id="assignCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--  <div class="modal-dialog">--}}
{{--    <div class="modal-content">--}}
{{--      <div class="modal-header">--}}
{{--        <h5 class="modal-title" id="exampleModalLabel">Assign Code</h5>--}}
{{--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--          <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--      </div>--}}
{{--      <div class="modal-body">--}}
{{--	  	<form action="" class="needs-validation" novalidate>--}}
{{--			  <div class="button-group">--}}
{{--				  <a href="#" class="btn btn-xs btn-primary btn-border">Code Num</a>--}}
{{--				  <a href="#" class="btn btn-xs btn-primary btn-border">Code</a>--}}
{{--				  <a href="#" class="btn btn-xs btn-primary btn-border">Marked At</a>--}}
{{--			  </div>--}}
{{--			<div class="form-group">--}}
{{--				<label for="emailInput">Mark Code for <span>7868743</span></label>--}}
{{--				<select class="form-control form-control-lg">--}}
{{--					<option value="15542">Sidhu</option>--}}
{{--					<option value="29151">AABH TRADERS INC </option>--}}
{{--					<option value="14615">Aadam Abedeen</option>--}}
{{--				</select>--}}
{{--			</div>--}}
{{--		</form>--}}
{{--      </div>--}}
{{--      <div class="modal-footer">--}}
{{--        <button type="button" class="btn btn-xs btn-primary btn-border" data-dismiss="modal">Cancel</button>--}}
{{--        <button type="button" class="btn btn-xs btn-primary">Mark</button>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}

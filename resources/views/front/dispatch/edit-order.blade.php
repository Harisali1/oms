@extends('front.layouts.Dispatch-layout')

@section('page-title',"Order Edit")

@section('css')
    <style>
        .email-disabled {
            background-color: lightgray !important;
        }
    </style>
@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
{{--                @include('front.sub-admin.sub-admin-sidebar')--}}
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-12">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Order Edit ({{'CR-'. $sprint->id }}) </h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('order.sprint.update', $sprint) }}"
                                  class="form-horizontal" role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Status</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $status }}" id="status"
                                                       name="status" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Date/Time</label>
                                                @php
                                                    $tasks = $sprint->SprintTasks;
                                                    $dueTime = date("Y-m-d H:i:s", substr($tasks[0]->due_time, 0, 10));
                                                @endphp
                                                <input type="datetime-local" class="form-control form-control-lg"
                                                       placeholder="Please Enter Due Date" value="{{ $dueTime }}" id="due_time"
                                                       name="due_time">
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="ord">Order Ready Date</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Order Ready Date" value="{{ $dueTime }}" id="ord"
                                                       name="ord" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="joey_accept_date">Joey Accept Date</label>
                                                <input type="date" class="form-control form-control-lg"
                                                       placeholder="Joey Accept Date" value="{{ $dueTime }}" id="joey_accept_date"
                                                       name="joey_accept_date" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="completion_date">Completion Date</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $dueTime }}" id="completion_date"
                                                       name="completion_date" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="joey">Joey</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Joey"
                                                       value="{{ optional($sprint->joeys)->first_name ?? 'N/A' }}"
                                                       id="joey"
                                                       name="joey" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="joey_shift">Joey Shifts</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Joey Shift"
                                                       value="{{ optional($sprint->joeys)->first_name ?? 'N/A' }}"
                                                       id="joey_shift"
                                                       name="joey_shift" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="vehicle_id">Vehicle</label>
                                                <select name="vehicle_id" id="vehicle_id"
                                                        class="form-control form-control-lg role-type" required>
                                                    <option value="" disabled>Select an option</option>
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{$vehicle->id}}"
                                                                {{ ($vehicle->id == $sprint->vehicle_id) ? 'selected' : '' }}>
                                                            {{$vehicle->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="distance">Distance</label>
                                                @php
                                                    $distanceRound = round($sprint->distance / 1000, 2);
                                                    $distance = number_format($distanceRound, 2) . ' km';
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Distance" value="{{ $distance }}" id="distance"
                                                       name="distance" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Distance Charges</label>
                                                @php
                                                    $distanceCharges = round($sprint->distance_charges / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $distanceCharges }}" id="status"
                                                       name="status" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Task Total</label>
                                                @php
                                                    $taskTotal = round($sprint->task_total / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $taskTotal }}" id="status"
                                                       name="status" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Tax</label>
                                                @php
                                                    $tax = round($sprint->tax / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="tip">Tip</label>
                                                @php
                                                    $tip = round($sprint->tip / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Tip" value="{{ $tip }}" id="tip"
                                                       name="tip">
                                            </div>
                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Customer Credit</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Total</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Grand Total</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Customer Charges</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Merchant Charges</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Joey Pay</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">Joey Tax Pay</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>

                                            <div class="form-group col-12 col-md-3 no-min-h">
                                                <label for="status">JoeyCo Pay</label>
                                                @php
                                                    $tax = round($sprint->creadit_amount / 1000, 2);
                                                @endphp
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Status" value="{{ $tax }}" id="status"
                                                       name="status" readonly>
                                            </div>
                                            {{--                                            <div class="form-group col-12 col-md-6 no-min-h">--}}
                                            {{--                                                <label for="email">Email</label>--}}
                                            {{--                                                <input type="email" class="form-control form-control-lg email-disabled"--}}
                                            {{--                                                       placeholder="test@domain.com"--}}
                                            {{--                                                       value="{{ old('email', $sub_admin->email) }}" id="email"--}}
                                            {{--                                                       name="email" readonly>--}}
                                            {{--                                                @if ($errors->has('email'))--}}
                                            {{--                                                    <span class="help-block">--}}
                                            {{--                                                        <strong>{{ $errors->first('email') }}</strong>--}}
                                            {{--                                                    </span>--}}
                                            {{--                                                @endif--}}
                                            {{--                                            </div>--}}

                                            {{--                                            <div class="form-group col-12 col-md-6 no-min-h">--}}
                                            {{--                                                <label for="phone">Phone</label>--}}
                                            {{--                                                <input type="text" name="phone" maxlength="32"--}}
                                            {{--                                                       value="{{ old('phone', $sub_admin->phone) }}"--}}
                                            {{--                                                       class="form-control phone_us" required/>--}}
                                            {{--                                                @if ($errors->has('phone'))--}}
                                            {{--                                                    <span class="help-block">--}}
                                            {{--                                                        <strong>{{ $errors->first('phone') }}</strong>--}}
                                            {{--                                                    </span>--}}
                                            {{--                                                @endif--}}
                                            {{--                                                <div class="invalid-feedback">--}}
                                            {{--                                                    Please provide a phone.--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            {{--                                            <div class="form-group col-12 col-md-6 no-min-h">--}}
                                            {{--                                                <label for="address">Role Type</label>--}}
                                            {{--                                                <select name="role" id="" class="form-control form-control-lg role-type"--}}
                                            {{--                                                        required>--}}
                                            {{--                                                    <option value="" disabled selected>Select an option</option>--}}
                                            {{--                                                    @foreach($role_list as $role)--}}
                                            {{--                                                        <option value="{{$role->id}}">{{$role->display_name}}</option>--}}
                                            {{--                                                    @endforeach--}}
                                            {{--                                                </select>--}}
                                            {{--                                                @if ($errors->has('role'))--}}
                                            {{--                                                    <span class="help-block">--}}
                                            {{--                                                        <strong>{{ $errors->first('role') }}</strong>--}}
                                            {{--                                                    </span>--}}
                                            {{--                                                @endif--}}
                                            {{--                                                <div class="invalid-feedback">--}}
                                            {{--                                                    Please provide a role.--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            {{--                                            <div class="form-group col-12 col-md-6 no-min-h">--}}
                                            {{--                                                <label for="password">Password</label>--}}
                                            {{--                                                <input type="password" class="form-control form-control-lg"--}}
                                            {{--                                                       placeholder="" id="password" name="password">--}}
                                            {{--                                                @if ($errors->has('password'))--}}
                                            {{--                                                    <span class="help-block">--}}
                                            {{--                                                        <strong>{{ $errors->first('password') }}</strong>--}}
                                            {{--                                                    </span>--}}
                                            {{--                                                @endif--}}
                                            {{--                                            </div>--}}

                                            {{--                                            <div class="form-group col-12 col-md-6 no-min-h">--}}
                                            {{--                                                <label for="upload_picture">Upload Picture</label>--}}
                                            {{--                                                {{ Form::file('upload_file', ['class' => 'form-control ']) }}--}}
                                            {{--                                                <img style="max-width: 350px;height: 150px;margin-top: 4px"--}}
                                            {{--                                                     onClick="preview(this);" src="{{$sub_admin->profile_picture}}"/>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update</button>
{{--                                    <a href="{{route('sub-admin.index')}}">--}}
{{--                                        <button type="button" class="btn btn-primary"--}}
{{--                                                style="background-color: #bad709!important;">Cancel--}}
{{--                                        </button>--}}
{{--                                    </a>--}}
                                </div>
                            </form>
                        </div>

                        @foreach($sprint->SprintTasks as $task)

                            <div class="inner">
                                <div class="content_header_wrap">
                                    <div class="hgroup divider-after left">
                                        @if($task->type == 'pickup')
                                            <h1 class="lh-10">{{'CR-'. $sprint->id . '-A' }} </h1>
                                        @else
                                            <h1 class="lh-10">{{'CR-'. $sprint->id . '-1' }} </h1>
                                        @endif
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('order.sprint.task.update', $task->id) }}"
                                      class="form-horizontal" role="form" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <section class="form-section pb-0">
                                        <div class="section-inner">
                                            <div class="form-row">
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="pin">Pin Code</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="Pin Code" value="{{ $task->pin }}" id="pin"
                                                           name="pin">
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="status">Payment Type</label>
                                                    @php
                                                        $tasks = $sprint->SprintTasks;
                                                        $dueTime = date("Y-m-d H:i:s", substr($tasks[0]->due_time, 0, 10));
                                                    @endphp
                                                    @foreach($paymentOptions as $paymentOption)
                                                        @php
                                                            $selectedPaymentOption = empty($task->payment_type) ? 'none' : $task->payment_type;
                                                        @endphp
                                                        <input type="checkbox"
                                                               {{ ($selectedPaymentOption == $paymentOption) ? 'checked' : '' }}
                                                               value="{{ $paymentOption }}" id="payment_type"
                                                               name="payment_type"> {{ $paymentOption }}
                                                    @endforeach
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="payment_amount">Payment Amount</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="payment amount" value="{{ $task->payment_amount }}" id="payment_amount"
                                                           name="payment_amount">
                                                </div>
                                                <div class="form-group col-12 no-min-h">
                                                    <span>Location: (Updating this will affect distance if it was wrong.)</span>
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="Address">Address</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="address" value="{{ optional($task->location)->address ?? 'N/A' }}" id="address"
                                                           name="address">
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="postal_code">Postal Code</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="postal code" value="{{  optional($task->location)->postal_code ?? 'N/A' }}" id="postal_code"
                                                           name="postal_code">
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="buzzer">buzzer</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="Buzzer"
                                                           value="{{ optional($sprint->joeys)->first_name ?? 'N/A' }}"
                                                           id="buzzer"
                                                           name="buzzer">
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="status">Suite</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="Status"
                                                           value="{{ optional($sprint->joeys)->first_name ?? 'N/A' }}"
                                                           id="status"
                                                           name="status">
                                                </div>
                                                <div class="form-group col-12 no-min-h">
                                                    <span>Contact:</span>
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="Name" value="{{ optional($task->contact)->name ?? 'N/A' }}" id="name"
                                                           name="name">
                                                </div>

                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="phone" value="{{ optional($task->contact)->phone ?? 'N/A' }}"
                                                           id="phone" name="phone">
                                                </div>
                                                <div class="form-group col-12 col-md-3 no-min-h">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           placeholder="Enter Email" value="{{ optional($task->contact)->email ?? 'N/A' }}" id="email"
                                                           name="email">
                                                </div>

                                            </div>
                                        </div>
                                    </section>
                                    <div class="content_footer_wrap">
                                        <button type="submit" class="btn btn-primary submitButton">Update</button>
{{--                                        <a href="{{route('sub-admin.index')}}">--}}
{{--                                            <button type="button" class="btn btn-primary"--}}
{{--                                                    style="background-color: #bad709!important;">Cancel--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </aside>
                </div>
            </div>
            <!-- Content Area - [/end] -->
        </div>
    </main>
@stop

@section('js')

@stop

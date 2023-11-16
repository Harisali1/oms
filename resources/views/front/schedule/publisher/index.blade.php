@extends('front.layouts.Dispatch-layout')

@section('page-title',"Today Schedule")

@section('css')
    <style>
        /*my css*/
        .img-thumbnail {
            width: 80px;
            height: 60px;
        }

        .date-search {
            padding-top: 25px;
            padding-bottom: 20px;
        }

        .search-btn {
            padding: 15px !important;
        }
    </style>


@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
        @include('front.partials.errors')
        <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                @include('front.schedule.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Schedule Publisher</h1>
                                </div>
                            </div>

                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-12">
                                                <form action="{{ route('shift.publisher.search') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            @php
                                                                if(empty($startDate) && empty($endDate)){
                                                                    $start_date = date('m/d/Y');
                                                                    $date = strtotime($start_date);
                                                                    $date = strtotime("+1 day", $date);
                                                                    $end_date = date('m/d/Y', $date);
                                                                }else{

                                                                    $start = strtotime($startDate);
                                                                    $start = strtotime("0 day", $start);
                                                                    $start_date = date('m/d/Y', $start);

                                                                    $end = strtotime($endDate);
                                                                    $end = strtotime("0 day", $end);
                                                                    $end_date = date('m/d/Y', $end);
                                                                }
                                                            @endphp


                                                            <input type="text" class="form-control date-search"
                                                                   name="daterange" value="{{ $start_date }} - {{ $end_date }}"
                                                                   autocomplete="off">
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <select name="shift_id" id="shift_id"
                                                                    class="form-control form-control-lg">
                                                                <option value="" disabled selected>Select Schedule
                                                                </option>
                                                                @foreach($shifts as $shift)
                                                                    <option value="{{$shift->id}}"
                                                                            {{ (!empty($shiftId) && $shiftId == $shift->id) ? 'selected' : null }}>
                                                                        SH- {{$shift->id}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 col-sm-12 mb-2">
                                                            <select name="zone_id" id="zone_id"
                                                                    class="form-control form-control-lg">
                                                                <option value="" disabled selected>Select Zones
                                                                </option>
                                                                @foreach($allZones as $zone)
                                                                    <option value="{{$zone->id}}" {{ (!empty($zoneId) && $zoneId == $zone->id) ? 'selected' : null }}>{{$zone->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12 mb-2">
                                                            <div class="row">
                                                                <div class="col-md-6 p-3">
                                                                    <input type="radio" name="is_display" checked
                                                                           id="is_display" value="1">Enabled
                                                                    <input type="radio" name="is_display"
                                                                           id="is_display" value="0">Disabled
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button type="submit" title="Search"
                                                                            class="col-md-12 search-btn btn btn-basecolor1 btn-mb">
                                                                        Search
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="cs_pagination">
                                                    <ul class="no-list d-flex">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button style="margin-bottom: 10px" class="btn btn-primary enabled_disabled_all"
                                            data-type="disabled"
                                            data-url="{{ route('shift.publisher.enabled.disabled') }}">Disabled
                                    </button>
                                    <button style="margin-bottom: 10px" class="btn btn-primary enabled_disabled_all"
                                            data-type="enabled"
                                            data-url="{{ route('shift.publisher.enabled.disabled') }}">Enabled
                                    </button>

                                    <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                        <thead>
                                        <tr>
                                            <th class="valing-middle"><input type="checkbox" id="master"></th>
                                            <th class="valing-middle">ID</th>
                                            <th class="valing-middle">Schedule ID</th>
                                            <th class="valing-middle">Zones</th>
                                            <th class="valing-middle">Capacity</th>
                                            <th class="valing-middle">Vehicle</th>
                                            <th class="valing-middle">Scheduled Start Time</th>
                                            <th class="valing-middle">Scheduled End Time</th>
                                            <th class="valing-middle">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(count($zoneSchedules) > 0)
                                            @foreach($zoneSchedules as $key => $schedule)
                                                <tr id="tr_{{$schedule->id}}">

                                                    <td class="valing-middle">
                                                        <input type="checkbox" class="sub_chk"
                                                               data-id="{{$schedule->id}}">
                                                    </td>
                                                    <td class="valing-middle">{{ $key+1 }}</td>
                                                    <td class="valing-middle">
                                                        <span class="bold basecolor1">SH-{{$schedule->id}}</span>
                                                    </td>
                                                    <td class="valing-middle">{{ optional($schedule->zone)->name ?? 'N/A' }}</td>
                                                    <td class="valing-middle">{{ $schedule->capacity }}</td>
                                                    <td class="valing-middle">{{ optional($schedule->vehicle)->name ?? 'N/A' }}</td>
                                                    <td class="valing-middle">{{ $schedule->start_time }}</td>
                                                    <td class="valing-middle">{{ $schedule->end_time }}</td>


                                                    <td class="semibold valing-middle">
                                                        @if(can_access_route(['shift.publisher.display'],$userPermissoins))
                                                            <a class="btn btn-xs" type="button" data-toggle="modal"
                                                               data-target="#statusModal{{$schedule->id }}">
                                                                @if($schedule->is_display == 1)
                                                                    <span class="btn btn-basecolor1 btn-border btn-mb">Hide</span>
                                                                @else
                                                                    <span class="btn btn-basecolor1 btn-border btn-mb">Display</span>
                                                                @endif
                                                            </a>
                                                            <div id="statusModal{{ $schedule->id}}"
                                                                 class="modal fade"
                                                                 role="dialog">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            <h4 class="modal-title text-left">Confirm Status?</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Are you sure you want to change the
                                                                                status?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-default btn-flat pull-left"
                                                                                    data-dismiss="modal">Close
                                                                            </button>
                                                                            @php
                                                                                foreach($schedule->joeySchedule as $joey){
                                                                            @endphp
                                                                            {!! Form::model($schedule, ['method' => 'get',  'url' => 'shift/publisher/display/'.$schedule->id.'/joey_id/'.$joey->joey_id, 'class' =>'form-inline form-edit']) !!}
                                                                            {!! Form::hidden('id', $schedule->id) !!}
                                                                            {!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}
                                                                            {!! Form::close() !!}
                                                                            @php
                                                                                }
                                                                            @endphp

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{--<a href="{{ route('shift.publisher.display',$schedule->id) }}"--}}
                                                        {{--class="btn btn-danger btn-sm"--}}
                                                        {{--data-tr="tr_{{$schedule->id}}"--}}
                                                        {{--data-toggle="confirmation"--}}
                                                        {{--data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"--}}
                                                        {{--data-btn-ok-class="btn btn-sm btn-danger"--}}
                                                        {{--data-btn-cancel-label="Cancel"--}}
                                                        {{--data-btn-cancel-icon="fa fa-chevron-circle-left"--}}
                                                        {{--data-btn-cancel-class="btn btn-sm btn-default"--}}
                                                        {{--data-title="Are you sure you want to delete ?"--}}
                                                        {{--data-placement="left" data-singleton="true">--}}
                                                        {{--Delete--}}
                                                        {{--</a>--}}

                                                        <a class="btn btn-xs" type="button" data-toggle="modal"
                                                           data-target="#detailModal{{$schedule->id }}">
                                                            <span class="btn btn-basecolor1 btn-border btn-mb">Detail</span>
                                                        </a>
                                                        <div id="detailModal{{ $schedule->id}}"
                                                             class="modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header text-right"
                                                                         style="display: block">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <h4 class="modal-title text-left">Shift
                                                                            ID: {{ $schedule->id }}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Vehicle:
                                                                            <span>{{ optional($schedule->vehicle)->name ?? 'N/A' }}</span>
                                                                        </p>
                                                                        <p>Capacity:
                                                                            <span>{{ $schedule->capacity }}</span></p>
                                                                        <p>Occupancy:
                                                                            <span>{{ $schedule->occupancy }}</span></p>
                                                                        <p>Joey:
                                                                            <span>{{ optional($schedule->joeySchedule)->joey->display_name ?? 'N/A' }}</span>
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-default btn-flat pull-left"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>Record Not Found</td>
                                            </tr>
                                            {{--<div class="d-flex justify-content-right">--}}

                                            {{--</div>--}}
                                        @endif
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {{--{!! $zoneSchedules->links() !!}--}}
                                    </div>
                                </div>
                            </section>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
    <!-- Content Area - [/end] -->
@stop

@section('js')
    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                autoUpdateInput: true,
                opens: 'right'
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD')+1);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#master').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                } else {
                    $(".sub_chk").prop('checked', false);
                }
            });

            $('.enabled_disabled_all').on('click', function (e) {

                var allVals = [];
                $(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    alert("Please select at least one checkbox.");
                } else {
                    var type = $(this).data('type');

                    if (type == 'enabled') {
                        var check = confirm("Are you sure you want to enabled selected schedules..?");
                    }

                    if (type == 'disabled') {
                        var check = confirm("Are you sure you want to disabled selected schedules");
                    }

                    if (check == true) {

                        var join_selected_values = allVals.join(",");

                        $.ajax({
                            url: $(this).data('url'),
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {ids: join_selected_values, type: type},
                            success: function (data) {
                                if (data['success']) {
                                    if (type == 'disabled') {
                                        $(".sub_chk:checked").each(function () {
                                            $(this).parents("tr").remove();
                                        });
                                    }
                                    alert(data['success']);
                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });

                        $.each(allVals, function (index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
                }
            });
        });
    </script>
@stop

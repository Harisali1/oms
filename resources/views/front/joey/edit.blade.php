@extends('front.layouts.Dispatch-layout')

@section('page-title',"Zone Schedule Edit")

@section('css')
    <style>
        /*my css*/
        .joey-start-time {
            padding-left: 9px;
            padding-top: 1px !important;
            padding-bottom: 1px !important;
            padding-right: 10px;
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
                @include('front.schedule.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Joey Zone Schedule Edit</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('schedule.update', $joeyZoneSchedule) }}"
                                  class="form-horizontal" role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Shift Id</label>
                                                <select name="zone_id" id="zone_id"
                                                        class="form-control form-control-lg" required>
                                                    <option value="" disabled selected>Select an option
                                                    </option>
                                                    @foreach($zones as $zone)
                                                        <option value="{{$zone->id}}"
                                                                {{ ($zone->id == $joeyZoneSchedule->schedule->zone_id) ? 'selected' : null  }}>
                                                            {{$zone->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Joey</label>
                                                <select name="joey_id" id="joey_id"
                                                        class="form-control form-control-lg" required>
                                                    <option value="" disabled selected>Select an option
                                                    </option>
                                                    @foreach($joeys as $joey)
                                                        <option value="{{$joey->id}}"
                                                                {{ ($joey->id == $joeyZoneSchedule->joey->id) ? 'selected' : null  }}>
                                                            {{$joey->display_name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Schedule Start Time</label>
                                                <input type="text" name="schedule_start_time"
                                                       id="schedule_start_time"
                                                       value="{{ $joeyZoneSchedule->schedule->start_time }}"
                                                       class="form-control form-control-lg">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Schedule End Time</label>
                                                <input type="text" name="schedule_end_time"
                                                       id="schedule_end_time"
                                                       value="{{ $joeyZoneSchedule->schedule->end_time }}"
                                                       class="form-control form-control-lg">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="start_time">Joey Start Time</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="joey_start_time" name="joey_start_time"
                                                       value="{{ $joeyZoneSchedule->start_time }}">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="start_time">Joey End Time</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="joey_end_time" name="joey_end_time"
                                                       value="{{ $joeyZoneSchedule->end_time }}">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="capacity">Capacity</label>
                                                <input type="number" class="form-control form-control-lg"
                                                       id="capacity" name="capacity"
                                                       value="{{ $joeyZoneSchedule->schedule->capacity }}">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="wage">Wages</label>
                                                <input type="number" class="form-control form-control-lg"
                                                       id="wage" name="wage"
                                                       value="{{ $joeyZoneSchedule->wage }}">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update Delivery Type
                                    </button>
                                </div>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
            <!-- Content Area - [/end] -->
        </div>
    </main>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $("#start_time_empty_btn").click(function(){
                $("#start_time_not_empty").hide();
                $("#start_time_empty").show();
            });
            $("#end_time_empty_btn").click(function(){
                $("#end_time_not_empty").hide();
                $("#end_time_empty").show();
            });
        });
    </script>
@stop

@extends('front.layouts.Dispatch-layout')

@section('page-title',"Create Zone Schedule")

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
                                    <h1 class="lh-10">Create Joey Zone Schedule</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('schedule.store') }}" class="form-horizontal" role="form" enctype="multipart/form-data">
                                @csrf
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
                                                        <option value="{{$zone->id}}">{{$zone->name}}</option>
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
                                                        <option value="{{$joey->id}}">{{$joey->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Schedule Start Time</label>
                                                <input type="datetime-local" name="schedule_start_time"
                                                       id="schedule_start_time"
                                                       class="form-control form-control-lg">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Schedule End Time</label>
                                                <input type="datetime-local" name="schedule_end_time"
                                                       id="schedule_end_time"
                                                       class="form-control form-control-lg">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="start_time">Joey Start Time</label>
                                                <input type="datetime-local" class="form-control form-control-lg"
                                                       id="joey_start_time" name="joey_start_time">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="start_time">Joey End Time</label>
                                                <input type="datetime-local" class="form-control form-control-lg"
                                                       id="joey_end_time" name="joey_end_time">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="capacity">Capacity</label>
                                                <input type="number" class="form-control form-control-lg"
                                                       id="capacity" name="capacity">
                                            </div>
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="wage">Wages</label>
                                                <input type="number" class="form-control form-control-lg"
                                                       id="wage" name="wage">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Create Shift</button>
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
    <script></script>
@stop

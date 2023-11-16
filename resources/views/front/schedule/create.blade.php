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
                                    <h1 class="lh-10">Add Schedule</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('schedule.store') }}" class="form-horizontal"
                                  role="form" enctype="multipart/form-data">
                                @csrf
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label>Zones *</label>
                                                <select name="zone_id" id="zone_id" style="padding: 10px;"
                                                        class="form-control form-control-lg @error('zone_id') is-invalid @enderror">
                                                    <option value="" disabled selected>Select an option
                                                    </option>
                                                    @foreach($zones as $zone)
                                                        <option value="{{$zone->id}}" {{ (old('zone_id') == $zone->id) ? 'selected' : '' }}>{{$zone->name}}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('zone_id'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('zone_id') }}</p>
								                    </span>
                                                @endif
                                        </div>
                                        <div class="form-group col-12 col-md-4 no-min-h">
                                            <label>Joey</label>
                                            <select name="joey_id" id="joey_id"
                                                    class="form-control form-control-lg" style="padding: 10px;">
                                                <option value="" disabled selected>Select an option
                                                </option>
                                                @foreach($joeys as $joey)
                                                    <option value="{{$joey->id}}" {{ (old('joey_id') == $joey->id) ? 'selected' : '' }}>{{$joey->display_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-4 no-min-h">
                                            <label>Schedule Start Time *</label>
                                            <input type="datetime-local" name="start_time"
                                                   id="start_time"
                                                   class="form-control form-control-lg" value="{{ old('start_time') }}">
                                            @if ($errors->has('start_time'))
                                                <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('start_time') }}</p>
								                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-12 col-md-4 no-min-h">
                                            <label>Schedule End Time *</label>
                                            <input type="datetime-local" name="end_time"
                                                   id="end_time"
                                                   class="form-control form-control-lg" value="{{ old('end_time') }}">
                                            @if ($errors->has('end_time'))
                                                <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('end_time') }}</p>
								                    </span>
                                            @endif
                                        </div>
                                        {{--<div class="form-group col-12 col-md-4 no-min-h">--}}
                                        {{--<label for="start_time">Joey Start Time</label>--}}
                                        {{--<input type="datetime-local" class="form-control form-control-lg"--}}
                                        {{--id="joey_start_time" name="joey_start_time">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group col-12 col-md-4 no-min-h">--}}
                                        {{--<label for="start_time">Joey End Time</label>--}}
                                        {{--<input type="datetime-local" class="form-control form-control-lg"--}}
                                        {{--id="joey_end_time" name="joey_end_time">--}}
                                        {{--</div>--}}
                                        <div class="form-group col-12 col-md-4 no-min-h">
                                            <label for="capacity">Capacity *</label>
                                            <input type="number" class="form-control form-control-lg"
                                                   id="capacity" name="capacity" value="{{ old('capacity') }}"
                                                    placeholder="Enter Capacity">
                                            @if ($errors->has('capacity'))
                                                <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('capacity') }}</p>
								                    </span>
                                            @endif
                                        </div>
                                        {{--<div class="form-group col-12 col-md-4 no-min-h">--}}
                                        {{--<label for="wage">Wages</label>--}}
                                        {{--<input type="number" class="form-control form-control-lg"--}}
                                        {{--id="wage" name="wage">--}}
                                        {{--</div>--}}
                                    </div>
                        </div>
                        </section>
                        <div class="content_footer_wrap">
                            <button type="submit" class="btn btn-primary submitButton">Add</button>
                            <a href="{{route('schedule.index')}}"><button type="button" class="btn btn-primary" style="background-color: #bad709!important;">Cancel</button></a>
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

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

            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                @include('front.schedule.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            {{--<div class="content_header_wrap">--}}
                            {{--<div class="hgroup divider-after left">--}}
                            {{--<h1 class="lh-10">Delivery Type List</h1>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Schedule List</h1>
                                </div>
                            </div>
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>
                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-md-12 col-sm-12">
                                                <form action="{{ route('schedule.search') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <input type="date" name="date" id="date"
                                                                   class="form-control date-search"
                                                                   placeholder="Select Date" value="{{ $date }}">
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <select name="zone_id" id="zone_id"
                                                                    class="form-control form-control-lg">
                                                                <option value="" disabled selected>Select an option
                                                                </option>
                                                                @foreach($allZones as $zone)
                                                                    <option
                                                                        value="{{$zone->id}}" {{ (!empty($zoneId) && $zoneId == $zone->id) ? 'selected' : null }}>{{$zone->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 col-sm-12 mb-2">
                                                            <button type="submit" title="Search"
                                                                    class="col-md-12 col-sm-12 search-btn btn btn-basecolor1 btn-mb">
                                                                Search
                                                            </button>
                                                        </div>
                                                        @if(can_access_route(['schedule.create'],$userPermissoins))
                                                            <div class="col-md-3 col-sm-12 mb-2">
                                                                <a href="{{ route('schedule.create') }}">
                                                                    <button type="button" title="Create Shift"
                                                                            class="col-md-12 col-sm-12 search-btn btn btn-basecolor1 btn-mb">
                                                                        Add New Schedule
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </form>
                                                <div class="cs_pagination">
                                                    <ul class="no-list d-flex">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(count($data) > 0)

                                        @foreach($data as $zoneSchedule)
                                            <hr>
                                            <h3>{{ $zoneSchedule['name']}}</h3>
                                            <div class="custom_col">
                                                <table
                                                    class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                                    <thead>
                                                    <tr>
                                                        <th width="8%" scope="col" class="valing-middle">Zone ID</th>
                                                        <th width="8%" scope="col" class="valing-middle">Schedule ID</th>
                                                        <th width="10%" scope="col" class="valing-middle">Joey ID</th>
                                                        <th width="12%" scope="col" class="valing-middle">Joey</th>
                                                        <th width="20%" scope="col" class="valing-middle">Scheduled Start
                                                            Time
                                                        </th>
                                                        <th width="20%" scope="col" class="valing-middle">Scheduled End Time
                                                        </th>
                                                        {{--                                                    <th width="20%" scope="col" class="valing-middle">Joey Start Time--}}
                                                        {{--                                                    </th>--}}
                                                        {{--                                                    <th width="20%" scope="col" class="valing-middle">Joey End Time</th>--}}
                                                        {{--                                                    <th width="20%" scope="col" class="valing-middle">Shift Premium</th>--}}
                                                        <th width="20%" scope="col" class="valing-middle">Action</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($zoneSchedule['data'] as $zone)
                                                        {{--                                                    @dd($zone->joeySchedule[0]->joey_id)--}}
                                                        <tr>
                                                            <td class="valing-middle">{{ $zone->zone_id }}</td>
                                                            <td class="valing-middle">
                                                                <span class="bold basecolor1">SH-{{$zone->id}}</span>
                                                            </td>
                                                            <td class="valing-middle">{{ optional($zone->joeySchedule)[0]->joey_id ?? 'N/A' }}</td>
                                                            <td class="valing-middle">{{ optional($zone->joeySchedule)[0]->joey->display_name ?? 'N/A' }}</td>
                                                            <td class="valing-middle">{{ $zone->start_time }}</td>
                                                            <td class="valing-middle">{{ $zone->end_time }}</td>
                                                            {{--                                                            <td class="valing-middle">{{ optional($zone->joeySchedule)->start_time ?? 'N/A' }}</td>--}}
                                                            {{--                                                            <td class="valing-middle">{{ optional($zone->joeySchedule)->end_time ?? 'N/A' }}</td>--}}
                                                            {{--                                                            <td class="valing-middle">{{ optional($zone->joeySchedule)->wage ?? 'N/A' }}</td>--}}
                                                            <td class="semibold valing-middle">
                                                                @if(can_access_route(['schedule.edit'],$userPermissoins))
                                                                    <a href="{{ route('schedule.edit', $zone->id) }}"
                                                                       title="Edit"
                                                                       class="btn btn-basecolor1 btn-mb ">Edit</a>
                                                                @endif
                                                                @if(can_access_route(['schedule.destroy'],$userPermissoins))
                                                                    <a class="btn btn-danger btn-mb " type="button"
                                                                       title="Delete"
                                                                       data-toggle="modal"
                                                                       data-target="#deleteModal{{ $zone->id }}">
                                                                        Delete
                                                                    </a>


                                                                    <div id="deleteModal{{ $zone->id }}"
                                                                         class="modal fade"
                                                                         role="dialog">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">Confirm
                                                                                        Delete</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p style="text-align: left!important">
                                                                                        Are you sure you want to delete
                                                                                        Schedule?</p>
                                                                                </div>
                                                                                <div class="modal-footer">

                                                                                    {!! Form::model($zone, ['method' => 'delete',  'url' => 'schedule/'.$zone->id, 'class' =>'form-inline form-delete']) !!}
                                                                                    {!! Form::hidden('id', $zone->id) !!}
                                                                                    {!! Form::submit('Confirm', ['class' => 'btn btn-success btn-flat']) !!}
                                                                                    {!! Form::close() !!}
                                                                                    <button type="button"
                                                                                            class="btn btn-basecolor1 pull-left"
                                                                                            data-dismiss="modal">Close
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                        {{--<div class="d-flex justify-content-center">--}}
                                        {{--{!! $joeyZoneSchedules->links() !!}--}}
                                        {{--</div>--}}
                                    @else
                                        <div class="custom_col">
                                            <table
                                                class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                                <thead>
                                                <tr>
                                                    <th width="8%" scope="col" class="valing-middle">Zone ID</th>
                                                    <th width="8%" scope="col" class="valing-middle">Schedule ID</th>
                                                    <th width="10%" scope="col" class="valing-middle">Joey ID</th>
                                                    <th width="12%" scope="col" class="valing-middle">Joey</th>
                                                    <th width="20%" scope="col" class="valing-middle">Scheduled Start Time</th>
                                                    <th width="20%" scope="col" class="valing-middle">Scheduled End Time</th>
                                                    <th width="20%" scope="col" class="valing-middle">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td width="8%" scope="col"></td>
                                                    <td width="8%" scope="col"></td>
                                                    <td width="8%" scope="col"></td>
                                                    <td width="8%" scope="col"></td>
                                                    <td width="8%" scope="col" class="text-left">Record Not Found</td>
                                                    <td width="8%" scope="col"></td>
                                                    <td width="8%" scope="col"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    @endif

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
        /*my js*/
    </script>
@stop

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
        .model-width{

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
                @include('front.joey.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">

                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Grocery Dispatch Route List</h1>
                                </div>
                            </div>
                            {{--<div class="content_header_wrap">--}}
                                {{--<div class="hgroup divider-after left">--}}
                                    {{--<h1 class="lh-10">Sub Admins List</h1>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-10">
                                                <div class="cs_pagination">
                                                    <ul class="no-list d-flex">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(count($routes) > 0)
                                        <hr>
                                        <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                            <thead>
                                            <tr>
                                                <th width="8%" scope="col">Route ID</th>
                                                <th width="8%" scope="col">Job ID</th>
                                                <th width="8%" scope="col">Joey</th>
                                                <th width="20%" scope="col" class="align-right">Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($routes as $route)
                                                <tr>
                                                    <td class="valing-middle">
                                                        <span class="bold basecolor1">RT-{{$route->id}}</span>
                                                    </td>
                                                    <td class="valing-middle">{{ optional($route->job)->job_id ?? 'N/A' }}</td>
                                                    <td class="valing-middle">{{ optional($route->joey)->display_name ?? 'N/A' }}</td>
                                                    <td class="semibold align-right">
                                                        <a class="btn btn-xs" type="button" data-toggle="modal"
                                                           data-target="#detailModal{{$route->id }}">
                                                            <span class="btn btn-basecolor1 btn-border btn-mb">Detail</span>
                                                        </a>
                                                        <div id="detailModal{{ $route->id}}"
                                                             class="modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content model-width">
                                                                    <div class="modal-header text-right"
                                                                         style="display: block">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <h4 class="modal-title text-left">
                                                                            {{ optional($route->joey)->display_name ?? 'N/A' }}
                                                                        </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                                                            <thead>
                                                                            <tr>
                                                                                <th width="8%" scope="col">Location Name</th>
                                                                                <th width="8%" scope="col">Type</th>
                                                                                <th width="8%" scope="col">Arrival Time</th>
                                                                                <th width="8%" scope="col">Finish Time</th>
                                                                            </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                            @foreach($route->location as $location)
                                                                                <tr>
                                                                                    <td>
                                                                                        {{ $location->location_name }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ $location->type }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ $location->arrival_time }}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ $location->finish_time }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
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
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                            <thead>
                                            <tr>
                                                <th width="8%" scope="col">Route ID</th>
                                                <th width="8%" scope="col">Job ID</th>
                                                <th width="8%" scope="col">Joey</th>
                                                <th width="20%" scope="col" class="align-right">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <td>Record Not Found</td>
                                            </tbody>
                                        </table>
                                    @endif
                                    <div class="d-flex justify-content-center">
                                        {{--{!! $routeSchedules->links() !!}--}}
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
        /*my js*/
    </script>
@stop

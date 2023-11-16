@extends('front.layouts.Dispatch-layout')

@section('page-title',"Order Zone Routing")

@section('css')
    <style>
        /*my css*/
        .img-thumbnail {
            width: 80px;
            height: 60px;
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
                @include('front.order-control.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Zone List</h1>
                                </div>
                            </div>

                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-4">
                                                <a href="{{ route('order_zone_routing.create') }}" class="cs_btn"><button type="submit" class="btn btn-primary submitButton">Add Zone</button></a>
                                                <div class="cs_pagination">
                                                    <ul class="no-list d-flex">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                        <thead>
                                        <tr>
                                            <th width="8%" scope="col">ID</th>
                                            <th width="10%" scope="col">Zone ID</th>
                                            <th width="12%" scope="col">Zone Title</th>
                                            <th width="12%" scope="col">Zone Type</th>
                                            <th width="12%" scope="col">Postal Codes</th>
                                            <th width="20%" scope="col" class="align-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderZones as $zones)
                                            <tr>
                                                <td class="valing-middle">
                                                    <span class="bold basecolor1">{{$zones->id}}</span>
                                                </td>
                                                <td class="valing-middle">
                                                    <span class="bold basecolor1">{{$zones->id}}</span>
                                                </td>
                                                <td class="valing-middle">{{$zones->title}}</td>
                                                <td class="valing-middle">{{$zones->zoneType->title}}</td>
                                                <td class="valing-middle">{{ $zones->postalCode->pluck('postal_code')->implode(', ') }}</td>
                                                {{--<td class="valing-middle">--}}
                                                    {{--@if(can_access_route(['sub-admin.active'],$userPermissoins))--}}
                                                        {{--@if($zones->status === 1)--}}
                                                            {{--<a class="btn btn-xs" type="button" data-toggle="modal"--}}
                                                               {{--data-target="#statusModal{{$zones->id }}">--}}
                                                                {{--<span class="btn btn-basecolor1 btn-border btn-mb">Active</span>--}}
                                                            {{--</a>--}}
                                                            {{--<div id="statusModal{{ $zones->id}}" class="modal fade"--}}
                                                                 {{--role="dialog">--}}
                                                                {{--<div class="modal-dialog">--}}
                                                                    {{--<div class="modal-content">--}}
                                                                        {{--<div class="modal-header">--}}
                                                                            {{--<button type="button" class="close"--}}
                                                                                    {{--data-dismiss="modal"--}}
                                                                                    {{--aria-label="Close"></button>--}}
                                                                            {{--<h4 class="modal-title">Confirm Status?</h4>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="modal-body">--}}
                                                                            {{--<p>Are you sure you want to change the--}}
                                                                                {{--status?</p>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="modal-footer">--}}
                                                                            {{--<button type="button"--}}
                                                                                    {{--class="btn btn-default btn-flat pull-left"--}}
                                                                                    {{--data-dismiss="modal">Close--}}
                                                                            {{--</button>--}}
                                                                            {{--{!! Form::model($zones, ['method' => 'get',  'url' => 'sub-admin/inactive/'.$zones->id, 'class' =>'form-inline form-edit']) !!}--}}
                                                                            {{--{!! Form::hidden('id', $zones->id) !!}--}}
                                                                            {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                                                                            {{--{!! Form::close() !!}--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--@else--}}
                                                            {{--<a class="btn btn-xs" type="button" data-toggle="modal"--}}
                                                               {{--data-target="#statusModal{{ $zones->id }}">--}}
                                                                {{--<span class="btn btn-basecolor1 btn-border btn-mb">In Active</span>--}}
                                                            {{--</a>--}}
                                                            {{--<div id="statusModal{{ $zones->id }}" class="modal fade"--}}
                                                                 {{--role="dialog">--}}
                                                                {{--<div class="modal-dialog">--}}
                                                                    {{--<div class="modal-content">--}}
                                                                        {{--<div class="modal-header">--}}
                                                                            {{--<button type="button" class="close"--}}
                                                                                    {{--data-dismiss="modal"--}}
                                                                                    {{--aria-label="Close"></button>--}}
                                                                            {{--<h4 class="modal-title">Confirm Status?</h4>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="modal-body">--}}
                                                                            {{--<p>Are you sure you want to change the--}}
                                                                                {{--status?</p>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="modal-footer">--}}
                                                                            {{--<button type="button"--}}
                                                                                    {{--class="btn btn-default btn-flat pull-left"--}}
                                                                                    {{--data-dismiss="modal">Close--}}
                                                                            {{--</button>--}}
                                                                            {{--{!! Form::model($zones, ['method' => 'get',  'url' => 'sub-admin/active/'.$zones->id, 'class' =>'form-inline form-edit']) !!}--}}
                                                                            {{--{!! Form::hidden('id', $zones->id) !!}--}}
                                                                            {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                                                                            {{--{!! Form::close() !!}--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--@endif--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                <td class="semibold align-right">
                                                    @if(can_access_route(['order_zone_routing.edit'],$userPermissoins))
                                                        <a href="{{ route('order_zone_routing.edit', $zones->id) }}"
                                                           title="Edit" class="btn btn-basecolor1 btn-mb ">Edit</a>
                                                    @endif
                                                    @if(can_access_route(['order_zone_routing.destroy'],$userPermissoins))
                                                        <a class="btn btn-danger btn-mb " type="button" title="Delete"
                                                           data-toggle="modal"
                                                           data-target="#deleteModal{{ $zones->id }}">
                                                            Delete
                                                        </a>


                                                        <div id="deleteModal{{ $zones->id }}" class="modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete Delivery type?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-default btn-flat pull-left"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                        {!! Form::model($zones, ['method' => 'delete',  'url' => 'order_zone_routing/'.$zones->id, 'class' =>'form-inline form-delete']) !!}
                                                                        {!! Form::hidden('id', $zones->id) !!}
                                                                        {!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}
                                                                        {!! Form::close() !!}
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
                                    <div class="d-flex justify-content-center">
                                        {!! $orderZones->links() !!}
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
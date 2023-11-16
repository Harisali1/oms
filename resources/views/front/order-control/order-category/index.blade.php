@extends('front.layouts.Dispatch-layout')

@section('page-title',"Order Zone Routing")

@section('css')
    <style>
        /*my css*/
        .img-thumbnail {
            width: 80px;
            height: 60px;
        }
        .add-button{
            margin-bottom: auto;
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
                @include('front.order-control.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">

                            <div class="content_header_wrap row">
                                <div class="hgroup divider-after left col-md-6 col-sm-12">
                                    <h1 class="">Order Category Control List</h1>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    @if(can_access_route(['order_category.create'],$userPermissoins))
                                        <a href="{{ route('order_category.create') }}" class="cs_btn btn btn-primary submitButton col-sm-12 col-md-5">
                                            Add Category Control
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{--<div class="content_header_wrap p-0">--}}
                                {{--<div class="hgroup divider-after left">--}}
                                    {{--<h1 class="lh-10">Order Category Control List</h1>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>
                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-md-4 col-sm-12">
                                                {{ $orderCategories->links('vendor.pagination.default') }}
                                            </div>
                                            {{--<div class="col-md-8 col-sm-12 add-button">--}}
                                                {{--<div class="float-right">--}}
                                                    {{--@if(can_access_route(['order_category.create'],$userPermissoins))--}}
                                                        {{--<a href="{{ route('order_category.create') }}" class="cs_btn">--}}
                                                            {{--<button type="submit" class="btn btn-primary submitButton">--}}
                                                                {{--Add Category Control--}}
                                                            {{--</button>--}}
                                                        {{--</a>--}}
                                                    {{--@endif--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-4">--}}
                                                {{--<a href="{{ route('order_category.create') }}" class="cs_btn"><button type="submit" class="btn btn-primary submitButton">Add Category Control</button></a>--}}
                                                {{--<div class="cs_pagination">--}}
                                                    {{--<ul class="no-list d-flex">--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                    <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                        <thead>
                                        <tr>
                                            <th width="8%" scope="col">ID</th>
                                            <th width="10%" scope="col">Category</th>
                                            <th width="10%" scope="col">Start Time</th>
                                            <th width="10%" scope="col">End Time</th>
                                            <th width="12%" scope="col">Delivery Types</th>
                                            <th width="12%" scope="col">Delivery Preferences</th>
                                            <th width="12%" scope="col">Zones</th>
                                            <th width="20%" scope="col" class="align-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderCategories as $zones)
                                            <tr>
                                                <td class="valing-middle">
                                                    <span class="bold basecolor1">{{$zones->id}}</span>
                                                </td>
                                                <td class="valing-middle">
                                                    <span class="bold basecolor1">{{ optional($zones->category)->name ?? 'N/A' }}</span>
                                                </td>

                                                @php
                                                    $startTime = $zones->start_time;
                                                    $endTime = $zones->end_time;
                                                @endphp
                                                <td class="valing-middle">
                                                    @if($endTime != 'N/A')
                                                        {{ date('h:i:s A', strtotime($startTime)) }}
                                                    @endif
                                                </td>
                                                <td class="valing-middle">
                                                    @if($endTime != 'N/A')
                                                        {{ date('h:i:s A', strtotime($endTime))}}
                                                    @endif
                                                </td>
                                                <td class="valing-middle">{{ optional($zones->category->deliveryType)->pluck('title')->implode(', ') ?? 'N/A' }}</td>
                                                <td class="valing-middle">{{ optional($zones->category->deliveryPreference)->pluck('title')->implode(', ') ?? 'N/A' }}</td>
                                                <td class="valing-middle">{{ optional($zones->category->orderCategoryZone)->pluck('title')->implode(', ') ?? 'N/A' }}</td>

                                                <td class="semibold align-right">
                                                    @if(can_access_route(['order_category.edit'],$userPermissoins))
                                                        <a href="{{ route('order_category.edit', $zones->id) }}"
                                                           title="Edit" class="btn btn-basecolor1 btn-mb ">Edit</a>
                                                    @endif
                                                    @if(can_access_route(['order_category.destroy'],$userPermissoins))
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
                                                                        <h4 class="modal-title">Confirm Delete</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p style="text-align: left!important">Are you sure you want to delete this control?</p>
                                                                    </div>
                                                                    <div class="modal-footer">

                                                                        {!! Form::model($zones, ['method' => 'delete',  'url' => 'order_category/'.$zones->id, 'class' =>'form-inline form-delete']) !!}
                                                                        {!! Form::hidden('id', $zones->id) !!}
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
                                    {{--<div class="d-flex justify-content-center">--}}
                                        {{--{!! $orderCategories->links() !!}--}}
                                    {{--</div>--}}
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

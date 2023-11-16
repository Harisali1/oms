@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Type")

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
                                    <h1 class="">Delivery Type List</h1>
                                </div>
                                <div class="col-md-6 col-sm-12 text-right">
                                    @if(can_access_route(['delivery_type.create'],$userPermissoins))
                                        <a href="{{ route('delivery_type.create') }}" class="cs_btn btn btn-primary submitButton col-sm-12 col-md-4">
                                            Add Delivery Type
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>
                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-md-4 col-sm-12">
                                                {{ $deliveryTypes->links('vendor.pagination.default') }}
                                            </div>
                                            {{--<div class="col-md-8 col-sm-12 add-button">--}}
                                                {{--<div class="float-right">--}}
                                                    {{--@if(can_access_route(['delivery_type.create'],$userPermissoins))--}}
                                                        {{--<a href="{{ route('delivery_type.create') }}" class="cs_btn">--}}
                                                            {{--<button type="submit" class="btn btn-primary submitButton">Add--}}
                                                                {{--Delivery Type--}}
                                                            {{--</button>--}}
                                                        {{--</a>--}}
                                                    {{--@endif--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                    <table class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center" id="myTable">
                                        <thead>
                                        <tr>
                                            <th width="8%" scope="col">ID</th>
                                            <th width="10%" scope="col">Delivery Type</th>
                                            {{--<th width="12%" scope="col">Status</th>--}}
                                            <th width="20%" scope="col" class="align-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($deliveryTypes) > 0)
                                            @foreach($deliveryTypes as $key => $deliveryType)
                                                <tr>
                                                    <td class="valing-middle">
                                                        <span class="bold basecolor1">{{ $deliveryType->id  }}</span>
                                                    </td>
                                                    <td class="valing-middle">{{$deliveryType->title}}</td>
                                                    {{--<td class="valing-middle">--}}
                                                    {{--@if(can_access_route(['delivery_type.status'],$userPermissoins))--}}
                                                    {{--<a class="btn btn-xs" type="button" data-toggle="modal"--}}
                                                    {{--data-target="#statusModal{{$deliveryType->id }}">--}}
                                                    {{--@if($deliveryType->status === 1)--}}
                                                    {{--<span class="btn btn-basecolor1 btn-border btn-mb">Active</span>--}}
                                                    {{--@else--}}
                                                    {{--<span class="btn btn-basecolor1 btn-border btn-mb">In Active</span>--}}
                                                    {{--@endif--}}
                                                    {{--</a>--}}
                                                    {{--<div id="statusModal{{ $deliveryType->id}}" class="modal fade"--}}
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
                                                    {{--{!! Form::model($deliveryType, ['method' => 'get',  'url' => 'delivery_type/status/'.$deliveryType->id, 'class' =>'form-inline form-edit']) !!}--}}
                                                    {{--{!! Form::hidden('id', $deliveryType->id) !!}--}}
                                                    {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                                                    {{--{!! Form::close() !!}--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--@endif--}}
                                                    {{--</td>--}}
                                                    <td class="semibold align-right">
                                                        @if(can_access_route(['delivery_type.edit'],$userPermissoins))
                                                            <a href="{{ route('delivery_type.edit', $deliveryType->id) }}"
                                                               title="Edit" class="btn btn-basecolor1 btn-mb ">Edit</a>
                                                        @endif
                                                        @if(can_access_route(['delivery_type.destroy'],$userPermissoins))
                                                            <a class="btn btn-danger btn-mb " type="button"
                                                               title="Delete"
                                                               data-toggle="modal"
                                                               data-target="#deleteModal{{ $deliveryType->id }}">
                                                                Delete
                                                            </a>


                                                            <div id="deleteModal{{ $deliveryType->id }}"
                                                                 class="modal fade"
                                                                 role="dialog">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p style="text-align: left!important">Are you sure you want to delete delivery
                                                                                type?</p>
                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            {!! Form::model($deliveryType, ['method' => 'delete',  'url' => 'delivery_type/'.$deliveryType->id, 'class' =>'form-inline form-delete']) !!}
                                                                            {!! Form::hidden('id', $deliveryType->id) !!}
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
                                        @else
                                            <tr>
                                                <td>
                                                    No Data Found
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    {{--<div class="d-flex justify-content-center">--}}
                                        {{--{!! $deliveryTypes->links() !!}--}}
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
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $('#myTable').dataTable( {
            "searching":true
        });
    </script>
@stop

@extends('front.layouts.Dispatch-layout')

@section('page-title',"Order Control")

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
                    {{--<aside id="right_content" class="col-12 col-lg-9">--}}
                    {{--<div class="inner">--}}
                    {{--<div class="content_header_wrap">--}}
                    {{--<div class="hgroup divider-after left">--}}
                    {{--<h1 class="lh-10">Sub Admins List</h1>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--<section class="section-content summary-section">--}}
                    {{--<div class="section-inner">--}}
                    {{--<div class="grid_controls">--}}
                    {{--<div class="row align-items-end">--}}
                    {{--<div class="col-4">--}}
                    {{--<div class="cs_pagination">--}}
                    {{--<ul class="no-list d-flex">--}}
                    {{--<li><a href="#" class="cs_btn">Previous</a></li>--}}
                    {{--<li><select name="" id="" class="form-control pages-dd">--}}
                    {{--<option value="1">Page 1</option>--}}
                    {{--<option value="2">Page 2</option>--}}
                    {{--<option value="3">Page 3</option>--}}
                    {{--<option value="4">Page 4</option>--}}
                    {{--</select></li>--}}
                    {{--<li><a href="#" class="cs_btn">Next</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<table class="table table-striped table-responsive tbl-responsive mb_last_row_hightlight mb_last_row_center">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                    {{--<th width="8%" scope="col">ID</th>--}}
                    {{--<th width="8%" scope="col">Image</th>--}}
                    {{--<th width="10%" scope="col">Name</th>--}}
                    {{--<th width="12%" scope="col">Email</th>--}}
                    {{--<th width="12%" scope="col">Phone</th>--}}
                    {{--<th width="12%" scope="col">Status</th>--}}
                    {{--<th width="20%" scope="col" class="align-right">Actions</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach($sub_admins as $sub_admin)--}}
                    {{--<tr>--}}
                    {{--<td class="valing-middle"><span class="bold basecolor1">{{$sub_admin->id}}</span></td>--}}
                    {{--<td class="valing-middle">--}}
                    {{--@if(!empty($sub_admin->profile_picture))--}}
                    {{--<img class="img-thumbnail" src="{{$sub_admin->profile_picture}}"/>--}}
                    {{--@else--}}
                    {{--<span></span>--}}
                    {{--@endif--}}
                    {{--</td>--}}
                    {{--<td class="valing-middle">{{$sub_admin->name}}</td>--}}
                    {{--<td class="valing-middle">{{$sub_admin->email}}</td>--}}
                    {{--<td class="valing-middle">{{$sub_admin->phone}}</td>--}}
                    {{--<td class="valing-middle">--}}
                    {{--@if(can_access_route(['sub-admin.active'],$userPermissoins))--}}
                    {{--@if($sub_admin->status === 1)--}}
                    {{--<a  class="btn btn-xs" type="button" data-toggle="modal"--}}
                    {{--data-target="#statusModal{{$sub_admin->id }}">--}}
                    {{--<span class="btn btn-basecolor1 btn-border btn-mb">Active</span>--}}
                    {{--</a>--}}
                    {{--<div id="statusModal{{ $sub_admin->id}}" class="modal fade" role="dialog">--}}
                    {{--<div class="modal-dialog">--}}
                    {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>--}}
                    {{--<h4 class="modal-title">Confirm Status?</h4>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                    {{--<p>Are you sure you want to change the status?</p>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>--}}
                    {{--{!! Form::model($sub_admin, ['method' => 'get',  'url' => 'sub-admin/inactive/'.$sub_admin->id, 'class' =>'form-inline form-edit']) !!}--}}
                    {{--{!! Form::hidden('id', $sub_admin->id) !!}--}}
                    {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                    {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--@else--}}
                    {{--<a  class="btn btn-xs" type="button" data-toggle="modal"--}}
                    {{--data-target="#statusModal{{ $sub_admin->id }}">--}}
                    {{--<span class="btn btn-basecolor1 btn-border btn-mb">In Active</span>--}}
                    {{--</a>--}}
                    {{--<div id="statusModal{{ $sub_admin->id }}" class="modal fade" role="dialog">--}}
                    {{--<div class="modal-dialog">--}}
                    {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>--}}
                    {{--<h4 class="modal-title">Confirm Status?</h4>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                    {{--<p>Are you sure you want to change the status?</p>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>--}}
                    {{--{!! Form::model($sub_admin, ['method' => 'get',  'url' => 'sub-admin/active/'.$sub_admin->id, 'class' =>'form-inline form-edit']) !!}--}}
                    {{--{!! Form::hidden('id', $sub_admin->id) !!}--}}
                    {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                    {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--@endif--}}
                    {{--</td>--}}
                    {{--<td class="semibold align-right">--}}
                    {{--@if(can_access_route(['sub-admin.edit'],$userPermissoins))--}}
                    {{--<a  href="{{route('sub-admin.edit', base64_encode ($sub_admin->id))}}" title="Edit" class="btn btn-basecolor1 btn-mb ">Edit</a>--}}
                    {{--@endif--}}
                    {{--@if(can_access_route(['sub-admin.destroy'],$userPermissoins))--}}
                    {{--<a class="btn btn-danger btn-mb " type="button" title="Delete" data-toggle="modal"--}}
                    {{--data-target="#deleteModal{{ $sub_admin->id }}">--}}
                    {{--Delete--}}
                    {{--</a>--}}


                    {{--<div id="deleteModal{{ $sub_admin->id }}" class="modal fade" role="dialog">--}}
                    {{--<div class="modal-dialog">--}}
                    {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>--}}
                    {{--<h4 class="modal-title">Confirm Delete</h4>--}}
                    {{--</div>--}}
                    {{--<div class="modal-body">--}}
                    {{--<p>Are you sure you want to delete sub admin?</p>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Close</button>--}}
                    {{--{!! Form::model($sub_admin, ['method' => 'delete',  'url' => 'sub-admin/'.$sub_admin->id, 'class' =>'form-inline form-delete']) !!}--}}
                    {{--{!! Form::hidden('id', $sub_admin->id) !!}--}}
                    {{--{!! Form::submit('Yes', ['class' => 'btn btn-success btn-flat']) !!}--}}
                    {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--@endif--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                    {{--</table>--}}
                    {{--<div class="d-flex justify-content-center">--}}
                    {{--{!! $sub_admins->links() !!}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</section>--}}
                    {{--</div>--}}
                    {{--</aside>--}}
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
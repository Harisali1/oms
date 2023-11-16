@extends('front.layouts.Dispatch-layout')

@section('page-title',"Sub Admin List")

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

            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                @include('front.sub-admin.sub-admin-sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Sub Admins List</h1>
                                </div>
                            </div>
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>

                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row">
                                            <div class="col-8">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" id="myInput" class="form-control form-control-lg"
                                                       onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom_col">
                                        <table class="table table-striped table-responsive tbl-responsive mb_last_row_hightlight mb_last_row_center custmRespons" id="myTable">
                                            <thead>
                                            <tr>
                                                <th width="8%" scope="col">ID</th>
                                                <th width="8%" scope="col">Image</th>
                                                <th width="10%" scope="col">Name</th>
                                                <th width="12%" scope="col">Email</th>
                                                <th width="12%" scope="col">Phone</th>
                                                <th width="12%" scope="col">Status</th>
                                                <th width="20%" scope="col" class="align-right">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sub_admins as $sub_admin)
                                                <tr>
                                                    <td class="valing-middle"><span
                                                            class="bold basecolor1">{{$sub_admin->id}}</span></td>
                                                    <td class="valing-middle">
                                                        @if(!empty($sub_admin->profile_picture))
                                                            <img class="img-thumbnail" onClick="ShowLightBox(this);"
                                                                 src="{{$sub_admin->profile_picture}}"/>
                                                        @else
                                                            <span></span>
                                                        @endif
                                                    </td>
                                                    <td class="valing-middle">{{$sub_admin->name}}</td>
                                                    <td class="valing-middle">{{$sub_admin->email}}</td>
                                                    <td class="valing-middle">{{$sub_admin->phone}}</td>
                                                    <td class="valing-middle">
                                                        @if(can_access_route(['sub-admin.active'],$userPermissoins))
                                                            @if($sub_admin->status === 1)
                                                                <a class="btn btn-xs" type="button" data-toggle="modal"
                                                                   data-target="#statusModal{{$sub_admin->id }}">
                                                                    <span class="btn btn-basecolor1 btn-border btn-mb active_btn">Active</span>
                                                                </a>
                                                                <div id="statusModal{{ $sub_admin->id}}" class="modal fade"
                                                                     role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Confirm Status?</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <strong style="text-align: left!important">Are you sure you want to change the
                                                                                    status?</strong>
                                                                            </div>
                                                                            <div class="modal-footer">

                                                                                {!! Form::model($sub_admin, ['method' => 'get',  'url' => 'sub-admin/inactive/'.$sub_admin->id, 'class' =>'form-inline form-edit']) !!}
                                                                                {!! Form::hidden('id', $sub_admin->id) !!}
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
                                                            @else
                                                                <a class="btn btn-xs" type="button" data-toggle="modal"
                                                                   data-target="#statusModal{{ $sub_admin->id }}">
                                                                    <span class="btn btn-basecolor1 btn-border btn-mb">In Active</span>
                                                                </a>
                                                                <div id="statusModal{{ $sub_admin->id }}" class="modal fade"
                                                                     role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Confirm Status?</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <strong class="text-left"
                                                                                        style="text-align: left!important">Are
                                                                                    you sure you want to change the
                                                                                    status?</strong>
                                                                            </div>
                                                                            <div class="modal-footer">

                                                                                {!! Form::model($sub_admin, ['method' => 'get',  'url' => 'sub-admin/active/'.$sub_admin->id, 'class' =>'form-inline form-edit']) !!}
                                                                                {!! Form::hidden('id', $sub_admin->id) !!}
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
                                                        @endif
                                                    </td>
                                                    <td class="semibold align-right">
                                                        @if(can_access_route(['sub-admin.edit'],$userPermissoins))
                                                            <a href="{{route('sub-admin.edit', base64_encode ($sub_admin->id))}}"
                                                               title="Edit" class="btn btn-basecolor1 btn-mb ">Edit</a>
                                                        @endif
                                                        @if(can_access_route(['sub-admin.destroy'],$userPermissoins))
                                                            <a class="btn btn-danger btn-mb " type="button" title="Delete"
                                                               data-toggle="modal"
                                                               data-target="#deleteModal{{ $sub_admin->id }}">
                                                                Delete
                                                            </a>
                                                            <div id="deleteModal{{ $sub_admin->id }}" class="modal fade"
                                                                 role="dialog">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-left"
                                                                               style="text-align: left!important">Are you
                                                                                sure you want to delete sub admin?</p>
                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            {!! Form::model($sub_admin, ['method' => 'delete',  'url' => 'sub-admin/'.$sub_admin->id, 'class' =>'form-inline form-delete']) !!}
                                                                            {!! Form::hidden('id', $sub_admin->id) !!}
                                                                            {!! Form::submit('Confirm', ['class' => 'btn btn-success btn-flat']) !!}
                                                                            {!! Form::close() !!}
                                                                            <button type="button"
                                                                                    class="btn pull-left btn-basecolor1"
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
                                    {{ $sub_admins->links('vendor.pagination.default') }}
                                    {{--<div class="d-flex justify-content-center">--}}
                                    {{--{!! $sub_admins->links() !!}--}}
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
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function ShowLightBox(el) {

            // get current  img src
            let img_src = el.src;
            // create html
            let html = '<div id="custom-light-box-model" class="modal">';
            html+=' <span class="custom-light-box-model-close-btn" onClick="CloseLightBox()">X</span>';
            html+=' <img src="'+img_src+ '" class="custom-light-box-model-img" id=""> ';
            html+=' </div> ';

            // appending html
            document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeend",
                html );
        }

        function CloseLightBox() {
            document.getElementById("custom-light-box-model").remove();
        }
    </script>
@stop

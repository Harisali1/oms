@extends('front.layouts.Dispatch-layout')

@section('page-title',"Role View")

@section('css')
    <style>
        .show-title{
            padding: 0px;
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
                @include('front.roles.role-sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Role Details</h1>
                                </div>
                            </div>


                            <!--portlet-body-open-->
                            <div class="portlet-body details-page-main-container content_header_wrap">

                                <!--show-details-title-open-->
                                <div class="col-sm-12 show-title">
                                    <h4>Role Main Details</h4>
                                </div>
                                <!--show-details-box-close-->

                                <!--details-page-wrap-open-->
                                <div class="row  details-page-wrap">
                                    <!--show-details-box-open-->
                                    <div class="col-sm-12 col-md-3 show-details-box">
                                        <p class="show-details-lable">
                                            <strong class="col-md-6 col-sm-6 text-left" style="padding-left: 0;">Name:</strong>
                                            <span class="col-md-6 col-sm-6 text-left">{{$role->display_name}}</span>
                                        </p>
                                    </div>
                                    <!--show-details-box-close-->

                                    <!--show-details-box-open-->
                                    <div class="col-sm-12 col-md-3 show-details-box">
                                        <p class="show-details-lable">
                                            <strong class="col-md-6 col-sm-6 text-left" style="padding-left: 0;">Created at:</strong>
                                            <span class="col-md-6 col-sm-6 text-left">{{$role->created_at}}</span>
                                        </p>
                                    </div>
                                    <!--show-details-box-close-->

                                    <!--show-details-box-open-->
                                    <div class="col-sm-12 col-md-3 show-details-box">
                                        <p class="show-details-lable">
                                            <strong class="col-md-6 col-sm-6 text-left" style="padding-left: 0;">Total users count:</strong>
                                            <span class="col-md-6 col-sm-6 text-left">{{$role->User->count()}}</span>
                                        </p>
                                    </div>
                                    <!--show-details-box-close-->

                                    <!--show-details-box-open-->
                                    <div class="col-sm-12 col-md-3 show-details-box">
                                        <p class="show-details-lable">
                                            <strong class="col-md-6 col-sm-6 text-left" style="padding-left: 0;">Total permissions count:</strong>
                                            <span class="col-md-6 col-sm-6 text-left">
                                                 @if(!empty($role->dashbaord_cards_rights))
                                                    <?php
                                                    $dashboard_count = count(explode(',', $role->dashbaord_cards_rights));
                                                    ?>
                                                    {{$dashboard_count}}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                    <!--show-details-box-close-->
                                </div>
                                <!--details-page-wrap-close-->

                                <!--show-details-title-open-->
                                <div class="col-sm-12 show-title mt-3">
                                    <h4>Permissions List</h4>
                                </div>
                                <!--show-details-box-close-->

                                <!--details-page-wrap-open-->
                                <div class="row  details-page-wrap">
                                    <!--show-details-box-open-->
                                    <div class="col-sm-12 show-details-box">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="text-center ">ID</th>
                                                    <th class="text-center">Type</th>
                                                    <th class="text-center">Access</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">Dashboard Cards Rights</td>
                                                    <td class="text-center">
                                                        {{ucfirst(str_replace(',',' , ',str_replace('_',' ',$role->dashbaord_cards_rights)))}}
                                                    </td>
                                                </tr>
                                                @php $permission_count = 0; @endphp
                                                @foreach($permissions as $type => $permission )
                                                    <tr>
                                                        <td class="text-center">{{$loop->iteration+1}}</td>
                                                        <td class="text-center">{{$type}}</td>
                                                        <td class="text-center">
                                                            @foreach($permission as $name => $permission)
                                                                @if(check_permission_exist($permission,$route_names))

                                                                    @php
                                                                        $names = '" '. $name.' "';
                                                                        $permission_count++;
                                                                    @endphp
                                                                    {{ $names }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--show-details-box-close-->

                                </div>
                                <!--details-page-wrap-close-->


                            </div>
                            <!--portlet-body-close-->


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
        /*my js*/
    </script>
@stop

@extends('front.layouts.Dispatch-layout')
@section('page-title',"Batch Order List")
@section('css')
    <style>
        /*my css*/
        .img-thumbnail {
            width: 80px;
            height: 60px;
        }

        .table-responsive {
            display: table;
        }

        .modal-content {
            width: 50%;
        }

        .row {
            flex-wrap: nowrap;
        }

        /*.section-inner {*/
        /*    float: left;*/
        /*    width: 100%;*/
        /*    overflow-x: auto;*/
        /*}*/
        @media (max-width: 1440px) {
            .table_col {
                width: 1000px !important;
                overflow-x: hidden;
            }
        }

        .jconfirm.jconfirm-light .jconfirm-box .jconfirm-buttons button {
            color: white;
            font: 19px Poppins, sa ns-serif;
            margin: 4px;
            padding: 13.6px 30px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            outline: none;
            text-decoration: none;
            -webkit-border-radius: 10px;
            -khtml-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
            border-radius: 10px;
            /*padding-right: 30px;*/
            /*padding-left: 30px;*/

        }

        .jconfirm.jconfirm-white .jconfirm-box .jconfirm-buttons button, .jconfirm.jconfirm-light .jconfirm-box .jconfirm-buttons button.btn-default {
            -webkit-box-shadow: none;
            box-shadow: none;
            color: #333;
        }
    </style>
@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <aside id="left_sidebar" class="col-12 col-lg-2">
                        <div class="inner">
                            <div class="widget_sidebar widget_filter">
                                <h4 class="widgetTitle"><i class="icofont-user-alt-5"></i> Filter Results</h4>
                                <div class="widgetInfo">
                                    <form action="{{route('batch-order.index')}}" method="get">
                                        <div class="form-group no-min-h">
                                            <label for="date">Filer by date</label>
                                            <input type="date" name="date" class="data-selector form-control"
                                                   required=""
                                                   value="{{ isset($_GET['date'])?$_GET['date']: date('Y-m-d') }}">

                                        </div>
                                        <div class="divider sm"></div>
                                        <div class="form-group no-min-height">
                                            <label for="vendor">Filter by Vendor</label>
                                            <select name="VendorName" id="vendor_id"
                                                    class="select2 form-control-lg vendor-list">
                                                <option value="" disabled selected>Select a Store</option>
                                                @foreach($vendor as $data)
                                                    <option value="{{$data->id}}"> {{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="btn-group align-right">
                                            <button type="submit"
                                                    class="btn btn-primary btn-xs mb-fluid">Filter
                                                Results
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <aside id="right_content" class="col-12 col-lg-12">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Batch Orders List</h1>
                                </div>
                            </div>
                            </form>
                            <div class="col-md-5 col-12 create-batch">
                                @if(can_access_route(['create.batch'],$userPermissoins))
                                    <button class="btn btn-white btn-sm mb-fluid batch-create" data-toggle="modal">
                                        <i class="fa fa-plus"></i>
                                        Create Batch
                                    </button>
                                @endif
                            </div>
                        </div>
                        @if(can_access_route(['Unassigned.batch'],$userPermissoins))
                            <button style="margin: 67px 12px -27px 36px;
                                         padding: 8px 16px;" class="btn btn-basecolor1 btn-sm delete_all" id="btn_dis"
                                    data-url="{{ url('batch/delete/all') }}">Unassigned All
                            </button>

                        @endif

                        <section class="section-content summary-section">
                            <div class="section-inner">
                                <div class="grid_controls">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="custom_col  table_col" style="width: 100%; overflow-x: auto;">
                                                <div class="content_header_wrap">
                                                    @include('front.partials.errors')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table
                                        class="table table-striped table-responsive tbl-responsive mb_last_row_hightlight mb_last_row_center custmRespons"
                                        id="myTable" style="width: 1450px;">
                                        <thead>

                                                                                <th width="7%" scope="col" style="padding:11px 0px">Select All <input label="select all  " type="checkbox" id="master"></th>
{{--                                        <th width="8%" scope="col"><input id="master" class=""--}}
{{--                                                                          type="button" value="Select"--}}
{{--                                                                          style="      width: 99%;--}}
{{--    font-size: 14px;--}}
{{--    font-weight: 600;--}}
{{--    background: none;--}}
{{--    border: none;--}}
{{--    color: #dd621c;--}}
{{--    margin: 0 0 -1px -12px;"></th>--}}
                                        <th style="width: 5%" scope="col">No.</th>
                                        <th style="width: 7%" scope="col">Batch ID</th>
                                        <th style="width: 7%" scope="col">Order ID</th>
                                        <th style="width: 8%" scope="col">Window</th>
                                        <th style="width: 8%" scope="col">Status</th>
                                        <th style="width: 12%" scope="col">Joey</th>
                                        <th style="width: 15%" scope="col "> Store Name</th>
                                        <th style="width: 15%" scope="col">Drop Off Address</th>
                                        <th style="width: 7%" scope="col">Distance</th>
                                        <th style="width: 9%" scope="col">Created At</th>
                                        <th style="width: 25%" scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <?php $i = 1;?>
                                        @foreach($batchOrders as $batch)
{{--                                            <tr id="tr_{{$batch->Batchorder_id}}">--}}
{{--                                                <td>--}}
{{--                                                    <div class="button">--}}
{{--                                                        <input class="sub_chk first"--}}
{{--                                                               data-id="{{$batch->Batchorder_id}}"--}}
{{--                                                               type="checkbox"></div>--}}
{{--                                                </td>--}}
                                            <tr id="tr_{{$batch->Batchorder_id}}">
                                                <td><input type="checkbox" class="sub_chk"
                                                           data-id="{{$batch->Batchorder_id}}"></td>
                                                <td>{{$i}}</td>
                                                <td><span id="idVal">{{$batch->id}}</span></td>
                                                <td>{{$batch->order_id}}</td>
                                                <td>{{$batch->start_time.'-'.$batch->end_time}}</td>
                                                <td>
                                                    @if(isset($batch->batchOrders->getStatus->last()->status_id))
                                                        {{  getStatusCodesWithKey('status_labels.'.$batch->batchOrders->getStatus->last()->status_id)  }}
                                                    @else
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($batch->joey_id != 0 & $batch->joey_id > 0)
                                                        {{isset($batch->joeys->first_name) ? $batch->joeys->first_name.''.$batch->joeys->last_name : ''}}
                                                    @else
                                                        Joey Not Assign
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="no-list attr-list">
                                                        <li><i class="icofont-user"></i>
                                                            {{isset($batch->VendorName->name) ? $batch->VendorName->name :'Vendor Not Found'}}
                                                        </li>
                                                    </ul>
                                                    <ul class="no-list attr-list">
                                                        <li>
                                                            <i class="icofont-google-map"></i>
                                                            {{isset($batch->VendorName->vendorLocationId->address) ? $batch->VendorName->vendorLocationId->address : 'No Address'}}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="no-list attr-list">
                                                        <li>
                                                            @if($batch->getContact($batch->contact_id))
                                                                <i class="icofont-user"></i>
                                                                {{$batch->getContact($batch->contact_id)}}
                                                            @endif
                                                        </li>
                                                        @if($batch->getlocation($batch->location_id ))
                                                            <li><i class="icofont-google-map"></i>
                                                                {{$batch->getlocation($batch->location_id)}}
                                                            </li>
                                                    </ul>
                                                    @else
                                                        {{'not found'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($batch->distance))
                                                        {{(round($batch->distance/1000 , 2) . ' km')}}
                                                    @else
                                                        {{'Not found'}}
                                                    @endif
                                                </td>
                                                <td>{{date('Y-m-d' , strtotime($batch->created_at))}}</td>

                                                <td>
                                                    @if(can_access_route(['assign.batch.joey'],$userPermissoins))
                                                        <button data-toggle="modal" href="#"
                                                                class="btn btn-basecolor1 btn-mb batch-assign"
                                                                data-value="{{$batch->id}}"
                                                                title="Pre-Assign">P
                                                        </button>
                                                    @endif
                                                    @if(can_access_route(['transfer.batch'],$userPermissoins))
                                                        <button data-toggle="modal" href="#"
                                                                class="btn btn-basecolor1 btn-mb transfer-batch"
                                                                data-value="{{$batch->id}}"
                                                                title="Transfer">T
                                                        </button>
                                                    @endif
                                                    @if(can_access_route(['edit.assign.batch' ],$userPermissoins))
                                                        <a href="{{route('edit.assign.batch' , $batch->id)}}"
                                                           class="btn btn-basecolor1 btn-mb"
                                                           title="Edit">E
                                                        </a>
                                                    @endif
                                                    @if(can_access_route(['map.view' ],$userPermissoins))
                                                        <button data-toggle="modal" href="#"
                                                                class="btn btn-basecolor1 btn-mb map-view-batch  valueformap"
                                                                data-value="{{$batch->id}}"
                                                                title="Map">M
                                                        </button>
                                                    @endif

                                                    @if(can_access_route(['Unassigned.batch'],$userPermissoins))
                                                        <button
                                                            data-id="{{$batch->order_id}}"
                                                            class="btn btn-danger btn-mb  delete"
                                                            data-toggle="modal"
                                                            title="unassign"
                                                            data-target="#deleteModal">U
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $i++?>
                                        @endforeach
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                    </aside>
                </div>
            </div>
            @include('front.layouts.includes.footer')
        </div>
    </main>

    <div class="modal fade" id="batch-delete-modal" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <!--model-append-html-main-wrap-open-->
            <div class="col-sm-12" id="delete-modal">
            </div>
            <!--model-append-html-main-wrap-close-->
        </div>
    </div>


    <div class="modal fade" id="batch-create-modal" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <!--model-append-html-main-wrap-open-->
            <div class="col-sm-12" id="model-zone-append-html-main-wrap">
            </div>

        </div>
    </div>

    <div class="modal fade" id="batch-assign-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <!--model-assign-to-joey-open-->
            <div class="col-sm-12" id="modal-assign-to-joey">
                <!--model-assign-to-joey-close-->
            </div>
        </div>
    </div>


    <div class="modal fade" id="transfer-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->

            <!--model-assign-to-joey-open-->
            <div class="col-sm-12" id="transfer-to-joey">
            </div>
            <!--model-assign-to-joey-close-->
        </div>
    </div>


    <div class="modal fade" id="batch-map-modal" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->

            <!--model-append-html-main-wrap-open-->
            <div class="col-sm-12" id="modal-map-html-main-wrap">
            </div>
            <!--model-append-html-main-wrap-close-->
        </div>
    </div>

@stop

@section('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script>
        $(document).on('click', '.delete', function () {
            let order_id = $(this).attr('data-id');
            $.ajax({

                type: "get",
                data: {order_id: order_id},
                url: "{{route('Unassigned.batch')}}",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //hideLoader();
                    // showing model and getting el of model
                    let model_el = $('#batch-delete-modal').modal();
                    // appending html of zone create
                    model_el.find('#delete-modal').html(response.html);
                },
                error: function (error) {
                    //hideLoader();
                    //ShowSessionAlert('danger', 'Something wrong');
                    console.log(error);
                }
            });

        });


        $(document).ready(function () {
            $('.vendor-list').select2({
                minimumInputLength: 2,
                placeholder: "Search a Vendor",
                allowClear: true,

                sorter: function (data) {

                    return data.sort(function (a, b) {
                        return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                    });
                }
            });

        });
    </script>
    <script>
        //Call Ajax For Delete Order History From Reattempt and Return


        $(document).on('click', '.valueformap', function (e) {
            var Batchid = $(this).attr('data-value');

            $.ajax({

                type: "get",
                data: {Batchid: Batchid},
                url: "{{route('map.view')}}",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //hideLoader();
                    // showing model and getting el of model
                    let model_el = $('#batch-map-modal').modal();
                    // appending html of zone create
                    model_el.find('#modal-map-html-main-wrap').html(response.html);
                },
                error: function (error) {
                    //hideLoader();
                    // ShowSessionAlert('danger', 'Something wrong');
                    console.log(error);
                }
            });
        });


        //Call to open modal
        $(document).on('click', '.batch-create', function (e) {
            $.ajax({
                type: "get",
                url: "{{route('batch-create-model-html-render')}}",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //hideLoader();
                    // showing model and getting el of model
                    let model_el = $('#batch-create-modal').modal();
                    // appending html of zone create
                    model_el.find('#model-zone-append-html-main-wrap').html(response.html);
                },
                error: function (error) {
                    //hideLoader();
                    //ShowSessionAlert('danger', 'Something wrong');
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.batch-assign', function (e) {
            var BatchId = $(this).attr('data-value');

            $.ajax({

                type: "get",
                data: {BatchId: BatchId},
                url: "{{route('assign.batch.joey')}}",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    //hideLoader();
                    // showing model and getting el of model
                    let model_el = $('#batch-assign-modal').modal();
                    // appending html of zone create
                    model_el.find('#modal-assign-to-joey').html(response.html);
                },
                error: function (error) {
                    //hideLoader();
                    //ShowSessionAlert('danger', 'Something wrong');
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.transfer-batch', function (e) {
                var BatchId = $(this).attr('data-value');

                $.ajax({

                    type: "get",
                    data: {BatchId: BatchId},
                    url: "{{route('transfer.batch.joey')}}",
                    beforeSend: function (request) {

                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (response) {
                        //hideLoader();
                        // showing model and getting el of model
                        let model_el = $('#transfer-modal').modal();
                        // appending html of zone create
                        model_el.find('#transfer-to-joey').html(response.html);

                    },
                    error: function (error) {
                        //hideLoader();
                        //ShowSessionAlert('danger', 'Something wrong');
                        console.log(error);
                    }
                });
            }
        );
        //multiple delete
        $(document).ready(function () {


               $('#master').on('click', function (e) {
                   if ($(this).is(':checked', true)) {

                       $(".sub_chk").prop('checked', true);
                   } else {
                       $(".sub_chk").prop('checked', false);
                   }
               });
            // $(document).on('click', '#master', function () {
            //
            //     if ($(this).val() == 'Select') {
            //         $('.button input').prop('checked', true);
            //         $(this).val('Deselect');
            //     } else {
            //         $('.button input').prop('checked', false);
            //         $(this).val('Select');
            //     }
            // });


            $('.delete_all').on('click', function (e) {


                var allVals = [];
                $(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });


                if (allVals.length <= 0) {

                    alert("Please select row.");
                } else {


                    // var check = confirm("Are you sure you want to delete this row?");
                    // if (check == true) {
                    var check = $.confirm({
                        boxWidth: '37%',
                        useBootstrap: false,

                        bootstrapClasses: {
                            container: 'modal-content',
                            row: 'row',
                            columnClass: 'col-sm-12',
                        },


                        title: ' <div class="col-sm-12 "><h2>Batch Unassigned</h2></div>',
                        content: ' <p class="">Are you sure to Unassigned selected Batch ? </p>  <div class="modal-footer col-sm-12"> </div> ',
                        buttons: {
                            'confirm': {
                                text: 'Proceed',

                                btnClass: 'btn btn-primary',
                                action: function () {

                                    var join_selected_values = allVals.join(",");


                                    $.ajax({
                                        url: "{{route('batch.delete.all')}}",
                                        type: 'GET',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids=' + join_selected_values,

                                        success: function (data) {
                                            if (data['success']) {
                                                $(".sub_chk:checked").each(function () {
                                                    $(this).parents("tr").remove();
                                                });
                                                // alert(data['success']);
                                            } else if (data['error']) {
                                                alert(data['error']);
                                            } else {
                                                alert('Whoops Something went wrong!!');
                                            }
                                        },
                                        error: function (data) {
                                            alert(data.responseText);
                                        }
                                    });


                                    $.each(allVals, function (index, value) {
                                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                                    });
                                    $.alert({
                                        boxWidth: '37%',
                                        useBootstrap: false,

                                        bootstrapClasses: {
                                            container: 'modal-content',
                                            row: 'row',
                                            columnClass: 'col-sm-12',
                                        },


                                        title: ' <div class="col-sm-12 "><h2>Batches Unassigned successfuly</h2></div>',
                                        content: ' <p>Selected Batches has been unassigned </p>  <div class="modal-footer col-sm-12"> </div> ',
                                        buttons: {
                                            'Ok': {
                                                btnClass: 'btn btn-primary btn-sm mb-fluid',
                                                },
                                        }
                                    });
                                }
                            },

                            cancel: function () {
                                'btn btn-primary btn-sm mb-fluid ';
                                // $.alert('Canceled!');
                            },


                        }
                    });


                }
                // }
            });


        });
    </script>
@stop

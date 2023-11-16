@extends('front.layouts.Dispatch-layout')

@section('page-title',"Edit Batch")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
</script>

<script>

    $(document).ready(function () {

        $("#btn_dis").attr('disabled', true)

        $("#Selectdate").change(function () {

            var date = $("#Selectdate").val();
            var order_id = $("#order_id").val();
            var storenum = $("#storenum").val();
            $("#loading").show();


            $.ajax({
                type: "get",
                data: {'date': date, 'storenum': storenum, 'order_id': order_id},
                url: "{{route('edit.ajax')}}",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));

                },
                success: function (result) {
                    // result = JSON.parse(result)
                    console.log(result.index);
                    result.body.forEach((key) => {
                        // alert(key.id);
                        $('.joeys').append('<option  value="' + key + '"> CR-' + key + '</option>')
                        $("#btn_dis").prop('disabled', false)

                    });
                    // $('#dispatch_id').val(result.dispatch.id);
                    $('#sprint').val(result);

                    // $('.CR-num').text(result.dispatch.num)
                },


                error: function (error) {
                    console.log(error);

                },
                complete: function () {
                    //back to normal!
                    // $("#btn_dis").attr('disabled', false)
                    $("#loading").hide();
                        // $('#ajax_loader').hide();
                        // modal.dialog('close');
                }
            });
        });

    });
</script>
<style>
    #spinner {
        display: block;
        margin: 20% 0 0 45%;
        width: 180px;
        height: 180px;
        text-align: center;
        color: #e46d29;

    }


    .customLastchild {
        display: grid;
        grid-gap: 2%;
        grid-template-columns: 49% 49%;
        width: 100% !important;
        align-items: center;
        float: left;
        min-width: 100%;
    }

    .custmSmBtn {
        margin-top: 10px;
    }
    #loading {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
    }

    /*#loading-image {*/
    /*    position: absolute;*/
    /*    top: 100px;*/
    /*    left: 240px;*/
    /*    z-index: 100;*/
    /*}*/
</style>
@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div id="loading">

        <div class="spinner-border loader" id="spinner">

        </div>
            Loading....
        </div>
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->


            <div id="main_content_area">
                <div class="row no-gutters">
                    <aside id="right_content" class="col-12 col-lg-12">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Edit Batch Orders </h1>
                                    <h3> Batch ID- <span>{{$batchId->id}}</span></h3>
                                </div>
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
                                    </div>
                                </div>
                                <div class="custom_col" style="width: 1530px; margin: 0 auto;">
                                    <div class="form-group no-min-h " style="width: 175px;     padding: 4px 0px 7px 0;">
                                      <span class="table_slector "><label>Select Date</label>
                                          <input type="date" name="date" id="Selectdate" value=""
                                                 class="form-control date-search form-control-lg"
                                                 placeholder="Search Customer Data"/></span>

                                    </div>
                                    <table
                                        class="table table-striped table-responsive tbl-responsive mb_last_row_hightlight mb_last_row_center custmRespons"
                                        id="myTable">
                                        <thead>
                                        <tr>
                                            <th style="width: 7%" scope="col">Order ID</th>
                                            <th style="width: 7%" scope="col">Drop Off Address</th>
                                            <th style="width: 10%" scope="col">ETA Time</th>
                                            <th style="width: 10%" scope="col">Window</th>
                                            <th style="width: 20%" scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($BatchOrderData as $batch)
                                            <form action="{{route('edit-batch.update' , $batchId->id)}}" method="POST"
                                                  class="form-horizontal" role="form" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{($batchId->id)}}">
                                                <input type="hidden" id="storenum" name="storenum"
                                                       value="{{($batchId->store_num)}}">
                                                <tr>
                                                    <input type="hidden" name="oldvalue[]" id="order_id"
                                                           value="{{$batch->order_id}}">
                                                    <td>{{"CR-" . $batch->order_id}}</td>
                                                    @if(isset($batch->dropoffLocation->location->address) ? $batch->dropoffLocation->location->address: 'No Address given')
                                                        <td>
                                                            <ul class="no-list attr-list">
                                                                @if(isset($batch->dropoffLocation->SprintContacts->name) ? $batch->dropoffLocation->SprintContacts->name: 'No Address given')
                                                                    <li><i class="icofont-user"></i>
                                                                        {{$batch->dropoffLocation->SprintContacts->name}}
                                                                    </li>@endif
                                                                <li><i class="icofont-google-map"></i>
                                                                    {{$batch->dropoffLocation->location->address .', '.
                                                                      $batch->dropoffLocation->location->city->name.', '.
                                                                      $batch->dropoffLocation->location->postal_code }}
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if(isset($batch->dropoffLocation->eta)?$batch->dropoffLocation->eta:'no')
                                                            {{   date('Y-m-d - h:i:s a' ,  $batch->dropoffLocation->due_time)}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($batchId->start_time, $batchId->end_time) ?$batchId->start_time.'-'.$batchId->end_time: 'not found')
                                                            {{$batchId->start_time.'-'.$batchId->end_time}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="form-group col-12 col-md-3 no-min-h customLastchild"
                                                             style="display: block;">
                                                            <span class="table_slector" style="display: flex;">
                                                                <label for="SprintOrder"
                                                                       style="display: inline-block;width: 24%;">Order Id</label>
                                                                    <select name="SprintOrders[]"
                                                                            class="form-control form-control-lg role-type joeys"
                                                                            required style="width: 170px;">
                                                                         <option value="{{$batch->order_id}}"
                                                                                 selected> {{'CR-'. $batch->order_id}}</option>
                                                                    </select>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <button
                                        style="position: absolute;margin-top: 1%;padding: 1% 2%;"
                                        class=" btn btn-primary btn-xs mb-fluid " id="btn_dis">Update
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>
            </div>
            @include('front.layouts.includes.footer')

        </div>
    </main>
@stop
@section('script')


@stop

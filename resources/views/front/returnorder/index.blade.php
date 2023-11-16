@extends('front.layouts.Dispatch-layout')

@section('page-title',"Dispatch Orders")

@section('css')
    <style>
        /*my css*/
        .pagination {
            margin-top: 30px;
        }

        .pagination li.disabled {
            opacity: 0.5;
        }

        .pagination li a {
            text-decoration: none;
            color: #443404;
        }

        .pagination li.active .page-link {
            background: #e46d29 !important;
            color: #ffffff !important;
            border: none;
        }

        .pagination {
        }
        .tab_link.active a {
            color: #e46d29 !important;
            text-decoration: none !important;
        }
        th, td {
            padding: 15px 25px !important;
        }
        .table td {
            line-height: 1.5em;
            vertical-align: baseline;
        }
    </style>
@stop

@section('content')
    <main id="main" class="page-dispatch" data-page="dispatch">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-12">
                        <div class="inner">


                            <section class="section-content summary-section no-border">
                                <div class="section-inner">
                                    <div class="grid_controls">
                                        <div class="row align-items-end">
                                            <div class="col-12 col-sm-8">
                                                <div class="needs-validation grid_sort_controls" novalidate>

                                                        {{-- The form should be remove --}}
                                                        <form method="get" action="">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Start</label>
                                                                        <input type="date" name="start" class="data-selector form-control" value="{{ isset($_GET['start'])?$_GET['start']: date('Y-m-d') }}">

                                                                    </div>
                                                                </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>End</label>
                                                                            <input type="date" name="end" class="data-selector form-control" value="{{ isset($_GET['end'])?$_GET['end']: date('Y-m-d') }}">

                                                                        </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <button type="submit" class="btn btn-primary " style="
    margin: 30px;
    font-size: 14px;
    line-height: 12px;
    padding-top: 11px;">Search</button>
                                                                </div>

                                                            </div>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Grid action modals [Start] -->
                                @include('front.layouts.includes.orderActions')
                                <!-- Grid action modals [/end] -->
                                    <div class=table-responsive>
                                        <table
                                            class="table tbl-responsive table-striped mb_last_row_hightlight dispatch-orders">
                                            <thead>
                                            <tr>
                                                <th scope="col" width="15%">ID</th>
                                                <th scope="col" width="20%">Joey</th>
                                                <th scope="col" width="20%">Order Count</th>
                                                <th scope="col" width="15%">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php $append_record = [];$counter=0;?>
                                            @foreach($ReturnData as $data)
                                                <tr>
                                                    <td id="return-id">{{++$counter}}</td>
                                                    <td >{{$data->first_name}} {{$data->last_name}} ({{$data->joey_id}} )</td>
                                                    <td >{{$data->count}}
                                                    </td>
                                                    <td style="height: 10px" >
                                                            <a class="btn btn-secondary" id="detail" style="
    padding: 14px;
    font-size: 14px;
    line-height: 12px;
    padding-top: 11px;"  href="detail-return-orders?id={{$data->joey_id}}&start={{ isset($_GET['start'])?$_GET['start']: date('Y-m-d') }}&end={{ isset($_GET['end'])?$_GET['end']: date('Y-m-d') }}">Detail</a>
                                            </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </aside>
                </div>
            </div>

            @include('front.layouts.includes.footer')
        </div>
    </main>
@stop

@section('js')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $( document ).ready(function() {

            $(document).on('click','#approve',function (){
                var id = $(this).val();
                console.log(id);

                const swalWithBootstrapButtons = swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want to mark it as approved?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes,I payed!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'approve-orders',
                            type:'GET',
                            data:{
                                "id": id,
                            },
                            success: function(response){
                                if(response == 1){
                                    alert('Approved Successfully');
                                    window.location.reload();
                                }else{
                                    alert('Approval failed');
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        }) //Submit Approve End here...




                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'I dont Need:)',
                            'Done'
                        )
                    }
                })
            })

            $(document).on('click','#detail',function (){
                var id = $(this).val();
                console.log(id);

                $.ajax({
                    url: 'detail-return-orders',
                    type:'GET',
                    data:{
                        "id": id,
                    },
                    success: function(response){
                        if(response == 1){
                            alert('Approved Successfully');
                            window.location.reload();
                        }else{
                            alert('Approval failed');
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                }) //Submit Approve End here...


            })
        });
    </script>
@stop

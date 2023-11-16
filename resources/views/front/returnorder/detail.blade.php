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
        .cardsDivider {
            float: none;
            width: 80%;
            display: table;
            margin: 0 auto;
        }
        .cuutomOder li {
            margin-bottom: 6px;
            display: flex;
            /*justify-content: space-between;*/
        }
        .cuutomOder li span:first-child{
            font-weight: 700;
        }
        .cuutomOder li span {
            width: 50%;
        }
        .cuutomOder {
            padding-top: 20px;
        }
        .dividerCol {
            position: relative;
        }
        .cardsCounts {
            position: absolute;
            top: 0;
            right: 0;
            background: #e46d29;
            height: 30px;
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 16px;
            border-radius: 0 5px 0 5px;
        }
        .extend_button {
            display: flex;
            width: unset;
            padding: 7px 30px !important;
            margin-top: 10px;
            font-size: 14px !important;
            background: #e46d29;
            color: #fff !important;
            position: relative;
            align-items: center;
        }
        .extend_button:after {
            content: "\203A";
            width: 18px;
            transform: rotate(90deg);
            display: inline-block;
            font-size: 30px;
            height: 30px;
            line-height: 16px;
        }
        .upper_accordion .extend_button:after {
            content: "\203A";
            transform: rotate(-90deg);
            display: inline-flex;
            justify-content: center;
            align-items: end;
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

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Grid action modals [Start] -->
                                @include('front.layouts.includes.orderActions')
                                        <?php $counter = 1 ?>
                                    @foreach($DetailData as $data_x)
                                        <div class="cardsDivider" style="margin-bottom: 30px">

                                            <div class="shadow p-3 mb-5 bg-white rounded dividerCol">
                                                <span class="cardsCounts"><?php echo $counter++;?></span>
                                            <h4>Order Id: <span class="return-order-detail">{{$data_x->id}}</span></h4>
                                           <ul class="cuutomOder">
                                               <li><span>Vendor:</span> <span class="return-order-detail">{{$data_x->name}}</span></li>
                                               <li><span>Status:</span> <span class="return-order-detail"><?php echo getStatusCodesWithKey('status_labels.' . $data_x->status_id) ?></span></li>
                                               <li><span>Pickup Address:</span> <span class="return-order-detail">{{$data_x->pickupLocation->address}} , {{$data_x->pickupLocation->postal_code}}</span></li>
                                               <li><span>Dropoff Address:</span> <span class="return-order-detail">{{$data_x->dropoffLocation->address }} , {{$data_x->dropoffLocation->postal_code}}</span></li>
                                               <?php
                                               if(!empty($data_x->getDropoffImage->attachment_path)){
                                                   $ref = $data_x->getDropoffImage->attachment_path;
                                               }else{
                                                   $ref = '';
                                               }

                                               if(isset($data_x->getDropoffImage['created_at']) and !empty($data_x->getDropoffImage['created_at'])){
                                                   $date = $data_x->getDropoffImage['created_at'];
                                               }else{
                                                   $date = '';
                                               }
                                               ?>
                                               <li><span>Return Date :</span> <span class="return-order-detail">{{$date}}</span></li><br>
                                               <li><span>Dropoff Image :</span>
                                                  <?php if($ref != ''){?>
                                                       <img src="{{$ref}}" height="200px" width="200px">
                                                   <?php }else{?>
                                                       <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNzUycHQiIGhlaWdodD0iNzUycHQiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDc1MiA3NTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiA8cGF0aCBkPSJtNTI3LjU1IDI0My40aC0zMDMuMDljLTUuMDI3MyAwLTkuODQzOCAxLjk5NjEtMTMuMzk1IDUuNTQ2OS0zLjU1NDcgMy41NTQ3LTUuNTUwOCA4LjM3MTEtNS41NTA4IDEzLjM5OHYyMjcuMzJjMCA1LjAyMzQgMS45OTYxIDkuODQzOCA1LjU1MDggMTMuMzk1IDMuNTUwOCAzLjU1NDcgOC4zNjcyIDUuNTUwOCAxMy4zOTUgNS41NTA4aDMwMy4wOWM1LjAyMzQgMCA5Ljg0MzgtMS45OTYxIDEzLjM5NS01LjU1MDggMy41NTQ3LTMuNTUwOCA1LjU1MDgtOC4zNzExIDUuNTUwOC0xMy4zOTV2LTIyNy4zMmMwLTUuMDI3My0xLjk5NjEtOS44NDM4LTUuNTUwOC0xMy4zOTgtMy41NTA4LTMuNTUwOC04LjM3MTEtNS41NDY5LTEzLjM5NS01LjU0Njl6bS00MC42MzMgMzUuNTJjNS44NjcyIDAgMTEuNDkyIDIuMzI4MSAxNS42MzcgNi40NzY2IDQuMTQ4NCA0LjE0ODQgNi40ODA1IDkuNzczNCA2LjQ4MDUgMTUuNjQxIDAgNS44NjMzLTIuMzMyIDExLjQ4OC02LjQ4MDUgMTUuNjM3LTQuMTQ0NSA0LjE0ODQtOS43Njk1IDYuNDc2Ni0xNS42MzcgNi40NzY2LTUuODY3MiAwLTExLjQ5Mi0yLjMyODEtMTUuNjM3LTYuNDc2Ni00LjE0ODQtNC4xNDg0LTYuNDgwNS05Ljc3MzQtNi40ODA1LTE1LjYzNyAwLTUuODY3MiAyLjMzMi0xMS40OTIgNi40ODA1LTE1LjY0MSA0LjE0NDUtNC4xNDg0IDkuNzY5NS02LjQ3NjYgMTUuNjM3LTYuNDc2NnptNDYuNTA0IDIwMC44OXYtMC4wMDM5MDZjMCA0LjM5ODQtMS43NDYxIDguNjEzMy00Ljg1MTYgMTEuNzIzLTMuMTA5NCAzLjEwOTQtNy4zMjQyIDQuODU1NS0xMS43MjMgNC44NTU1aC0yODEuNjhjLTQuMzk4NCAwLTguNjEzMy0xLjc0NjEtMTEuNzIzLTQuODU1NXMtNC44NTU1LTcuMzI0Mi00Ljg1NTUtMTEuNzIzdi01NC4yN2MtMC4wMzUxNTYtNC4zNzUgMS42NjgtOC41ODIgNC43MzgzLTExLjY5OWw4My4zNTItODMuMzk4aC0wLjAwMzkwNmMzLjE1NjItMy4wMTk1IDcuMzU1NS00LjcwMzEgMTEuNzIzLTQuNzAzMXM4LjU2NjQgMS42ODM2IDExLjcyMyA0LjcwMzFsNjEuODk1IDYxLjgwNSAzMC43MzQtMzAuNzM0YzMuMTA5NC0zLjEwOTQgNy4zMjgxLTQuODU1NSAxMS43MjMtNC44NTU1IDQuMzk0NSAwIDguNjEzMyAxLjc0NjEgMTEuNzIzIDQuODU1NWw4Mi4zNTUgODIuMzU1YzMuMDY2NCAzLjExMzMgNC43Njk1IDcuMzI0MiA0LjczNDQgMTEuNjk1eiIvPgo8L3N2Zz4K" height="200px" width="200px">
                                                     <?php
                                                  }?>

                                               </li>
                                           </ul>
                                        </div>

                                            <h5 style="clear:both;text-align:left" class="accordion">
                                                <button class="btn btn-xs orange-gradient extend_button color:#000 !important;">Status History <i class="fa fa-angle-down"></i></button>
                                            </h5>
                                            <table id="main" class="table table-striped table-bordered panel" style="display: none">
                                                <thead>
                                                <tr>
                                                    <th id="main">Status Id</th>
                                                    <th id="main">Description</th>
                                                    <th id="main">Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $count = 0?>
                                                @foreach($data_x->getTaskHistory as $x)
                                                    <tr>
                                                        <td>{{$x->status_id}}</td>
                                                        <td><?php echo getStatusCodesWithKey('status_labels.' . $x->status_id) ?></td>
                                                        <td>{{$x->date}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>


                                    @endforeach
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

            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function () {
                    this.classList.toggle('upper_accordion');
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "inline-table") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "inline-table";
                    }
                });
            }
        });
    </script>
@stop

@extends('front.layouts.Dispatch-layout')

@section('page-title',"Today Schedule")

@section('css')
    <style>
        /*my css*/
        .img-thumbnail {
            width: 80px;
            height: 60px;
        }

        .date-search {
            padding-top: 25px;
            padding-bottom: 20px;
        }

        .search-btn {
            padding: 15px !important;
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
                @include('front.schedule.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Order Notes</h1>
                                </div>
                            </div>
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>
                            <section class="section-content summary-section">
                                <div class="section-inner">
                                    <hr>
                                    <h3>Notes</h3>
                                    <table
                                        class="table table-striped tbl-responsive mb_last_row_hightlight mb_last_row_center">
                                        <thead>
                                        <tr>
                                            <th width="8%" scope="col" class="valing-middle">ID</th>
                                            <th width="8%" scope="col" class="valing-middle">Order Id</th>
                                            <th width="10%" scope="col" class="valing-middle">Creator Name</th>
                                            <th width="12%" scope="col" class="valing-middle">Notes</th>
                                            <th width="20%" scope="col" class="valing-middle">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($orderNotes as $notes)
                                            <tr>
                                                <td class="valing-middle">{{ $notes->id }}</td>
                                                <td class="valing-middle">
                                                    <span class="bold basecolor1">{{ $notes->object_id }}</span>
                                                </td>
                                                <td class="valing-middle">{{ auth()->user()->name }}</td>
                                                <td class="valing-middle">{{ $notes->note }}</td>
                                                <td class="valing-middle">delete</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

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

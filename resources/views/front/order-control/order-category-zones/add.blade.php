@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Type Create")

@section('css')
    <style>
        /*my css*/
    </style>
@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
            <div id="main_content_area">
                <div class="row no-gutters">
                @include('front.order-control.sidebar')
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Zone Routing</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('order_zone_routing.store') }}" id="account-form"
                                  class="needs-validation" novalidate role="form" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Enter Title" id="title" name="title" required>
                                                @if ($errors->has('title'))
                                                    <span class="help-block">
								                        <strong>{{ $errors->first('title') }}</strong>
								                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a title.
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="zone_type_id">Zone type</label>
                                                <select name="zone_type_id" id="" class="form-control form-control-lg"
                                                        required>
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($zoneTypes as $zoneType)
                                                        <option value="{{$zoneType->id}}">{{$zoneType->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('zone_type_id'))
                                                    <span class="help-block">
							    	                    <strong>{{ $errors->first('zone_type_id') }}</strong>
								                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a zone type.
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="hub_id">Hub</label>
                                                <select name="hub_id" id="" class="form-control form-control-lg"
                                                        required>
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($hubs as $hub)
                                                        <option value="{{$hub->id}}">{{$hub->title}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('hub_id'))
                                                    <span class="help-block">
								                        <strong>{{ $errors->first('hub_id') }}</strong>
								                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a hub.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row fieldGroup">

                                            <div class="form-group col-md-4 no-min-h">
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Enter Postal Code" id="postal_code"
                                                       name="postal_code[]" required>
                                            </div>
                                            <div class="input-group-addon col-md-2">
                                                <a href="javascript:void(0)"
                                                   class="btn btn-success btn-sm addMore"><span
                                                            class="glyphicon glyphicon glyphicon-plus"
                                                            aria-hidden="true"></span> Add</a>
                                            </div>
                                        </div>

                                        <div class="row fieldGroupCopy" style="display: none;">
                                            <div class="form-group col-md-4 no-min-h">
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Enter Postal Code" id="postal_code"
                                                       name="postal_code[]">
                                            </div>
                                            <div class="input-group-addon">
                                                <a href="javascript:void(0)" class="btn btn-danger remove"><span
                                                            class="glyphicon glyphicon glyphicon-remove"
                                                            aria-hidden="true"></span> Remove</a>
                                            </div>
                                        </div>
                                        @if(session('error'))
                                            <div class="alert alert-danger">{{session('error')}}</div>
                                        @endif

                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Add Zones</button>
                                </div>
                            </form>
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
        $(document).ready(function () {
            //group add limit
            var maxGroup = 10;

            //add more fields group
            $(".addMore").click(function () {
                if ($('body').find('.fieldGroup').length < maxGroup) {
                    var fieldHTML = '<div class="row fieldGroup">' + $(".fieldGroupCopy").html() + '</div>';
                    $('body').find('.fieldGroup:last').after(fieldHTML);
                } else {
                    alert('Maximum ' + maxGroup + ' groups are allowed.');
                }
            });

            //remove fields group
            $("body").on("click", ".remove", function () {
                $(this).parents(".fieldGroup").remove();
            });
        });
    </script>
@stop
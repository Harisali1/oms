@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Type Edit")

@section('css')
    <style>
        /*my css*/
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
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Delivery Type Edit</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('delivery_type.update', $deliveryType->id) }}"
                                  class="form-horizontal" role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="title">Delivery Type *</label>
                                                <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                                                       placeholder="Enter Delivery Type"
                                                       value="{{ old('title', $deliveryType->title) }}" id="title" name="title">
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('title'))
                                                        {{ $errors->first('title') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update
                                    </button>
                                    <a href="{{route('delivery_type.index')}}"><button type="button" class="btn btn-primary" style="background-color: #bad709!important;">Cancel</button></a>
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
    {{--<script>--}}
        {{--$(document).ready(function () {--}}

            {{--make_option_selected('.role-type', '{{ old('role',$sub_admin->role_id) }}');--}}
        {{--});--}}
    {{--</script>--}}
@stop

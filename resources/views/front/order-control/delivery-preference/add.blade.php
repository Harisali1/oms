@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Preference Create")

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
                                    <h1 class="lh-10">Add Delivery Preference</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('delivery_preference.store') }}" id="account-form"
                                  class="needs-validation" novalidate role="form" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="title">Delivery Preference *</label>
                                                <input type="text"
                                                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                                                       placeholder="Enter Delivery Preference" id="title" name="title" required>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('title'))
                                                        {{ $errors->first('title') }}
                                                    @else
                                                        Please provide delivery preference
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Add
                                    </button>
                                    <a href="{{route('delivery_preference.index')}}">
                                        <button type="button" class="btn btn-primary"
                                                style="background-color: #bad709!important;">Cancel
                                        </button>
                                    </a>
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
    </script>
@stop

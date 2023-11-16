@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Type Create")

@section('css')
    <style>
        .select2-search__field {
            padding: 18px !important;
        }

        .time-slot {
            padding: 18px !important;
        }
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
                                    <h1 class="lh-10">Order Category Control</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('order_category.store') }}" id="account-form"
                                  class="needs-validation" novalidate role="form" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Order Category *</label>
                                                <select id="order_category_id" class="form-control select2 @error('order_category_id') is-invalid @enderror" name="order_category_id[]"
                                                        data-placeholder="Please Select Option"  multiple required>

                                                    @if ($errors->has('order_category_id'))
                                                        <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('order_category_id') }}</p>
								                    </span>
                                                    @endif
                                                    <option value="">please select</option>
                                                    @foreach($orderCategories as $key => $name)
                                                        <option value="{{$name->id}}"
                                                                {{ (old('order_category_id') == null ? '' : in_array($name->id ,old('order_category_id')) ? "selected":"") }}>
                                                            {{$name->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
{{--                                                <div class="invalid-feedback">--}}
{{--                                                    pelsae select--}}
{{--                                                </div>--}}
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('order_category_id'))
                                                        {{ $errors->first('order_category_id') }}
                                                    @else
                                                        Please provide a category
                                                    @endif
                                                </div>
{{--                                                @if ($errors->has('order_category_id'))--}}
{{--                                                    <span class="help-block">--}}
{{--								                        <p class="text-danger">{{ $errors->first('order_category_id') }}</p>--}}
{{--								                    </span>--}}
{{--                                                @endif--}}
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Delivery Types *</label>
                                                <select class="form-control select2" name="delivery_type_id[]"
                                                        data-placeholder="Please Select Option" multiple="multiple">
                                                    @foreach($deliveryTypes as $key => $name)
                                                        <option value="{{$name->id}}"
                                                                {{ (old('delivery_type_id') == null ? '' : in_array($name->id ,old('delivery_type_id')) ? "selected":"") }}>
                                                            {{$name->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('delivery_type_id'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('delivery_type_id') }}</p>
								                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Delivery Preferences *</label>
                                                <select class="form-control select2" name="delivery_preference_id[]"
                                                        data-placeholder="Please Select Option" multiple="multiple">
                                                    @foreach($deliveryPreferences as $key => $name)
                                                        <option value="{{$name->id}}"
                                                                {{ (old('delivery_preference_id') == null ? '' : in_array($name->id ,old('delivery_preference_id')) ? "selected":"") }}>
                                                            {{$name->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('delivery_preference_id'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('delivery_preference_id') }}</p>
								                    </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Zones *</label>
                                                <select class="form-control select2" name="zone_id[]"
                                                        data-placeholder="Please Select Option" multiple="multiple">
                                                    @foreach($zones as $key => $name)
                                                        <option value="{{$name->id}}"
                                                                {{ (old('zone_id') == null ? '' : in_array($name->id ,old('zone_id')) ? "selected":"") }}>
                                                            {{$name->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('zone_id'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('zone_id') }}</p>
								                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Start Time *</label>
                                                <input type="time" class="form-control time-slot" name="start_time"
                                                       id="start_time" value="{{ old('start_time') }}" required>
                                                @if ($errors->has('start_time'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('start_time') }}</p>
								                    </span>
                                                @endif
                                            </div>


                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">End Time *</label>
                                                <input type="time" class="form-control time-slot" name="end_time"
                                                       id="end_time" value="{{ old('end_time') }}" required>
                                                @if ($errors->has('end_time'))
                                                    <span class="help-block">
								                        <p class="text-danger">{{ $errors->first('end_time') }}</p>
								                    </span>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Add</button>
                                    <a href="{{route('order_category.index')}}"><button type="button" class="btn btn-primary" style="background-color: #bad709!important;">Cancel</button></a>
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
            $('.select2').select2();

        });
    </script>
@stop

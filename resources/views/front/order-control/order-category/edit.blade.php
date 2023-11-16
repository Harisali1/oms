@extends('front.layouts.Dispatch-layout')

@section('page-title',"Delivery Type Create")

@section('css')
    <style>
        .select2-search__field{
            padding: 18px!important;
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
                                    <h1 class="lh-10">Edit Category Control</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('order_category.update', $orderZone) }}" id="account-form"
                                  class="needs-validation" novalidate role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Order Category</label>
                                                <select class="form-control select2" name="order_category_id[]" data-placeholder="Please Select Option" multiple="multiple" >
                                                    @foreach($orderCategories as $key => $category)
                                                        <option value="{{$category->id}}"
                                                                {{ ($orderZone->category->id == $category->id) ? 'selected' : null }}>
                                                            {{$category->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Delivery Types</label>
                                                <select class="form-control select2" name="delivery_type_id[]" data-placeholder="Please Select Option" multiple="multiple" >
                                                    @foreach($deliveryTypes as $key => $deliveryType)
                                                        <option value="{{$deliveryType->id}}"
                                                                {{ ($orderZone->category->deliveryType->pluck('id')->contains($deliveryType->id)) ? 'selected' : null }}>
                                                            {{$deliveryType->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Delivery Preferences</label>
                                                <select class="form-control select2" name="delivery_preference_id[]" data-placeholder="Please Select Option" multiple="multiple" >
                                                    @foreach($deliveryPreferences as $key => $deliveryPreference)
                                                        <option value="{{$deliveryPreference->id}}"
                                                                {{ ($orderZone->category->deliveryPreference->pluck('id')->contains($deliveryPreference->id)) ? 'selected' : null }}>
                                                            {{$deliveryPreference->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Zones</label>
                                                <select class="form-control select2" name="zone_id[]" data-placeholder="Please Select Option" multiple="multiple" >
                                                    @foreach($zones as $key => $zone)
                                                        <option value="{{$zone->id}}"
                                                                {{ ($orderZone->category->orderCategoryZone->pluck('id')->contains($zone->id)) ? 'selected' : null }}>
                                                            {{$zone->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">Start Time</label>
                                                <input type="time" class="form-control time-slot" name="start_time"
                                                       id="start_time" required value="{{ (!empty($orderZone)) ? $orderZone->start_time : '' }}">
                                            </div>

                                            <div class="form-group col-12 col-md-4 no-min-h">
                                                <label for="permission">End Time</label>
                                                <input type="time" class="form-control time-slot" name="end_time"
                                                       id="end_time" required value="{{ (!empty($orderZone)) ? $orderZone->end_time : ''}}">
                                            </div>

                                        </div>

                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update</button>
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
        $(document).ready(function() {
            $('.select2').select2();

        });
    </script>
@stop
<aside id="left_sidebar" class="col-12 col-lg-3">
    <div class="inner">
        <div class="widget_sidebar d-lg-block">
            <nav class="sidebar_nav">
                <ul class="no-list">
                    @if(can_access_route(['delivery_type.index'],$userPermissoins))
                        <li class="{{ (Request::segment(1) == 'delivery_type') ? 'active' : '' }}"><a href="{{url('delivery_type')}}">Delivery Types</a></li>
                    @endif
                    @if(can_access_route(['delivery_preference.index'],$userPermissoins))
                        <li class="{{ (Request::segment(1) == 'delivery_preference') ? 'active' : '' }}"><a href="{{route('delivery_preference.index')}}">Delivery Preferences</a></li>
                    @endif
                    {{--@if(can_access_route(['order_zone_routing.index'],$userPermissoins))--}}
                        {{--<li><a href="{{url('order_zone_routing')}}">Order Zones</a></li>--}}
                    {{--@endif--}}
                    @if(can_access_route(['order_category.index'],$userPermissoins))
                        <li class="{{ (Request::segment(1) == 'order_category') ? 'active' : '' }}"><a href="{{url('order_category')}}">Order Category Control</a></li>
                    @endif

                    {{--@if(can_access_route(['order_category_zones.index'],$userPermissoins))--}}
                        {{--<li><a href="{{url('order_category_zones')}}">Order Category Zones</a></li>--}}
                    {{--@endif--}}
                </ul>
            </nav>
        </div>
    </div>
</aside>
<header id="header">
    <div class="container-fluid">
        <div class="row-1 row align-items-center">
            <div class="col-6 col-md-3 col-lg-2">
                <div id="logo">
{{--                    <img src="{{ asset('assets/front/assets/images/logo-main.png') }}" alt="Joeyco">--}}
                </div>
            </div>


            <div class="col-12 col-md-6 col-lg-8" id="main-nav">
                <nav class="main-nav-wrap">
                    <div class="menu-close-btn d-block d-lg-none"><i class="icofont-close"></i></div>
                    <ul class="no-list">
                        <li><a href="{{url('dashboard')}}" class="align-items-center">Dashboard</a></li>

{{--                        @if(can_access_route(['role.index'],$userPermissoins))--}}
{{--                        <li class="{{ request()->routeIs('role.*') ? 'active' : null }}">--}}
{{--                            <a href="{{url('role')}}" class="align-items-center">Roles</a>--}}
{{--                        </li>--}}
{{--                        @endif--}}
{{--                        @if(can_access_route(['sub-admin.index'],$userPermissoins))--}}
{{--                        <li class="{{ request()->routeIs('sub-admin.*') ? 'active' : null }}">--}}
{{--                            <a href="{{url('sub-admin')}}" class="align-items-center">Sub Admins</a>--}}
{{--                        </li>--}}
{{--                        @endif--}}
                        <!--@if(can_access_route(['delivery_type.index'],$userPermissoins))-->
                        <!--    <li class="{{ request()->routeIs('delivery_type.*', 'delivery_preference.*', 'order_category.*') ? 'active' : null }}">-->
                        <!--        <a href="{{url('delivery_type')}}" class="align-items-center">Control</a>-->
                        <!--    </li>-->
                        <!--@endif-->
{{--                        @if(can_access_route(['delivery_type.index'],$userPermissoins))--}}
{{--                        <li><a href="#" class="align-items-center">Control <i class="icofont-rounded-down"></i></a>--}}
{{--                            <div class="sub-menu">--}}
{{--                                <ul>--}}
{{--                                    <li><a href="{{url('schedule')}}" class="align-items-center">Schedule</a></li>--}}
{{--                                    <li><a href="{{route('batch-order.index')}}">Batch List</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        @endif--}}
                        <!--@if(can_access_route(['schedule.index'],$userPermissoins))-->
                        <!--    <li class="{{ request()->routeIs('schedule.*', 'shift.publisher.*') ? 'active' : null }}">-->

                        <!--    </li>-->
                        <!--@endif-->
{{--                        @if(can_access_route(['job.route'],$userPermissoins))--}}
{{--                            <li><a href="{{url('jobs')}}" class="align-items-center">Routes</a></li>--}}
{{--                        @endif--}}
                        <!--@if(can_access_route(['joey.route.index'],$userPermissoins))-->
                        <!--    <li class="{{ request()->routeIs('job.*', 'joey.route.*') ? 'active' : null }}">-->
                        <!--        <a href="{{url('joey_routes')}}" class="align-items-center">Grocery Dispatch Routes</a>-->
                        <!--    </li>-->
                        <!--@endif-->
                        @if(can_access_route(['Grocery-Dispatch'],$userPermissoins))
                        <!--<li><a href="#" class="align-items-center">Dispatch <i class="icofont-rounded-down"></i></a>-->
                        <!--    <div class="sub-menu">-->
                        <!--        <ul>-->
                        <!--            <li><a href="{{route('Grocery-Dispatch')}}">Grocery Dispatchs</a></li>-->
                        <!--            <li><a href="{{route('E-Commerce-Dispatch')}}">E-commerce dispatch</a></li>-->
                        <!--            <li><a href="{{route('return-orders-get')}}">Return Orders</a></li>-->
                        <!--        </ul>-->
                        <!--    </div>-->
                        <!--</li>-->
                        @endif

                        @if(can_access_route(['Grocery-Dispatch'],$userPermissoins))
                            <li><a href="{{route('Grocery-Dispatch')}}">Orders</a></li>
                        @endif
                        <li><a href="{{url('logout')}}" class="align-items-center">Logout</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-6 col-md-9 col-lg-2 d-flex justify-content-end">
                <div id="userlogin-top" class="d-flex align-items-center justify-content-end">
                    <div class="info align-right d-none d-lg-block">
                        <div class="name semibold">{{$Admin_name}}</div>
                        {{--<a href="{{url('edit-profile')}}">View Profile</a>--}}
                    </div>
                    <div class="thumb small circle-radius link-wrap">
                        <a href="{{url('edit-profile')}}" class="link"></a>
                        <img src="{{ asset('assets/front/assets/images/thumb-1.jpg') }}" alt="">
                    </div>
                </div>

                <div class="menu-hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>

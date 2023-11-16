<aside id="left_sidebar" class="col-12 col-lg-3">
    <div class="inner">
        <div class="widget_sidebar d-lg-block">
            <nav class="sidebar_nav">
                <ul class="no-list">
                    @if(can_access_route(['joey.route.index'],$userPermissoins))
                        <li class="{{ request()->routeIs('joey.route.index') ? 'active' : null }}">
                            <a href="{{url('joey_routes')}}">Grocery Dispatch Route List</a>
                        </li>
                    @endif
                    @if(can_access_route(['job.route'],$userPermissoins))
                        <li class="{{ request()->routeIs('job.route') ? 'active' : null }}">
                            <a href="{{url('jobs')}}">Joey Grocery Route Map View</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</aside>

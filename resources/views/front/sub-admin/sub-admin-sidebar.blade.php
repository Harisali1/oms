<aside id="left_sidebar" class="col-12 col-lg-3">
    <div class="inner">
        <div class="widget_sidebar d-lg-block">
            <nav class="sidebar_nav">
                <ul class="no-list">
                    @if(can_access_route(['sub-admin.index'],$userPermissoins))
                        <li class="{{ request()->routeIs('sub-admin.index') ? 'active' : null }}">
                            <a href="{{url('sub-admin')}}">View All Sub Admins</a>
                        </li>
                    @endif
                    @if(can_access_route(['sub-admin.create'],$userPermissoins))
                        <li class="{{ request()->routeIs('sub-admin.create') ? 'active' : null }}">
                            <a href="{{route('sub-admin.create')}}">Add Sub Admin</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</aside>

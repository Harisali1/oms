<aside id="left_sidebar" class="col-md-12 col-lg-3 col-sm-12">
    <div class="inner">
        <div class="widget_sidebar d-lg-block">
            <nav class="sidebar_nav">
                <ul class="no-list">
                    @if(can_access_route(['role.index'],$userPermissoins))
                    <li class="{{ request()->routeIs('role.index') ? 'active' : null }}">
                        <a href="{{url('role')}}">View All Roles</a>
                    </li>
                    @endif
                    @if(can_access_route(['role.create'],$userPermissoins))
                    <li class="{{ request()->routeIs('role.create') ? 'active' : null }}">
                        <a href="{{route('role.create')}}">Add Role</a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</aside>

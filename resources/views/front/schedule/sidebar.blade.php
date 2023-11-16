<aside id="left_sidebar" class="col-12 col-lg-3">
    <div class="inner">
        <div class="widget_sidebar d-lg-block">
            <nav class="sidebar_nav">
                <ul class="no-list">
                    @if(can_access_route(['schedule.index'],$userPermissoins))
                        <li class="{{ (Request::segment(1) == 'schedule') ? 'active' : '' }}"><a href="{{url('schedule')}}">Schedule</a></li>
                    @endif
                    @if(can_access_route(['shift.publisher.index'],$userPermissoins))
                        <li class="{{ (Request::segment(2) == 'publisher') ? 'active' : '' }}"><a href="{{url('shift/publisher')}}">Schedule Publisher</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</aside>
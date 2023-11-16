<ul class="no-list d-flex flex-wrap dispatch_actions">
    {{-- Order States Stuck --}}

    @if($status == 115)
        @if(can_access_route(['assign.order'],$userPermissoins))
            <li>
                <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
                   class="btn btn-basecolor1 btn-mb" title="Map">M
                </a>
            </li>
        @endif
        @if(can_access_route(['sprint.cancel'],$userPermissoins))
            <li>
                <a data-toggle="modal" data-target="#cancel" href="#" class="btn btn-danger btn-mb"
                   onclick="cancelOrderPopUp({{ $sprint }},{{ $dispatch }}, {{ $status }})" title="Cancel">C
                </a>
            </li>
        @endif
        @if(can_access_route(['order.note'],$userPermissoins))
            <li>
                <a data-toggle="modal" data-target="#notes" href="#" onclick="showModalOfOrderNote({{ $sprint }})"
                   class="btn btn-basecolor1 btn-mb" title="Notes">N
                </a>
            </li>
        @endif
        @if(can_access_route(['order.notes'],$userPermissoins))
            <li>
                <a href="{{ route('order.notes', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
                   title="Order Notes">ON
                </a>
            </li>
        @endif
        <li>
            <a data-toggle="modal" data-target="#flag" href="#" class="btn btn-basecolor1 btn-mb" title="Flag">F</a>
        </li>
    @endif
    {{-- Order States New And Scheduled --}}

    @if($status == 13 || $status == 61)
        @if(can_access_route(['assign.order'],$userPermissoins))
            <li>
                <a data-toggle="modal" data-target="#assignJoeySprint" href="#" class="btn btn-basecolor1 btn-mb"
                   title="Assign Joey Sprint" onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})">A
                </a>
            </li>
        @endif
        @if(can_access_route(['edit.order'],$userPermissoins))
            <li>
                <a href="{{ route('edit.order', $sprint) }}" target="_blank"
                   class="btn btn-basecolor1 btn-mb" title="Edit Custom run">E
                </a>
            </li>
        @endif
        @if(can_access_route(['rebroadcast.order'], $userPermissoins))
            <li>
                <a data-toggle="modal" data-target="#orderBroadcast" href="#" class="btn btn-basecolor1 btn-mb"
                   onclick="reBroadcast({{$sprint}})" title="Order broadcast">R
                </a>
            </li>
        @endif
        <li>
            <a data-toggle="modal" data-target="#exclusive" href="#" class="btn btn-basecolor1 btn-mb"
               onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})" title="">P
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Map">M
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#cancel" href="#" class="btn btn-danger btn-mb"
               onclick="cancelOrderPopUp({{ $sprint }},{{ $dispatch }}, {{ $status }})" title="Cancel">C
            </a>
        </li>
    @endif

    {{-- Order States Active --}}
    @if($status == 32 || $status == 24 || $status == 124 || $status == 133 || $status == 121 || $status == 15 || $status == 28 || $status == 67 || $status == 68)
        <li>
            <a data-toggle="modal" data-target="#transferJoeySprint" href="#" class="btn btn-basecolor1 btn-mb"
               title="Transfer Joey Sprint" onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})">T
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#assignJoeySprint" href="#" class="btn btn-basecolor1 btn-mb"
               title="Assign Joey Sprint" onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})">A
            </a>
        </li>
        <li>
            <a href="{{ route('edit.order', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
               title="Edit Custom run">E
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#orderBroadcast" href="#" class="btn btn-basecolor1 btn-mb"
               onclick="reBroadcast({{$sprint}}, {{ $dispatch }})" title="Order broadcast">R
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#exclusive" href="#" class="btn btn-basecolor1 btn-mb"
               onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})" title="">P
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Map">M
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#cancel" href="#" class="btn btn-danger btn-mb"
               onclick="cancelOrderPopUp({{ $sprint }},{{ $dispatch }}, {{ $status }})" title="Cancel">C
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#notes" href="#" onclick="showModalOfOrderNote({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Notes">N
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#flag" href="#" class="btn btn-basecolor1 btn-mb" title="Flag">F</a>
        </li>
        <li>
            <a href="{{ route('order.notes', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
               title="Order Notes">ON
            </a>
        </li>
    @endif
    {{-- Order States Edit --}}
    @if($status == 18)
        <li>
            <a data-toggle="modal" data-target="#cancel" href="#" class="btn btn-danger btn-mb"
               onclick="cancelOrderPopUp({{ $sprint }},{{ $dispatch }}, {{ $status }})" title="Cancel">C
            </a>
        </li>
        <li>
            <a href="{{ route('edit.order', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
               title="Edit Custom run">E
            </a>
        </li>
    @endif
    {{-- Order States Completed --}}
    @if($status == 113 || $status == 17 || $status == 114 || $status == 116 || $status == 117 || $status == 118 || $status == 132 ||$status == 138 || $status == 139 || $status == 144)
        <li>
            <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Map">M
            </a>
        </li>
    @endif
    {{-- Order States Rejected --}}
    @if($status == 35 || $status == 36 || $status == 37)
        <li>
            <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Map">M
            </a>
        </li>
    @endif
    {{-- Order States Returned --}}
    @if($status == 101 || $status == 102 || $status == 103 || $status == 104 || $status == 105 || $status == 106 || $status == 107 ||$status == 108 || $status == 109 ||
        $status == 110 || $status == 111 || $status == 112 || $status == 131 || $status == 135 || $status == 136 || $status == 143)
        <li>
            <a data-toggle="modal" data-target="#transferJoeySprint" href="#" class="btn btn-basecolor1 btn-mb"
               title="Transfer Joey Sprint" onclick="assignTransferAndPreBroadcastModalData({{$dispatch}})">T
            </a>
        </li>
        <li>
            <a href="{{ route('edit.order', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
               title="Edit Custom run">E
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#map" href="#" onclick="showOrderTaskMarkers({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Map">M
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#cancel" href="#" class="btn btn-danger btn-mb"
               onclick="cancelOrderPopUp({{ $sprint }},{{ $dispatch }}, {{ $status }})" title="Cancel">C
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#notes" href="#" onclick="showModalOfOrderNote({{ $sprint }})"
               class="btn btn-basecolor1 btn-mb" title="Notes">N
            </a>
        </li>
        <li>
            <a data-toggle="modal" data-target="#flag" href="#" class="btn btn-basecolor1 btn-mb" title="Flag">F</a>
        </li>
        <li>
            <a href="{{ route('order.notes', $sprint) }}" target="_blank" class="btn btn-basecolor1 btn-mb"
               title="Order Notes">ON
            </a>
        </li>
    @endif
    @if(can_access_route(['order.detail'],$userPermissoins))
        <li>
            <a data-toggle="modal" data-target="#detail" href="#" class="btn btn-basecolor1 btn-mb"
               onclick="orderDetails({{ $sprint }})" title="Detail">D
            </a>
        </li>
    @endif

    {{--        <li><a data-toggle="modal" data-target="#assignCode" href="#" class="btn btn-basecolor1 btn-mb"--}}
    {{--               title="Assign Code">AC</a>--}}
</ul>


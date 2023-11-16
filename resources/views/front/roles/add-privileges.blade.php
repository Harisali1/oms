@extends('front.layouts.Dispatch-layout')

@section('page-title',"Set Role Permissions")

@section('css')
    <style>
        .active_permissions {
            background-color: #e46d29 !important;
            color: white !important;
        }
    </style>
@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                @include('front.roles.role-sidebar')
                <!-- Sidebar -->

                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Set Privileges</h1>
                                </div>
                            </div>


                            <form method="POST" action="{{ route('role.set-permissions.update',$role->id) }}"
                                  id="account-form" class="needs-validation" novalidate>
                                @csrf
                                @method('POST')
                                @php
                                    $key = 1;
                                @endphp

                                {{--                                <ul class="someclass">--}}
                                {{--                                    <li>--}}
                                {{--                                        <input type="checkbox" name="level-1">Level 1</input>--}}
                                {{--                                        <ul>--}}
                                {{--                                            <li>--}}
                                {{--                                                <input type="checkbox" name="level-2">Level 2</input>--}}
                                {{--                                                <ul>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                </ul>--}}
                                {{--                                            </li>--}}
                                {{--                                            <li>--}}
                                {{--                                                <input type="checkbox" name="level-2">Level 2</input>--}}
                                {{--                                                <ul>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                    <li><input type="checkbox" name="level-3">Level 3</input></li>--}}
                                {{--                                                </ul>--}}
                                {{--                                            </li>--}}
                                {{--                                        </ul>--}}
                                {{--                                    </li>--}}
                                {{--                                </ul>--}}
                                <div class="content_header_wrap">
                                    <div class="hgroup divider-after left">
                                        <h4 class="">All<input type="checkbox" class="ml-10" name="select-all"
                                                               id="select-all"></h4>
                                    </div>
                                </div>
                                @foreach($permissions_list as $permission_label => $permissions)
                                    <section class="form-section">
                                        <div class="section-inner someclass">
                                            @php
                                                $label = str_replace(' ', '-', $permission_label);
                                            @endphp
                                            <h4>{{$permission_label}}
                                                <input type="checkbox" class="ml-10 permissions_checkbox" name="select-all"
                                                       id="select-all-{{$key++}}">
                                            </h4>
                                            <div class="form-group no-min-h nomargin">
                                                <div class="custom-control-inline-wrap {{ $label .'-'. $key }}">
                                                    @foreach($permissions as  $name =>  $permission)
                                                        <div
                                                            class="custom-radio form-radio custom-control-inline mb-20">
                                                            @php
                                                                $names = str_replace(' ', '-', $name);
                                                                $label = str_replace(' ', '-', $permission_label);
                                                            @endphp
                                                            <input class="form-radio-input permissions_checkbox" type="checkbox"
                                                                   name="permissions[]" id="{{$label.'-'.$names}}"
                                                                   value="{{ $permission }}"
                                                                   @if(check_permission_exist($permission,$role->Permissions->pluck('route_name')->toArray()))
                                                                   checked
                                                                @endif>
                                                            <label class="form-radio-label"
                                                                   for="{{$label.'-'.$names}}">{{$name}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endforeach
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Set Privilages</button>
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
        // $('.someclass :checkbox').bind('click', function () {
        //     var $chk = $(this), $li = $chk.closest('div'), $ul, $parent;
        //
        //     console.log($li.has('div').find('h4').length);
        //
        //     if ($li.has('div')) {
        //         $li.find(':checkbox').not(this).prop('checked', this.checked)
        //     }
        //
        //     do {
        //         $ul = $li.parent();
        //         $parent = $ul.siblings(':checkbox');
        //         if ($chk.is(':checked')) {
        //             $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
        //         } else {
        //             $parent.prop('checked', false)
        //         }
        //         $chk = $parent;
        //         $li = $chk.closest('div');
        //     } while ($ul.is(':not(.someclass)'));
        // });

        $('#select-all').on('click', function (condition = true) {
            var all = document.getElementById('select-all').value;
            alert(condition)
            if(all == 'all')
            {
                $(".permissions_checkbox").prop("checked", false);
            }
            else if(condition == false)
            {
                $('.permissions_checkbox').not(all).prop("checked", false);
            }
            else
            {
                $(all).prop("checked", false);
            }
        });



        // $('#select-all').click(function (event) {
        //     if (this.checked) {
        //         $(':checkbox').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $(':checkbox').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });
        //
        // $('#select-all-1').click(function (event) {
        //     if (this.checked) {
        //         $('#Roles-List, #Roles-Create, #Roles-Edit, #Roles-View, #Roles-Set-Permissions').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $('#Roles-List, #Roles-Create, #Roles-Edit, #Roles-View, #Roles-Set-Permissions').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });
        //
        // $('#select-all-2').click(function (event) {
        //     if (this.checked) {
        //         $('#Sub-Admin-List, #Sub-Admin-Create, #Sub-Admin-Edit, #Sub-Admin-Status-Change, #Sub-Admin-Delete').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $('#Sub-Admin-List, #Sub-Admin-Create, #Sub-Admin-Edit, #Sub-Admin-Status-Change, #Sub-Admin-Delete').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });
        //
        // $('#select-all-3').click(function (event) {
        //     if (this.checked) {
        //         $('#Control-Delivery-Type-List, #Control-Delivery-Type-Create, #Control-Delivery-Type-Edit, #Control-Delivery-Type-Delete, #Control-Delivery-Preference-List, #Control-Delivery-Preference-Create, #Control-Delivery-Preference-Edit, #Control-Delivery-Preference-Delete, #Control-Order-Category-List, #Control-Order-Category-Create, #Control-Order-Category-Edit, #Control-Order-Category-Delete').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $('#Control-Delivery-Type-List, #Control-Delivery-Type-Create, #Control-Delivery-Type-Edit, #Control-Delivery-Type-Delete, #Control-Delivery-Preference-List, #Control-Delivery-Preference-Create, #Control-Delivery-Preference-Edit, #Control-Delivery-Preference-Delete, #Control-Order-Category-List, #Control-Order-Category-Create, #Control-Order-Category-Edit, #Control-Order-Category-Delete').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });
        //
        // $('#select-all-4').click(function (event) {
        //     if (this.checked) {
        //         $('#Routes-Joey-Routes-List, #Routes-Joey-Route-Map, #Routes-Make-Route').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $('#Routes-Joey-Routes-List, #Routes-Joey-Route-Map, #Routes-Make-Route').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });
        //
        // $('#select-all-5').click(function (event) {
        //     if (this.checked) {
        //         $('#Schedule-List, #Schedule-Create, #Schedule-Edit, #Schedule-Delete, #Schedule-Search, #Schedule-Shift-Publisher-List').each(function () {
        //             this.checked = true;
        //         });
        //     } else {
        //         $('#Schedule-List, #Schedule-Create, #Schedule-Edit, #Schedule-Delete, #Schedule-Search, #Schedule-Shift-Publisher-List').each(function () {
        //             this.checked = false;
        //         });
        //     }
        // });

    </script>
@stop

@extends('front.layouts.Dispatch-layout')

@section('page-title',"Sub Admin Edit")

@section('css')
    <style>
        .email-disabled {
            background-color: lightgray !important;
        }
        .role-type{
            padding-left: 15px!important;
            padding-bottom: 10px!important;
            padding-top: 10px!important;
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
                @include('front.sub-admin.sub-admin-sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Sub Admin Edit</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('sub-admin.update', $sub_admin->id) }}"
                                  class="form-horizontal" role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="name">Name *</label>
                                                <input type="text" class="form-control form-control-lg"
                                                       placeholder="Enter Name"
                                                       value="{{ old('name', $sub_admin->name) }}" id="name" name="name"
                                                       required>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a name.
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="email">Email *</label>
                                                <input type="email" class="form-control form-control-lg email-disabled"
                                                       placeholder="test@domain.com"
                                                       value="{{ old('email', $sub_admin->email) }}" id="email"
                                                       name="email" readonly>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="phone">Phone *</label>
                                                <input type="text" name="phone" maxlength="32"
                                                       value="{{ old('phone', $sub_admin->phone) }}"
                                                       class="form-control form-control-lg phone_us" required/>
                                                @if ($errors->has('phone'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a phone.
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="address">Role Type *</label>
                                                <select name="role" id="role_type" class="form-control form-control-lg role-type"
                                                        required>
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($role_list as $role)
                                                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('role'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('role') }}</strong>
                                                    </span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    Please provide a role.
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="password">Password *</label>
                                                <input type="password" class="form-control form-control-lg"
                                                       placeholder="" id="password" name="password">
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="upload_picture">Upload Picture</label>
                                                {{ Form::file('upload_file', ['class' => 'form-control profile_sub_admin']) }}
                                                <img style="max-width: 350px;height: 150px;margin-top: 4px"
                                                     onClick="preview(this);" width="200" height="100" src="{{$sub_admin->profile_picture}}"/>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update</button>
                                    <a href="{{route('sub-admin.index')}}">
                                        <button type="button" class="btn btn-primary"
                                                style="background-color: #bad709!important;">Cancel
                                        </button>
                                    </a>
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
        $(document).ready(function () {

            make_option_selected('.role-type', '{{ old('role',$sub_admin->role_id) }}');
        });
    </script>
@stop

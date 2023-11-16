@extends('front.layouts.Dispatch-layout')

@section('page-title',"Sub Admin Create")

@section('css')
    <style>
        .sub-admin-file {
            padding: 3px;
        }

        .role-type {
            padding: 12px !important;
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
                                    <h1 class="lh-10">Add Sub Admin</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('sub-admin.store') }}" id="account-form"
                                  class="needs-validation" novalidate role="form" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="name">Name *</label>
                                                <input type="text"
                                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                       placeholder="Enter Name" name="name" required
                                                       value="{{ old('name') }}">
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('name'))
                                                        {{ $errors->first('name') }}
                                                    @else
                                                        Please provide a name.
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="email">Email *</label>
                                                <input type="email"
                                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                       placeholder="test@domain.com" id="email" name="email" required
                                                       value="{{ old('email') }}">
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('email'))
                                                        {{ $errors->first('email') }}
                                                    @else
                                                        Please provide an email.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="phone">Phone*</label>
                                                <input type="tel" name="phone" maxlength="11"
                                                       onkeypress="return onlyNumberKey(event)"
                                                       value="{{ old('phone') }}"
                                                       class="form-control form-control-lg phone_us @error('phone') is-invalid @enderror"
                                                       placeholder="Enter Phone No#" required>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('phone'))
                                                        {{ $errors->first('phone') }}
                                                    @else
                                                        Please provide a phone.
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="role_id">Role Type *</label>
                                                <select name="role_id" id="role_id" class="form-control form-control-lg role-type
										            @error('role_id') is-invalid @enderror" required>
                                                    <option value="" disabled selected>Select an option</option>
                                                    @foreach($role_list as $role)
                                                        <option value="{{$role->id}}" {{ ( old('role_id') == $role->id) ? 'selected' : ''}} > {{$role->display_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('role_id'))
                                                        {{ $errors->first('role_id') }}
                                                    @else
                                                        Please provide a role
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="password">Password *</label>
                                                <input type="password"
                                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                       placeholder="Enter Password"
                                                       id="password" name="password" required>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('password'))
                                                        {{ $errors->first('password') }}
                                                    @else
                                                        Please provide a password.
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="confirm_password">Confirm Password *</label>
                                                <input type="password"
                                                       class="form-control form-control-lg @error('confirm_password') is-invalid @enderror"
                                                       placeholder="Enter Confirm Password its Match With Password"
                                                       id="confirm_password" name="confirm_password" required>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('confirm_password'))
                                                        {{ $errors->first('confirm_password') }}
                                                    @else
                                                        Please provide a confirm password.
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="upload_picture">Upload Picture</label>
                                                <input
                                                    class="form-control sub-admin-file @error('profile_picture') is-invalid @enderror"
                                                    name="profile_picture" type="file">
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('profile_picture'))
                                                        {{ $errors->first('profile_picture') }}
                                                    @else
                                                        Please provide a image.
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Save</button>
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
        function onlyNumberKey(evt) {

            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
@stop

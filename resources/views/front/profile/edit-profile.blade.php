@extends('front.layouts.Dispatch-layout')

@section('page-title',"Edit Profile")

@section('css')
    <style>
        .profile-chosen-button{
            padding: 3px;
        }
        .email-disabled {
            background-color: lightgray !important;
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
                    <aside id="left_sidebar" class="col-12 col-lg-3">
                        <div class="inner">
                            <div class="widget_sidebar d-lg-block">
                                <nav class="sidebar_nav">
                                    <ul class="no-list">
                                        <li><a href="{{route('edit-profile')}}">Edit Profile</a></li>
                                        <li><a href="{{route('users.change-password')}}">Change Password</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </aside>

                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">Edit Profile</h1>
                                </div>
                            </div>
                            <div class="content_header_wrap">
                                @include('front.partials.errors')
                            </div>
                            <form method="POST" action="{{ route('edit-profile.update') }}" id="account-form"
                                  class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                <section class="form-section pb-0">
                                    <div class="section-inner">
                                        <div class="form-row">
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="name">Name *</label>
                                                <input type="text"
                                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                       id="name" name="name" value="{{ old('name', $data->name) }}" required
                                                        placeholder="Enter Name">
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
                                                <input type="email" class="form-control form-control-lg email-disabled"
                                                       placeholder="test@domain.com" id="email" name="email"
                                                       value="{{ old('email', $data->email) }}" required readonly>
                                            </div>
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="phone">Phone *</label>
                                                <input type="text"
                                                       class="form-control form-control-lg phone_us @error('phone') is-invalid @enderror"
                                                       maxlength="11" onkeypress="return onlyNumberKey(event)"
                                                       placeholder="000-0000-000" id="phone" name="phone"
                                                       value="{{ old('phone', $data->phone) }}" required>
                                                <div class="invalid-feedback">
                                                    @if ($errors->has('phone'))
                                                        {{ $errors->first('phone') }}
                                                    @else
                                                        Please provide a phone no.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6 no-min-h">
                                                <label for="profile_picture">Profile Picture</label>
                                                <input type="file" name="profile_picture" class="form-control profile-chosen-button"/>
                                                <br>
                                                <img style="border: solid;" onClick="ShowLightBox(this);"
                                                     src="{{$data->profile_picture}}" alt=""
                                                     title="{!! $data->full_name !!}" class="img-responsive" width="150"
                                                     height="150"/><br>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="content_footer_wrap">
                                    <button type="submit" class="btn btn-primary submitButton">Update</button>
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

        function ShowLightBox(el) {

            // get current  img src
            let img_src = el.src;
            // create html
            let html = '<div id="custom-light-box-model" class="modal">';
            html+=' <span class="custom-light-box-model-close-btn" onClick="CloseLightBox()">X</span>';
            html+=' <img src="'+img_src+ '" class="custom-light-box-model-img" id=""> ';
            html+=' </div> ';

            // appending html
            document.getElementsByTagName("body")[0].insertAdjacentHTML("beforeend",
                html );
        }

        function CloseLightBox() {
            document.getElementById("custom-light-box-model").remove();
        }
    </script>
@stop

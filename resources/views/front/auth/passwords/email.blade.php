@extends('front.layouts.login')

@section('content')

<!-- BEGIN LOGIN FORM -->
<div class="row no-gutters justify-content-center">
    <div class="col-10 col-md-9 col-lg-7">
        <div class="hgroup divider-after align-center">
            <h1>Reset Password To OMS Portal</h1>
            <p class="f14">To reset password please enter your email provided by admin</p>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger custom">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br />
                @endforeach
            </div>
        @endif

        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                {{ session('message') }}
            </div>
    @endif
        <!-- Login Form -->
        <form method="POST" action="{{ url('password/email') }}" id="login-form"  class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="role_id"  value="5" />
            <div class="form-group align-center">
                <label for="emailInput">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" id="emailInput" required>
            </div>

            <div class="align-center">
                <button type="submit" disabled class="btn btn-primary submitButton mt-4">Reset</button>
            </div>
        </form>
        <div class="extra-info">
            <p class="back-to-home align-center">
                <a href="{{url('login')}}" class="bc1-light none"><i class="icofont-rounded-left"></i> Back to home</a>
            </p>
        </div>
    </div>
</div>
<!-- END LOGIN FORM -->

@stop

@extends('front.layouts.login')
@section('title', 'Login')

@section('content')

<style>
.form-group label {
    display: inline-block;
}

</style>
    <div class="row no-gutters justify-content-center">
        <div class="col-10 col-md-9 col-lg-5 col-xl-5">
            <div class="hgroup divider-after align-center">
                <h1>Login To Dispatch Portal</h1>
                <p class="f14">To authenticate by different types by email and by scan</p>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger custom">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br/>
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
            {!! Form::open( ['url' => ['type/auth'], 'method' => 'POST', 'class' => 'form-horizontal form-label-left', 'role' => 'form']) !!}
            @csrf

            <div class='form'>
                <div class="form-group align-center">
                @if(base64_decode($mail) == 0)
                    <input type="radio" id="mail" name="type" value="Mail" required>
                    <label for="Mail" style="margin-left: 8px;
    font-size: 15px;">Authenticate By Mail</label><br>
                @endif
                @if(base64_decode($scan) == 0)
                    <input type="radio" id="Scan" name="type" value="Scan" required style="margin-left: 5px">
                    <label for="Scan" style="margin-left: 8px;
    font-size: 15px;">Authenticate By Scan</label><br>
                @endif
                <button id="search" type="submit" class="btn btn-lg btn-success btn-block">Submit</button>

            </div>
            <input type="hidden" name='id' value="<?php echo $id ?>"></input>
            <input type="hidden" name='key' value="<?php echo $key ?>"></input>
            {!! Form::close() !!}
            <div class="extra-info">
                <p class="forgot-pwd align-center"><a href="{{url('password/reset')}}">Lost your password?</a></p>
            </div>
        </div>
    </div>



@endsection

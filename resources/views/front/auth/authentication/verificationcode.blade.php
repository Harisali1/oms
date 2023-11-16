@extends('front.layouts.login')

@section('title', 'Login')
<style>
    .email_auth {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        width: 45%;
        justify-content: center;
        margin: 0 auto; 
    }
    .enter_procced_code{
        height: 55px;
        border-radius: 10px;
    }
    .btn.btn-lg.btn-success.btn-block {
        margin-top: 20px;
    }
    @media screen and (max-width: 667px) {
        .email_auth {
            width: 90%;
        }
    }
</style>

@section('content')
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper email_auth">
        <div class="animate form login_form">
          <section class="login_content">
              <!-- <img class="dashboard-logo-text" src="{{ url('/') }}/images/abc.png"> -->

              <h3 style="text-align: center;">Please enter the 6-digit verification code we sent via Email:</h3>
              <span style="text-align: center;">(we want to make sure it's you before we contact our movers)</span>
              <br>
              <br>
              <div id="form">

                      {!! Form::open( ['url' => ['verify/code'], 'method' => 'POST', 'class' => 'form-horizontal form-label-left', 'role' => 'form']) !!}

                  @if ( $errors->count() )
                      <div class="alert alert-danger">
                          {!! implode('<br />', $errors->all()) !!}
                      </div>
                  @endif
                      <input   type="text" name='code' required  class="form-control enter_procced_code" placeholder="Enter Code..."></input>


                      <input type="hidden" name='email' value="<?php echo $email ?>"></input>

                      <input type="hidden" name='key' value="<?php echo $key ?>"></input>

                      <button type ='submit' class="btn btn-lg btn-success btn-block">Verify</button>
                  {!! Form::close() !!}
              </div>
                    </section>
					</div>
					</div>
					</div>

@endsection

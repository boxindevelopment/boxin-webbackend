@extends('layouts.master-login')

@section('content')
  <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="post">
    @csrf
      <a href="javascript:void(0)" class="text-center db">
        <img width="120" height="120" src="{{ asset('assets/images/logo-icon.png') }}" alt="Home" style="margin-bottom: -10px;"/>
        <p class="logo-text text-dark text-center" style="font-size: 20px; font-weight: bold;">{{ config('app.name', 'Laravel') }}</p>
      </a>

      <br />

      @include('error-template')

      <div class="form-group">
          <div class="col-xs-12">
              <input name="email" class="form-control" type="text" required="" placeholder="Email" value="{{ old('email') }}">
          </div>
      </div>
      <div class="form-group">
          <div class="col-xs-12">
              <input name="password" class="form-control" type="password" required="" placeholder="Password" value="{{ old('password') }}">
          </div>
      </div>
      <div class="form-group row">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
                <input id="checkbox-signup" type="checkbox" name="remember" class="filled-in chk-col-light-blue" {{ old('remember') ? 'checked' : '' }}>
                <label for="checkbox-signup"> Remember me</label>
            </div>
            <a href="javascript:void(0)" id="to-recover" class="pull-right text-muted"><i class="fa fa-lock m-r-5"></i> Forgot password?</a>
          </div>
      </div>
      <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
              <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">LOGIN</button>
          </div>
      </div>
      {{-- <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
              <div class="social">
                <a href="{{ url('auth/facebook') }}" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
              </div>
          </div>
      </div> --}}
      {{-- <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
              Don't have an account? <a href="pages-register2.html" class="text-primary m-l-5"><b>Sign Up</b></a>
          </div>
      </div> --}}
  </form>
  <form class="form-horizontal" id="recoverform" method="POST" action="{{ route('password.email') }}" style="margin-top:15px;">
      @csrf
      <div class="form-group ">
          <div class="col-xs-12">
              <h3>Recover Password</h3>
              <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
          </div>
      </div>
      <div class="form-group ">
          <div class="col-xs-12">
              <input class="form-control" type="email" required="" name="email" value="{{ old('email') }}" placeholder="Email">
          </div>
      </div>
      <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
            <p class="text-center text-muted mt-4">Already have an account ? <a href="javascript:void(0);" id="getback" class="text-info">Login</a></p>
          </div>
      </div>
  </form>
@endsection

@section('add_script')
  <script>
    $(function(e){
      $('#to-recover').on("click", function() {
          $("#loginform").slideUp();
          $("#recoverform").fadeIn();
      });

      $('#getback').on("click", function() {
        $("#recoverform").fadeOut();
        $("#loginform").slideDown();
      });

      $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
      });

    });
  </script>
@endsection

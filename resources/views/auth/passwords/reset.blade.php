@extends('layouts.master-login')

@section('content')
  <form class="form-horizontal form-material" id="loginform" action="{{ route('password.request') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <a href="javascript:void(0)" class="text-center db m-b-20">
      <img width="120" height="120" src="{{ asset('assets/images/logo-icon.png') }}" alt="Home" style="margin-bottom: -10px;"/>
      <p class="logo-text text-dark text-center" style="font-size: 20px; font-weight: bold;">{{ config('app.name', 'Laravel') }}</p>
    </a>

    @if (count($errors) > 0)
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
      @endforeach
    @endif
    <h3 class="box-title m-b-0">Reset Password</h3>
    <div class="form-group m-t-20">
        <div class="col-xs-12">
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required="" placeholder="Email">
        </div>
    </div>
    <div class="form-group ">
        <div class="col-xs-12">
            <input class="form-control" type="password" name="password" required="" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
        </div>
    </div>
    <div class="form-group text-center m-t-20">
        <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset Password</button>
        </div>
    </div>
</form>
@endsection

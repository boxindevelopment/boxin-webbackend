@extends('layouts.master-error')

@section('content')
  <div class="error-box">
    <div class="error-body text-center">
      <h1>404</h1>
      <h3 class="text-uppercase">PAGE NOT FOUND !</h3>
      <p class="">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
      <a href="{{ route('dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to dashboard</a>
    </div>
    <footer class="footer text-center"> © 2018 twiscode.com </footer>
  </div>
@endsection

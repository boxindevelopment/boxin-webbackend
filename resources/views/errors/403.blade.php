@extends('layouts.master-error')

@section('content')
  <div class="error-box">
    <div class="error-body text-center">
      <h1>403</h1>
      <h3 class="text-uppercase">Forbiddon Error!</h3>
      <p class="m-t-30 m-b-30">YOU DON'T HAVE PERMISSION TO ACCESS ON THIS SERVER.</p>
      <a href="{{ route('dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to dashboard</a>
    </div>
    <footer class="footer text-center"> © 2018 twiscode.com </footer>
  </div>
@endsection

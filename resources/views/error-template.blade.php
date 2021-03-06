@if (count($errors) > 0)
  <div class="m-b-20 m-t-10">
    <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    {{ $error }} <br />
    @endforeach
    </div>
  </div>
@elseif (Session::has('error'))
  <div class="m-b-20 m-t-10">
    <div class="alert alert-danger">
    {{ Session::get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>
  </div>
  {{ Session::forget('error') }}
@elseif (Session::has('success'))
  <div class="m-b-20 m-t-10">
    <div class="alert alert-success">
    {{ Session::get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>
  </div>
  {{ Session::forget('success') }}
@endif

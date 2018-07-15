@extends('layouts_admin.master')

@section('plugin_css')

@endsection

@section('script_css')

@endsection

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Create New User</h3>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              <form action="{{ route('new-user.createuser') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="">Role</label>
                        <select class="form-control" id="select2" name="role" required>
                          <option value=""></option>
                          @if (!empty($role))
                            @foreach ($role as $key => $value)
                              <option value="{{ $value->name }}">{{ $value->name }}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
                      </div>

                      {{-- <div class="form-group">
                          <label for="div3">Username <span class="text-danger">*</span></label>
                          <input type="text" name="username" class="form-control" id="div3" placeholder="Enter Username" required>
                      </div> --}}

                      <div class="form-group">
                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" value="{{ old('email') }}" required>
                      </div>

                      <div class="form-group">
                          <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                          <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required>
                      </div>

                      <a href="{{route('new-user.index')}}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Add User</button>
                    </div>
                </div>
              </form>

            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->

</div>
@endsection

@section('close_html')
<!--PLUGIN JS -->


<script>
$(function() {

  $('#select2').select2({
    placeholder: "Select Role"
  });

});
</script>
@endsection

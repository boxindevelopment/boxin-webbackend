@extends('layouts.master')

@section('plugin_css')

@endsection

@section('script_css')

@endsection

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Edit Superadmin</h3>
    </div>
</div> -->
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

              <h4 class="card-title"><span class="lstick"></span>Edit Superadmin</h4>

              @include('error-template')

              <form action="{{ route('user.superadmin.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" required>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" required>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Password Confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control"  name="status" id="status">
                            <option value="1" {{($user->status == 1) ? 'selected' : ''}}>Aktif</option>
                            <option value="2" {{($user->status == 2) ? 'selected' : ''}}>Non Aktif</option>
                        </select>
                      </div>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-12">
                    <hr>
                      <a href="{{ route('user.superadmin.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
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
 
</script>
@endsection

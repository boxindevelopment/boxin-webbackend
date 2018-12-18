@extends('layouts.master')

@section('plugin_css')

@endsection

@section('content')

<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">My Profile</h3>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Stats box -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Change Password</a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    @include('error-template')
                    <!--second tab-->
                    <div class="tab-pane active" id="profile" role="tabpanel">
                        <div class="card-body">

                            <form action="{{ route('user.changeProfile', ['id' => $user->id]) }}" class="form-horizontal form-material" method="POST" enctype="application/x-www-form-urlencoded">
                            @csrf
                            @method('PUT')
                                <div class="form-group">
                                    <label class="col-md-12">First Name <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Enter your first name" class="form-control form-control-line" value="{{ $user->first_name }}" name="first_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Last Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Enter your last name" name="last_name" class="form-control form-control-line" value="{{ $user->last_name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="Enter your email" class="form-control form-control-line" name="email" id="example-email" value="{{ $user->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Enter your number phone" name="phone" value="{{ $user->phone }}" class="form-control form-control-line" readonly>
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Update Profile</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings" role="tabpanel">
                        <div class="card-body">
                            <form action="{{ route('user.changePassword', ['id' => $user->id]) }}" class="form-horizontal form-material" method="POST" enctype="application/x-www-form-urlencoded">
                            @csrf
                            @method('PUT')     
                                <div class="form-group">
                                    <label class="col-md-12">Old Password</label>
                                    <div class="col-md-12">
                                        <input type="password" name="old_password" class="form-control form-control-line" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" name="new_password" class="form-control form-control-line" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Confirmation New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" name="confirmation_password" class="form-control form-control-line" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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

<!-- end - This is for export functionality only -->


<script>
$(document).ready(function() {

});
    
</script>
@endsection
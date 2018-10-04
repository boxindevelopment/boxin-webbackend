@extends('layouts.master')

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
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
        <div class="col-lg-3">
            <div class="card bg-info">
                <a href="{{ route('warehouses.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-home-map-marker"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Warehouse</h6>
                            <h2 class="m-t-0 text-white">{{ $warehouse }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-success">
                <a href="{{ route('space.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-grid"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Spaces</h6>
                            <h2 class="m-t-0 text-white">{{ $space }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-primary">
                <a href="{{ route('box.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-dropbox"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Boxes</h6>
                            <h2 class="m-t-0 text-white">{{ $box }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-danger">
                <a href="{{ route('user.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-account"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Users</h6>
                            <h2 class="m-t-0 text-white">{{ $user }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    This is some text within a card block. 
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
$(function() {

});
</script>
@endsection

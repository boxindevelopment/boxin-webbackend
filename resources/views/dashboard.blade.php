@extends('layouts.master')

@section('plugin_css')
    <style type="text/css">
        /** Responsive Layout **/
        .col-xs-6.col-sm-1-5.col-lg-2-5{
            padding: 0px 10px;
        }
        @media (min-width: 992px) {
          .col-md-1-5 { width: 20%; }
          .col-md-2-5 { width: 40%; }
          .col-md-3-5 { width: 60%; }
          .col-md-4-5 { width: 80%; }
          .col-md-5-5 { width: 100%; }
        }
        @media (min-width: 1200px) {
          .col-lg-1-5 { width: 20%; }
          .col-lg-2-5 { width: 40%; }
          .col-lg-3-5 { width: 60%; }
          .col-lg-4-5 { width: 80%; }
          .col-lg-5-5 { width: 100%; }
        }
        @media (min-width: 768px) {
          .col-sm-1-5 { width: 20%; }
          .col-sm-2-5 { width: 40%; }
          .col-sm-3-5 { width: 60%; }
          .col-sm-4-5 { width: 80%; }
          .col-sm-5-5 { width: 100%; }
        }
  </style>
@endsection


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
        <div class="col-xs-6 col-sm-1-5 col-lg-2-5">
            <div class="card bg-danger">
                <a href="{{ route('city.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-checkbox-blank-circle"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total City</h6>
                            <h2 class="m-t-0 text-white">{{ $city }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-xs-6 col-sm-1-5 col-lg-2-5">
            <div class="card bg-warning">
                <a href="{{ route('area.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-home-map-marker"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Areas</h6>
                            <h2 class="m-t-0 text-white">{{ $area }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-xs-6 col-sm-1-5 col-lg-2-5">
            <div class="card bg-success">
                <a href="{{ route('space.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-home-outline"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Available Spaces</h6>
                            <h2 class="m-t-0 text-white">{{ $available_space }} of {{ $space }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-xs-6 col-sm-1-5 col-lg-2-5">
            <div class="card bg-info">
                <a href="{{ route('shelves.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-grid"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Shelves</h6>
                            <h2 class="m-t-0 text-white">{{ $shelves }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-xs-6 col-sm-1-5 col-lg-2-5">
            <div class="card bg-primary">
                <a href="{{ route('box.index') }}">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center" style="color: white;"><i class="mdi mdi-48px mdi-dropbox"></i></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Available Boxes</h6>
                            <h2 class="m-t-0 text-white">{{ $available_box }} of {{ $box }}</h2></div>
                    </div>
                </div>
                </a>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h3 class="card-title m-b-5"><span class="lstick"></span>Sales Overview </h3>
                        </div>
                    </div>
                </div>
                <div class="bg-theme stats-bar">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="p-20 active">
                                <h6 class="text-white">Total Sales</h6>
                                <h3 class="text-white m-b-0">$10,345</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="p-20">
                                <h6 class="text-white">This Month</h6>
                                <h3 class="text-white m-b-0">$7,589</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="p-20">
                                <h6 class="text-white">This Week</h6>
                                <h3 class="text-white m-b-0">$1,476</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sales-overview2" class="p-relative" style="height:360px;"></div>
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
<script src="{{asset('assets/plugins/chartist-js/dist/chartist.min.js')}}"></script>
<script src="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
<!--c3 JavaScript -->
<script src="{{asset('assets/plugins/d3/d3.min.js')}}"></script>
<script src="{{asset('assets/plugins/c3-master/c3.min.js')}}"></script>
<!-- Chart JS -->
<script src="{{asset('assets/js/dashboard2.js"')}}></script>
@endsection
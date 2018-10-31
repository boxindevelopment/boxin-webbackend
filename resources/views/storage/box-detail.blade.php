@extends('layouts.master')

@section('plugin_css')
  <!-- page css -->
  <link href="{{asset('assets/css/pages/user-card.css')}}" rel="stylesheet">
  <!-- Popup CSS -->
  <link href="{{asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
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
        <h3 class="text-themecolor">
          Storage Box Detail
        </h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <button onclick="window.location.href='{{ URL::previous() }}'" class="btn waves-effect waves-light m-r-10" style="background-color: white;"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->



<div class="col-12">
    <div class="card">
        <div class="card-body">
          <h4 class="card-title"><span class="lstick"></span>Detail Customer</h4>
          <div class="col-md-6">
            <div class="col-md-4">ID</div>
            <div class="col-md-8">]{{ $detail->order_id }}</div>
          </div>
          <div class="col-md-6">
            <div class="col-md-4">ID</div>
            <div class="col-md-8">]{{ $detail->order_id }}</div>
          </div>
        </div>
    </div>
</div>
<div class="row el-element-overlay">
    @foreach ($detail_order_box as $key => $value)
    @php
      $url = 'https://boxin-dev-order.azurewebsites.net/images/detail_item_box/';
    @endphp
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="el-card-item">
                <div class="el-card-avatar el-overlay-1"> <img src="{{$url}}{{ $value->item_image }}" alt="user" />
                    <div class="el-overlay">
                        <ul class="el-info">
                            <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{$url}}{{ $value->item_image }}"><i class="icon-magnifier"></i></a></li>
                            <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="icon-link"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="el-card-content">
                  <h3 class="box-title">{{ $value->item_name }}</h3> <small>{{ $value->note }}</small>
                    <br/> 
                </div>
            </div>
        </div>
    </div>
    
    @endforeach
    
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
@endsection

@section('close_html')
<!--PLUGIN JS -->


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-ingrd').DataTable({
    "aaSorting": []
  });


});
</script>
<!-- Magnific popup JavaScript -->
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
@endsection

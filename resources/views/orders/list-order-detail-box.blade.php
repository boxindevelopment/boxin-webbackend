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
          Order Detail Boxes
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
        <div class="card-header">
            <b>Detail Data</b>
            <div class="card-actions" style="float: right;">
                <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
            </div>
        </div>
        <div class="card-body collapse show">
          <h5 class="card-title"><span class="lstick"></span><b>* Data Customer</b></h5>
          <form class="form-material row">
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">First Name</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->order->user->first_name }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Last Name</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->order->user->last_name }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Email</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->order->user->email }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">No. Telp</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->order->user->phone }}" readonly> </div>
          </form>

          <h5 class="card-title"><span class="lstick"></span><b>* Data Order</b></h5>
          <form class="form-material row">
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Order ID</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->id_name }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Name {{ $detail->type_size->name }}</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->name }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Duration</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->duration }} {{ $detail->type_duration->alias }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Amount</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="Rp. {{ number_format($detail->amount, 2, '.', ',') }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Start Date</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->start_date }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">End Date</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->end_date }}" readonly> </div>
          </form>

          <h5 class="card-title"><span class="lstick"></span><b>* Data {{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}</b></h5>
          <form class="form-material row">
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">{{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }} ID</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->code_box) ? $detail->box->code_box : '') : (isset($detail->space->code_space_small) ? $detail->space->code_space_small : '') }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Name </label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->name) ? $detail->box->name : '') : (isset($detail->space->name) ? $detail->space->name : '') }}" readonly> </div>
          </form>


          <h5 class="card-title"><span class="lstick"></span><b>* Data Pickup Order</b></h5>
          <form class="form-material row">
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Box Pickup</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_pickup_id == 1 ? 'Deliver to user' : 'User pickup' }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label"></label>Datetime</div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{date('d M Y', strtotime($detail->date))}} ({{ $detail->time_pickup }})" readonly> </div>
              @if($detail->address != '' || $detail->address != null)
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Address</label></div>
              <div class="form-group col-md-10">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->address }}" readonly> </div>
              @endif
              @if($detail->note != '' || $detail->note != null)
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Note</label></div>
              <div class="form-group col-md-10">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->note }}" readonly> </div>
              @endif
              @if($detail->types_of_pickup_id == 1)
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Name</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->driver_name }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Phone</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->driver_phone }}" readonly> </div>
              <div class="form-group col-md-2">
                <label for="inputEmail3" class="text-right control-label col-form-label">Deliver Fee</label></div>
              <div class="form-group col-md-4">
                  <input type="text" class="form-control form-control-line" value="{{ $detail->pickup_fee }}" readonly> </div>
              @endif
          </form>
        </div>
    </div>
</div>

<div class="row el-element-overlay">
    @foreach ($detail_order_box as $key => $value)
      @if ($value->status_id == 9)
      <div class="col-lg-3 col-md-6">
          <div class="card">
              <div class="el-card-item">
                  <div class="el-card-avatar el-overlay-1"> <img src="{{ $value->images }}" alt="user" />
                      <div class="el-overlay">
                          <ul class="el-info">
                              <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ $value->images }}"><i class="icon-magnifier"></i></a></li>
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
      @endif
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

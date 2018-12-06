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
        <h3 class="text-themecolor">Return Box Payments</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Return Box Payment</h4>

              <form action="{{ route('returnboxpayment.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row el-element-overlay">
                  @foreach ($data as $key => $value)
                  @php
                    $url = 'https://boxin-dev-order.azurewebsites.net/images/payment/payment/';
                  @endphp
                    <div class="col-md-6">                      
                        <div class="card">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> <img src="{{$url}}{{ $value->image_transfer }}" alt="user" />
                                    <div class="el-overlay">
                                        <ul class="el-info">
                                            <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{$url}}{{ $value->image_transfer }}"><i class="icon-magnifier"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Payment ID </label>
                        <p>{{ $value->id_name }}</p>
                      </div>
                      <div class="form-group">
                        <label>Name </label>
                        <p>{{ $value->first_name }} {{ $value->last_name }}</p>
                      </div>
                      <div class="form-group">
                        <label>Created At </label>
                        <p><?php echo date("d M Y H:i:s", strtotime($value->created_at)); ?> </p>
                      </div>
                      <div class="form-group">
                        <label>Bank </label>
                        <p>{{ $value->bank }}</p>
                      </div>
                      <div class="form-group">
                        <label>Amount </label>
                        <p>Rp. {{ $value->order_detail->total }}</p>
                      </div>
                      @if($value->status_id == 15)
                      <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="status_id" >
                            <option value="15" {{ $value->status_id == 15 ? 'selected' : '' }}>Waiting for Confirmation</option>
                            <option value="7" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option>
                            <option value="8" {{ $value->status_id == 8 ? 'selected' : '' }}>Rejected</option>
                        </select>
                      </div>
                      @else
                      <div class="form-group">
                        <label>Status </label>
                        <p>{{ $value->status->name }}</p>
                      </div>
                      @endif
                      <input type="hidden" name="order_id" class="form-control" value="{{ $value->order_id }}" required>                
                      
                      <a href="{{ route('payment.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                    </div>
                  @endforeach
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

});
</script>
<!-- Magnific popup JavaScript -->
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
@endsection

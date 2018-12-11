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
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Return Boxes</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Return Boxes</h4>

              <form action="{{ route('return.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6" style="background-color: aliceblue;">
                      @foreach ($data as $key => $value)
                      <div class="form-group">
                        <label>Name </label>
                        <p>{{ $value->order_detail->order->user->first_name }} {{ $value->order_detail->order->user->last_name }}</p>
                      </div>
                      <div class="form-group">
                        <label>Phone / Email</label>
                        <p>{{ $value->order_detail->order->user->phone }} / {{ $value->order_detail->order->user->email }}</p>
                      </div>
                      <div class="form-group">
                        <label>Datetime </label>
                        <p><?php echo date("d M Y", strtotime($value->date)); ?> ({{ $value->time_pickup }})</p>
                      </div>
                      <div class="form-group">
                        <label>Address </label>
                        <p>{{ $value->address }}</p>
                      </div>
                      <div class="form-group">
                        <label>Note </label>
                        <p>{{ $value->note }}</p>
                      </div>
                    </div>
                    
                    <div class="col-md-6">

                      <input type="hidden" name="order_detail_id" class="form-control" value="{{ $value->order_detail_id }}" required>  

                      <!-- return delivery box  -->
                      @if ($value->types_of_pickup_id == 1)

                        @if($value->status_id == 7 || $value->status_id == 2)
                        <div class="form-group">
                          <label for="">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="select2" name="status_id" required>
                                <option value="15" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option>
                                <option value="2" {{ $value->status_id == 2 ? 'selected' : '' }}>On Delivery</option>
                                <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                              </select>
                        </div>

                        <div class="form-group">
                          <label>Driver Name <span class="text-danger">*</span></label>
                          <input type="text" name="driver_name" class="form-control" placeholder="Enter Driver Name" value="{{ $value->driver_name }}" required>
                        </div>

                        <div class="form-group">
                          <label>Driver Phone <span class="text-danger">*</span></label>
                          <input type="number" name="driver_phone" class="form-control" placeholder="Enter Driver Phone" value="{{ $value->driver_phone }}" required>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif

                      @endif
                      <!-- end return delivery box  -->

                      <!-- return box on warehouse -->
                      @if ($value->types_of_pickup_id == 2)

                      @if($value->status_id == 16)
                      <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                          <select class="form-control" id="select2" name="status_id" required>
                              <option value="16" {{ $value->status_id == 16 ? 'selected' : '' }}>Return Requested</option>
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                          </select>
                      </div>
                      @endif

                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                      @endif
                      <!-- end return box on warehouse  -->
              
                      @endforeach
                      <a href="{{ route('return.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
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

});
</script>
@endsection

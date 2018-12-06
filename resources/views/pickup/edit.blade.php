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
        <h3 class="text-themecolor">Pickup Orders</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Pickup Order</h4>

              <form action="{{ route('pickup.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6" style="background-color: aliceblue;">
                      @foreach ($pickup as $key => $value)

                        <input type="hidden" name="order_id" class="form-control" value="{{ $value->order_id }}" required>       
                        
                        <div class="form-group">
                          <label>Name </label>
                          <p>{{ $value->order->user->first_name }} {{ $value->order->user->last_name }}</p>
                        </div>
                        <div class="form-group">
                          <label>Phone / Email</label>
                          <p>{{ $value->order->user->phone }} / {{ $value->order->user->email }}</p>
                        </div>
                        <div class="form-group">
                          <label>Datetime </label>
                          <p><?php echo date("d M Y", strtotime($value->date)); ?> - <?php echo date("h:i a", strtotime($value->time)); ?></p>
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
                      <!-- pickup delivery box -->
                      @if ($value->types_of_pickup_id == 1)  
                        @if($value->status_id == 7)    
                        <div class="form-group">
                          <label for="">Status <span class="text-danger">*</span></label>
                          <select class="form-control" id="select2" name="status_id" required>
                              <option value="15" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option>
                              <option value="2" {{ $value->status_id == 2 ? 'selected' : '' }}>On Delivery</option>
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                        </select>
                          </select>
                        </div> 

                        <div class="form-group">
                          <label>Driver Name <span class="text-danger">*</span></label>
                          <input type="text" name="driver_name" class="form-control" placeholder="Enter Driver Name" value="{{ $value->driver_name }}" >
                        </div>

                        <div class="form-group">
                          <label>Driver Phone <span class="text-danger">*</span></label>
                          <input type="number" name="driver_phone" class="form-control" placeholder="Enter Driver Phone" value="{{ $value->driver_phone }}" >
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif

                      @endif
                      <!-- end pickup delivery box  -->

                      <!-- pickup box on warehouse -->
                      @if ($value->types_of_pickup_id == 2)
                        @if($value->status_id == 7)   
                        <div class="form-group"> 
                          <label for="">Status <span class="text-danger">*</span></label>
                          <select class="form-control" id="select2" name="status_id" required>
                              <option value="7" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option>
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                          </select>
                        </div>
                        
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif

                      @endif
                      <!-- end pickup box on warehouse  -->
                      
                      <a href="{{ route('pickup.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      @endforeach
                      
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

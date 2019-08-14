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
                    <div class="col-md-8" style="background-color: aliceblue;">
                      @foreach ($data as $key => $value)

                      <div class="row">
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
                                      <div class="form-material row">
                                          <div class="form-group col-md-2">
                                              <label>Name </label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p>{{ $value->order_detail->order->user->first_name }} {{ $value->order_detail->order->user->last_name }}</p>
                                          </div>
                                          <div class="form-group col-md-2">
                                              <label>Phone / Email</label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p>{{ $value->order_detail->order->user->phone }} / {{ $value->order_detail->order->user->email }}</p>
                                          </div>
                                      </div>
                                      <div class="form-material row">
                                          <div class="form-group col-md-2">
                                              <label>Datetime </label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p>
                                                @php
                                                  echo date("d M Y", strtotime($value->date)) . ' - ' . date("h:i a", strtotime($value->time))
                                                @endphp
                                              </p>
                                          </div>
                                          <div class="form-group col-md-2">
                                              <label>Address </label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p>{{ $value->address }}</p>
                                          </div>
                                      </div>
                                      <div class="form-material row">
                                          <div class="form-group col-md-2">
                                              <label>Note </label>
                                          </div>
                                          <div class="form-group col-md-10">
                                              <p>{{ $value->note }}</p>
                                          </div>
                                      </div>
                                      @if(isset($value->order_detail->types_of_box_room_id))
                                          <h5 class="card-title"><span class="lstick"></span><b>* Data Order</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Order ID</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->id_name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Name {{ $value->order_detail->type_size->name }}</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Duration</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->duration }} {{ $value->order_detail->type_duration->alias }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Amount</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="Rp. {{ number_format($value->order_detail->amount, 2, '.', ',') }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Start Date</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->start_date }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">End Date</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->end_date }}" readonly> </div>
                                          </div>

                                          <h5 class="card-title"><span class="lstick"></span><b>* Data {{ $value->order_detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">{{ $value->order_detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }} ID</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->types_of_box_room_id == 1 ? (isset($value->order_detail->box->code_box) ? $value->order_detail->box->code_box : '') : (isset($value->order_detail->space->code_space_small) ? $value->order_detail->space->code_space_small : '') }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Name </label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail->types_of_box_room_id == 1 ? (isset($value->order_detail->box->name) ? $value->order_detail->box->name : '') : (isset($value->order_detail->space->name) ? $value->order_detail->space->name : '') }}" readonly> </div>
                                          </div>


                                          <h5 class="card-title"><span class="lstick"></span><b>* Data Pickup Order</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Box Pickup</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->types_of_pickup_id == 1 ? 'Deliver to user' : 'User pickup' }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label"></label>Datetime</div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{  date("d M Y", strtotime($value->date)) . ' - ' . date("h:i a", strtotime($value->time)) }}" readonly> </div>
                                              @if($value->address != '' || $value->address != null)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Address</label></div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->address }}" readonly> </div>
                                              @endif
                                              @if($value->note != '' || $value->note != null)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Note</label></div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->note }}" readonly> </div>
                                              @endif
                                              @if($value->types_of_pickup_id == 1)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Name</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->driver_name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Phone</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->driver_phone }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Deliver Fee</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->pickup_fee }}" readonly> </div>
                                              @endif
                                          </div>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>

                    <div class="col-md-4">

                      <input type="hidden" name="order_detail_id" class="form-control" value="{{ $value->order_detail_id }}" required>

                      <!-- return delivery box  -->
                      @if ($value->types_of_pickup_id == 1)

                        @if($value->status_id == 5 || $value->status_id == 2)
                        <div class="form-group">
                          <label for="">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="select2" name="status_id" required>
                                <option value="5" {{ $value->status_id == 5 ? 'selected' : '' }}>Approved</option>
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
                      <!-- end return delivery box  -->

                      <!-- return box on warehouse -->
                      @elseif ($value->types_of_pickup_id == 2)

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

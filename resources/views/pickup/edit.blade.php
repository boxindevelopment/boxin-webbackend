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
                    <div class="col-md-8" style="background-color: aliceblue;">
                      @foreach ($pickup as $key => $value)
                        @if($value->order->id)

                        <input type="hidden" name="order_id" class="form-control" value="{{ $value->order_id }}" required>
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
                                                <p>{{ $value->order->user->first_name }} {{ $value->order->user->last_name }}</p>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Phone / Email</label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <p>{{ $value->order->user->phone }} / {{ $value->order->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="form-material row">
                                            <div class="form-group col-md-2">
                                                <label>Datetime </label>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <p>
                                                  {{ date("d M Y", strtotime($value->date)).' - '.date("h:i a", strtotime($value->time)) }}
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
                                        @foreach($value->order->order_detail as $detail)
                                        @if(isset($detail->types_of_box_room_id))
                                            <h5 class="card-title"><span class="lstick"></span><b>* Data Order</b></h5>
                                            <div class="form-material row">
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
                                            </div>

                                            <h5 class="card-title"><span class="lstick"></span><b>* Data {{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}</b></h5>
                                            <div class="form-material row">
                                                <div class="form-group col-md-2">
                                                  <label for="inputEmail3" class="text-right control-label col-form-label">{{ $detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }} ID</label></div>
                                                <div class="form-group col-md-4">
                                                    <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->code_box) ? $detail->box->code_box : '') : (isset($detail->space->code_space_small) ? $detail->space->code_space_small : '') }}" readonly> </div>
                                                <div class="form-group col-md-2">
                                                  <label for="inputEmail3" class="text-right control-label col-form-label">Name </label></div>
                                                <div class="form-group col-md-4">
                                                    <input type="text" class="form-control form-control-line" value="{{ $detail->types_of_box_room_id == 1 ? (isset($detail->box->name) ? $detail->box->name : '') : (isset($detail->space->name) ? $detail->space->name : '') }}" readonly> </div>
                                                <div class="form-group col-md-2">
                                                  <label for="inputEmail3" class="text-right control-label col-form-label">Place </label></div>
                                                <div class="form-group col-md-4">
                                                    <input type="text" class="form-control form-control-line" value="{{($detail->place != 'warehouse') ? 'user' : $detail->place }}" readonly> </div>
                                            </div>
                                        @endif
                                        @endforeach
                                        <h5 class="card-title"><span class="lstick"></span><b>* Data Pickup Order</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Box Pickup</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->types_of_pickup_id == 1 ? 'Deliver to user' : 'User pickup' }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label"></label>Datetime</div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ date('d M Y', strtotime($value->date))}} ({{ $value->time_pickup }})" readonly> </div>

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

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                      <!-- pickup delivery box -->
                      @if ($value->types_of_pickup_id == 1)

                        @if($value->status_id == 5 || $value->status_id == 2)
                        <div class="form-group">
                          <label for="">Status <span class="text-danger">*</span></label>
                          <select class="form-control" id="select2" name="status_id" required>
                              {{-- <option value="15" {{ $value->status_id == 5 ? 'selected' : '' }}>Approved</option> --}}
                              <option value="2" {{ $value->status_id == 2 ? 'selected' : '' }}>On Delivery</option>
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
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
                        {{-- @if($value->status_id == 5)
                            <div class="form-group">
                              <label for="">Status <span class="text-danger">*</span></label>
                              <select class="form-control" id="select2" name="status_id" required>
                                  <option value=""></option>>
                                  <option value="4">Stored</option>>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif --}}

                      @endif
                      <!-- end pickup delivery box  -->

                      <!-- pickup box on warehouse -->
                      @if ($value->types_of_pickup_id == 2)

                        @if($value->status_id == 5)
                        <div class="form-group">
                          <label for="">Status <span class="text-danger">*</span></label>
                          <select class="form-control" id="select2" name="status_id" required>
                              {{-- <option value="5" {{ $value->status_id == 5 ? 'selected' : '' }}>Approved</option> --}}
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                          </select>
                        </div>

                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif
                        {{-- @if($value->status_id == 5)
                            <div class="form-group">
                              <label for="">Status <span class="text-danger">*</span></label>
                              <select class="form-control" id="select2" name="status_id" required>
                                      <option value="5" {{ $value->status_id == 5 ? 'selected' : '' }}>Success</option>
                                      <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                              </select>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                        @endif --}}

                      @endif
                      <!-- end pickup box on warehouse  -->
                    @endforeach

                      <a href="{{ route('pickup.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>

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

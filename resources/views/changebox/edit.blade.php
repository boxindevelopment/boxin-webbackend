@extends('layouts.master')

@section('plugin_css')
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
        <h3 class="text-themecolor">Change Item Boxes</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Change Item Boxes</h4>

              <form action="{{ route('change-box.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
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
                                              <p>{{ $value->order_detail_box->order_detail->order->user->first_name }} {{ $value->order_detail_box->order_detail->order->user->last_name }}</p>
                                          </div>
                                          <div class="form-group col-md-2">
                                              <label>Phone / Email</label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p>{{ $value->order_detail_box->order_detail->order->user->phone }} / {{ $value->order_detail_box->order_detail->order->user->email }}</p>
                                          </div>
                                      </div>
                                      <div class="form-material row">
                                          <div class="form-group col-md-2">
                                              <label>Datetime </label>
                                          </div>
                                          <div class="form-group col-md-4">
                                              <p><?php echo date("d M Y", strtotime($value->date)); ?> - <?php echo date("h:i a", strtotime($value->time)); ?></p>
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
                                      @if(isset($value->order_detail_box->order_detail->types_of_box_room_id))
                                          <h5 class="card-title"><span class="lstick"></span><b>* Data Order</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Order ID</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->id_name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Name {{ $value->order_detail_box->order_detail->type_size->name }}</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Duration</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->duration }} {{ $value->order_detail_box->order_detail->type_duration->alias }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Amount</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="Rp. {{ number_format($value->order_detail_box->order_detail->amount, 2, '.', ',') }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Start Date</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->start_date }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">End Date</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->end_date }}" readonly> </div>
                                          </div>

                                          <h5 class="card-title"><span class="lstick"></span><b>* Data {{ $value->order_detail_box->order_detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }}</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">{{ $value->order_detail_box->order_detail->types_of_box_room_id == 1 ? 'Box' : 'Space' }} ID</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->types_of_box_room_id == 1 ? (isset($value->order_detail_box->order_detail->box->code_box) ? $value->order_detail_box->order_detail->box->code_box : '') : (isset($value->order_detail_box->order_detail->space->code_space_small) ? $value->order_detail_box->order_detail->space->code_space_small : '') }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Name </label>
                                              </div>
                                              <div class="form-group col-md-4">
                                                <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->types_of_box_room_id == 1 ? (isset($value->order_detail_box->order_detail->box->name) ? $value->order_detail_box->order_detail->box->name : '') : (isset($value->order_detail_box->order_detail->space->name) ? $value->order_detail_box->order_detail->space->name : '') }}" readonly>
                                              </div>

                                              <div class="form-group col-md-2">
                                                <label class="text-right control-label col-form-label">Item </label>
                                              </div>
                                              <div class="form-group col-md-4">
                                                <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->item_name ? $value->order_detail_box->item_name : '' }}" readonly>
                                              </div>

                                              <div class="form-group col-md-2">
                                                <label class="text-right control-label col-form-label">Image </label>
                                              </div>
                                              <div class="form-group col-md-4">
                                                <a class="btn default btn-info btn-sm image-popup-vertical-fit" href="{{ $value->order_detail_box->images }}">
                                                  <i class="fa fa-file-image-o"></i>
                                                  <div style="display: none;">
                                                      <img width="50%" src="{{ $value->order_detail_box->images }}" alt="image" />
                                                  </div>
                                                </a>
                                              </div>

                                          </div>


                                          <h5 class="card-title"><span class="lstick"></span><b>* Data Pickup Order</b></h5>
                                          <div class="form-material row">
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Box Pickup</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->order->type_of_pickup_id == 1 ? 'Deliver to user' : 'User pickup' }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label"></label>Datetime</div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{date('d M Y', strtotime($value->order_detail_box->order_detail->date))}} {{ $value->order_detail_box->order_detail->time_pickup ? '('.$value->order_detail_box->order_detail->time_pickup.')' : '' }}" readonly> </div>
                                              @if($value->order_detail_box->order_detail->address != '' || $value->order_detail_box->order_detail->address != null)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Address</label></div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->address }}" readonly> </div>
                                              @endif
                                              @if($value->order_detail_box->order_detail->note != '' || $value->order_detail_box->order_detail->note != null)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Note</label></div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->note }}" readonly> </div>
                                              @endif
                                              @if($value->order_detail_box->order_detail->order->type_of_pickup_id == 1)
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Name</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->driver_name }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Driver Phone</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->driver_phone }}" readonly> </div>
                                              <div class="form-group col-md-2">
                                                <label for="inputEmail3" class="text-right control-label col-form-label">Deliver Fee</label></div>
                                              <div class="form-group col-md-4">
                                                  <input type="text" class="form-control form-control-line" value="{{ $value->order_detail_box->order_detail->pickup_fee }}" readonly> </div>
                                              @endif
                                          </div>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>

                    <div class="col-md-4">

                      <input type="hidden" name="order_detail_id" class="form-control" value="{{ $value->order_detail_box->order_detail_id }}" required>


                      <!-- return delivery box  -->
                      {{-- @if($value->status_id == 7 || $value->status_id == 2)
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
                      @endif --}}
                      @if ($value->types_of_pickup_id == 1)
                        @if($value->status_id == 7 || $value->status_id == 2)
                          <div class="form-group">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="select2" name="status_id" required>
                                {{-- <option value="7" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option> --}}
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

                      <!-- pickup box on warehouse -->
                      @if ($value->types_of_pickup_id == 2)
                      <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="status_id" required>
                            @if($value->status_id == 19)
                              <option value="7" {{ $value->status_id == 7 ? 'selected' : '' }}>Approved</option>
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                            @else
                              <option value="12" {{ $value->status_id == 12 ? 'selected' : '' }}>Finished</option>
                            @endif
                          </select>
                        </div>
                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                      @endif
                      <!-- end pickup box on warehouse  -->

                      @endforeach
                      <a href="{{ route('change-box.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
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
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>


<script>
$(function() {

});
</script>
@endsection

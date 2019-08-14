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
        <h3 class="text-themecolor">
          PickUp Orders
        </h3>
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
              <h4 class="card-title"><span class="lstick"></span>List PickUp Orders</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-pickup1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="15%">Date</th>
                          <th width="15%">OrderID</th>
                          <th width="">Customer Name</th>
                          <th width="15%" class="text-center">Box Pickup</th>
                          <th width="15%" class="text-center">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($pickup) > 0)
                        @foreach ($pickup as $key => $value)
                          @php
                            if($value->types_of_pickup_id == 1){
                                $label1  = 'label-warning';
                                $name1   = 'Deliver to user';
                            }else if($value->types_of_pickup_id == 2){
                                $label1  = 'label-primary';
                                $name1   = 'User pickup';
                            }else if($value->types_of_pickup_id == 24){
                                $label1  = 'label-warning';
                                $name1   = 'User Cancelled';
                            } else {
                                $label1  = 'label-warning';
                                $name1   = '';
                            }

                            if($value->status_id == 11 || $value->status_id == 14 || $value->status_id == 15 || $value->status_id == 8 || $value->status_id == 6){
                              $label = 'label-danger';
                            } else if($value->status_id == 12){
                              $label = 'label-inverse';
                            } else if($value->status_id == 7 || $value->status_id == 5){
                              $label = 'label-success';
                            } else if($value->status_id == 2){
                              $label = 'label-warning';
                            } else {
                                $label = 'label-warning';
                            }
                          @endphp
                          <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td align="center">
                              {{  date('d M Y', strtotime($value->date)) }}
                            </td>
                            <td align="center">{{ $value->id_name }}</td>
                            <td>{{ $value->first_name}} {{ $value->last_name}}</td>
                            <td class="text-center">
                              <span class="label {{ $label1 }} label-rounded">{{ $name1 }}</span>
                            </td>
                            <td class="text-center">
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <a class="btn btn-info btn-sm" href="{{route('pickup.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="6" class="text-center">There are no results yet</td>
                        </tr>
                      @endif
                    </tbody>
                </table>
              </div>
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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-pickup1').DataTable({
    "aaSorting": []
  });
  $('#table-pickup2').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

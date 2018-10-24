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
                          <th width="">Customer Name</th>
                          <th width="15%" class="text-center">Type</th>
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
                              $name    = 'Delivery Box';
                            }else if($value->types_of_pickup_id == 2){
                              $label1  = 'label-primary';
                              $name    = 'Box On Warehouse';
                            }
                            
                            if($value->status_id == 11){
                              $label = 'label-danger';
                            }else if($value->status_id == 2 || $value->status_id == 3){
                              $label = 'label-warning';
                            }else{
                              $label = 'label-success';
                            }
                          @endphp
                          <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td>{{ $value->first_name}} {{ $value->last_name}}</td>
                            <td class="text-center">
                              <span class="label {{ $label1 }} label-rounded">{{ $name }}</span>
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
                          <td colspan="5" class="text-center">There are no results yet</td>
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

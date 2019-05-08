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
          Add-Item Boxes
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
              <h4 class="card-title"><span class="lstick"></span>List Add-Item Box</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-data1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="15%" class="text-center">Request Date</th>
                          <th width="20%" class="text-center">Coming Date</th>
                          <th width="">Customer Name</th>
                          <th width="">Items</th>
                          <th width="15%" class="text-center">Box Pickup</th>
                          <th width="15%" class="text-center">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($data) > 0)
                        @foreach ($data as $key => $value)
                          @php
                            if($value->types_of_pickup_id == 1){
                              $label1  = 'label-warning';
                              $name    = 'Deliver to user';
                            }else if($value->types_of_pickup_id == 2){
                              $label1  = 'label-primary';
                              $name    = 'User pickup';
                            }

                            if($value->status_id == 25){
                              $label = 'label-warning';
                            }else if($value->status_id == 22 || $value->status_id == 7){
                              $label = 'label-success';
                            }else{
                              $label = 'label-danger';
                            }
                          @endphp
                          <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td align="center">{{ $value->created_at->format('d-m-Y') }}</td>
                            <td>{{ date('d-m-Y', strtotime($value->date)) }} ({{ $value->time_pickup }})</td>
                            <td>
                              {{ $value->order_detail->order->user->first_name}} {{ $value->order_detail->order->user->last_name}}
                            </td>
                            <td>
                              {{ count($value->items) }}
                            </td>
                            <td class="text-center">
                              <span class="label {{ $label1 }} label-rounded">{{ $name }}</span>
                            </td>
                            <td class="text-center">
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('add-item.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
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
  $('#table-data1').DataTable({
    "aaSorting": []
  });
  $('#table-data2').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

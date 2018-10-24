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
          Storage
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
              <h4 class="card-title"><span class="lstick"></span>List Storage</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-pickup1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Name</th>
                          <th width="12%">Duration</th>
                          <th width="15%" style="text-align: right;">Amount (Rp)</th>
                          <th width="20%" class="text-center">StartDate - EndDate</th>
                          <th width="10%" class="text-center no-sort">Status</th>
                          <th width="10%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($order) > 0)
                        @foreach ($order as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->duration }} {{ $value->type_duration->alias }}</td>
                            <td class="text-right">{{ number_format($value->amount, 0, '', '.') }}</td>
                            <td>{{ $value->start_date }} - {{ $value->end_date }}</td>
                            <td class="text-center">
                              @php
                                if($value->status_id == 11){
                                  $label = 'label-danger';
                                }else if($value->status_id == 2 || $value->status_id == 3){
                                  $label = 'label-warning';
                                }else{
                                  $label = 'label-success';
                                }
                              @endphp
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td>
                              <a class="btn btn-primary btn-sm" href="{{route('order.orderDetailBox', ['id' => $value->order_id])}}"><i class="fa fa-dropbox"></i> Box Detail</a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="7" class="text-center">There are no results yet</td>
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

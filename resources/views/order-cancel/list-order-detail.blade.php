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
          Order Details
        </h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <button onclick="window.location.href='{{ $url }}'" class="btn waves-effect waves-light m-r-10" style="background-color: white;"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button>
        </ol>
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
              <h4 class="card-title"><span class="lstick"></span>List Order Details</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="12%">OrderID</th>
                          <th width="">Name</th>
                          <th width="">Box</th>
                          <th width="12%">Duration</th>
                          <th width="12%" style="text-align: right;">Amount (Rp)</th>
                          <th width="12%">Voucher</th>
                          <th width="10%" style="text-align: right;">Voucher Price</th>
                          <th width="10%" style="text-align: right;">Total Order</th>
                          <th width="15%" class="text-center">StartDate - EndDate</th>
                          <th width="10%" class="text-center no-sort">Status</th>
                          <th width="8%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($detail_order) > 0)
                        @foreach ($detail_order as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->id_name }}</td>
                            <td>{{ $value->name }}<br>({{ ($value->place != 'warehouse') ? 'user' : $value->place }})</td>
                            <td>
                              @if ($value->box)
                                {{ $value->box->code_box }}
                              @else
                                 -
                              @endif
                            </td>
                            <td>{{ $value->duration }} {{ $value->type_duration->alias }}</td>
                            <td class="text-right">{{ number_format($value->amount, 0, '', '.') }}</td>
                            <td>{{ isset($value->order->voucher->code) ? $value->order->voucher->code : ''}}</td>
                            <td class="text-right">{{ number_format($value->order->voucher_amount, 0, '', '.') }}</td>
                            <td class="text-right">{{ number_format($value->order->total, 0, '', '.') }}</td>
                            <td>{{ $value->start_date }} - {{ $value->end_date }}</td>
                            <td class="text-center">
                              @php
                                if($value->status_id == 11 || $value->status_id == 8){
                                  $label = 'label-danger';
                                }else if($value->status_id == 2 || $value->status_id == 3|| $value->status_id == 14){
                                  $label = 'label-warning';
                                }else{
                                  $label = 'label-success';
                                }
                              @endphp
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td>
                              <a class="btn btn-secondary btn-sm" href="{{route('order.cancel.orderDetailBox', ['id' => $value->id])}}"><i class="fa fa-dropbox"></i> Detail</a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="8" class="text-center">There are no results yet</td>
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
  $('#table-ingrd').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

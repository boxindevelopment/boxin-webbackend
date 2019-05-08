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
          Orders
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
              <h4 class="card-title"><span class="lstick"></span>List Orders</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="4%">No</th>
                          <th width="13%">Order Date</th>
                          <th width="">Customer Name</th>
                          <th width="15%">Space</th>
                          <th width="12%">Voucher</th>
                          <th width="12%">Voucher Price</th>
                          <th width="14%" style="text-align: right;">Total (Rp)</th>
                          <th width="8%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($order) > 0)
                        @foreach ($order as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->created_at->format('Y-m-d') }}</td>
                            <td>{{ $value->user->first_name }} {{ $value->user->last_name }}</td>
                            <td>{{ $value->area->name }}</td>
                            <td>{{ isset($value->voucher->code) ? $value->voucher->code : '' }}</td>
                            <td class="text-right">{{ ($value->voucher) ? number_format($value->voucher_amount, 0, '', '.') : '' }}</td>
                            <td class="text-right">{{ number_format($value->total, 0, '', '.') }}</td>
                            <td align="center">
                              <form action="{{route('order.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-primary btn-sm" href="{{route('order.orderDetail', ['id' => $value->id])}}" title="View Detail"><i class="fa fa-eye"></i></a>
                                @method('DELETE')
                                <button type="submit" name="remove" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>
                              </form>
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

              <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                            <h4>[Delete]</h4>
                            <p>Are you sure to delete this order ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
                            <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

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

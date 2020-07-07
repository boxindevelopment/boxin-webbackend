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
              <h4 class="card-title"><span class="lstick"></span>List Orders
                  <a href="{{ route('order.create') }}" class="btn waves-effect waves-light btn-sm btn-primary pull-right"
                    title="Add" style="margin-right: 10px;">
                    <i class="fa fa-plus"></i>&nbsp;
                    Add Order
                  </a>
              </h4>

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

    function action(id){
        var $action = '<form action="{{route('order.index')}}/' + id + '" method="post" style="margin-top:5px;">';
                $action += '@csrf';
                $action += '@method('DELETE')';
                $action += '<a class="btn btn-primary btn-sm" href="{{route('order.index')}}/order-detail/' + id + '" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
                // $action += '<button type="submit" name="remove" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>';
            $action += '</form>';
        return $action;
    }

    var $table = $('#table-ingrd').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            { "name": "no", "sClass": "center", "targets": 0, "visible": false },
            { "name": "orders.created_at", "targets": 1 },
            { "name": "first_name",  "targets": 2 },
            { "name": "area_name", "targets": 3 },
            { "name": "voucher_code", "targets": 4 },
            { "name": "voucher_amount", "sClass": "right", "targets": 5 },
            { "name": "total", "sClass": "right",  "targets": 6 },
        ],
        "ajax": {
            "url": "{{ route('order.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token = $('meta[name="_token"]').attr('content');
                // d.category = $('#category_serch').val();
                // etc
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:15%; position: fixed; left: 20%;'><img src='{{asset('assets/images/preloader.gif')}}'></div>"
        },

        "columns": [
            { "data": "no", "bSortable": false },
            { "data": "created_at", "bSortable": true },
            { "data": "user_fullname", "bSortable": true },
            { "data": "area_name", "bSortable": false },
            { "data": "voucher_code", "bSortable": true },
            { "data": "voucher_amount", "bSortable": true, "sClass": "right" },
            { "data": "total", "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

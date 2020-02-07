@extends('layouts.master')

@section('plugin_css')
  <link href="{{ asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
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
          Order Payments
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
              <h4 class="card-title"><span class="lstick"></span>List Order Payments</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-pay" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="10%">ID</th>
                          <th width="15%">Tanggal</th>
                          <th width="">Customer Name</th>
                          <th width="15%" class="text-center">Status</th>
                          <th width="15%" class="text-center">Amount</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>

<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {

    function action(id, order_detail_id){
        var $action = '<div style="width: 70px;"><a class="btn btn-primary btn-sm" href="{{route('order.index')}}/order-detail/' + order_detail_id + '" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
            $action += '<a class="btn btn-info btn-sm" href="{{route('payment.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a></div>';
        return $action;
    }

    var $table = $('#table-pay').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            { "name": "no", "sClass": "center", "targets": 0, "visible": false },
            { "name": "id_name", "targets": 1 },
            { "name": "created_at",  "targets": 2 },
            { "name": "created_at",  "targets": 3 },
            { "name": "status_id", "targets": 4 },
            { "name": "amount", "sClass": "right",  "targets": 5 },
        ],
        "ajax": {
            "url": "{{ route('payment.ajax') }}",
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
            { "data": "id_name", "bSortable": true },
            { "data": "created_at", "bSortable": true },
            { "data": "user_fullname", "bSortable": true },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": true, "sClass": "right" },
            { "data": "amount", "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id, row.order_id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

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
        <h3 class="text-themecolor">
          Change Item Box Payments
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
              <h4 class="card-title"><span class="lstick"></span>List Change Item Box Payments</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-pay" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="10%">ID</th>
                          <th width="">Customer Name</th>
                          <th width="10%" class="text-center">Image</th>
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

    function action(id){
        var $action = '<a class="btn btn-info btn-sm" href="{{route('change-box-payment.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a>';
        // var $action = '<form action="{{route('change-box-payment.index')}}' + id + '" method="post" style="margin-top:5px;">';
        //         $action += '@csrf';
        //         $action += '@method('DELETE')';
        //         $action += '<button type="submit" name="remove" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>';
        //     $action += '</form>';
        return $action;
    }

    var $table = $('#table-pay').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 2, "desc" ]],
        "columnDefs": [
            { "name": "no", "sClass": "center", "targets": 0, "visible": false },
            { "name": "change_box_payments.id_name", "targets": 1 },
            { "name": "created_at",  "targets": 2 },
            { "name": "image_transfer", "targets": 3 },
            { "name": "status_id", "targets": 4 },
            { "name": "amount", "sClass": "right",  "targets": 5 },
        ],
        "ajax": {
            "url": "{{ route('change-box-payment.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token = $('meta[name="_token"]').attr('content');
                // d.category = $('#category_serch').val();
                // etc
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:40%; position: fixed; left: 40%;'><h2>Loadiing...</h2></div>"
        },
        "columns": [
            { "data": "no", "bSortable": false },
            { "data": "id_name", "bSortable": true },
            { "data": "created_at", "bSortable": true },
            { "data": function ( row, type, val, meta ) { return '<a class="btn default btn-info btn-sm image-popup-vertical-fit" href="' + row.image_transfer + '"><i class="fa fa-file-image-o"></i><div style="display: none;"><img width="50%" src="' + row.image_transfer + '" alt="image" /> </div></a>' }, "bSortable": false },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": true, "sClass": "right" },
            { "data": "amount", "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

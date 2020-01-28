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
                          <th width="10%" class="text-center">OrderID</th>
                          <th width="">Customer Name</th>
                          <th width="8%">Duration</th>
                          <th width="12%" style="text-align: right;">Amount (Rp)</th>
                          <th width="20%" class="text-center">StartDate - EndDate</th>
                          <th width="8%" class="text-center">Place</th>
                          <th width="10%" class="text-center no-sort">Status</th>
                          <th width="10%" class="text-center no-sort">Action</th>
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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {

    function action(id){
        var $action = '<a class="btn btn-primary btn-sm" href="{{url('storage/box-detail')}}/' + id + '"><i class="fa fa-eye"></i></a>';
        return $action;
    }

    var $table = $('#table-pickup1').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 2, "desc" ]],
        "columnDefs": [
            { "name": "no", "sClass": "center", "targets": 0, "visible": false },
            { "name": "id_name", "targets": 1 },
            { "name": "first_name",  "targets": 2 },
            { "name": "duration", "targets": 3 },
            { "name": "amount", "sClass": "right", "targets": 4 },
            { "name": "start_date", "targets": 5 },
            { "name": "place", "targets": 6 },
            { "name": "status_name",  "targets": 7 },
        ],
        "ajax": {
            "url": "{{ route('storage.ajax') }}",
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
            { "data": "user_fullname", "bSortable": true },
            { "data": "duration", "bSortable": false },
            { "data": "amount", "bSortable": true, "sClass": "right" },
            { "data": "date", "bSortable": false },
            { "data": "place", "bSortable": true },
            { "data": function (row, type, val, meta ) { return ' <span class="label label-success label-rounded">Stored</span>'}, "bSortable": true },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

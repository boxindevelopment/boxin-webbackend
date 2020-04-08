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
          Return Boxes
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
    <div class="col-lg-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex">
                    <div class="stats">
                        <h1 class="text-white">{{$returnToday}}</h1>
                        <h6 class="text-white">Return Request Today</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex">
                    <div class="stats">
                        <h1 class="text-white">{{$returnAll}}</h1>
                        <h6 class="text-white">Return Request All</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex">
                    <div class="stats">
                        <h1 class="text-white">{{$returnSuccess}}</h1>
                        <h6 class="text-white">Return Success All</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><span class="lstick"></span>Return Box</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-data1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="15%" class="text-center">Request Date</th>
                          <th width="20%" class="text-center">Returning Date</th>
                          <th width="">Customer Name</th>
                          <th width="15%" class="text-center">Box Pickup</th>
                          <th width="15%" class="text-center">Status</th>
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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {

    function action(id){
        var $action = '<a class="btn btn-info btn-sm" href="{{route('return.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a>';
        return $action;
    }

    var $table = $('#table-data1').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 2, "desc" ]],
        "columnDefs": [
            { "name": "id", "sClass": "center", "targets": 0, "visible": false },
            { "name": "created_at", "targets": 1 },
            { "name": "date",  "targets": 2 },
            { "name": "first_name", "targets": 3 },
            { "name": "types_of_pickup_id", "sClass": "center", "targets": 4 },
            { "name": "status_name", "sClass": "center",  "targets": 5 },
        ],
        "ajax": {
            "url": "{{ route('return.ajax') }}",
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
            { "data": "id", "bSortable": false },
            { "data": "created_at", "bSortable": true },
            { "data": "coming_date", "bSortable": true },
            { "data": "user_fullname", "bSortable": false },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label1 + ' label-rounded">' + row.name + '</span>'; }, "bSortable": true, "sClass": "center" },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": true, "sClass": "center" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

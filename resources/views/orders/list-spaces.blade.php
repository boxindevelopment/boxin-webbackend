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
          Order Spaces
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
              <h4 class="card-title"><span class="lstick"></span>List Order Spaces</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="12%">OrderID</th>
                          <th width="">Name</th>
                          <th width="">Space</th>
                          <th width="12%">Duration</th>
                          <th width="12%" style="text-align: right;">Amount (Rp)</th>
                          <th width="15%" class="text-center">StartDate - EndDate</th>
                          <th width="10%" class="text-center no-sort">Status</th>
                          <th width="8%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
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
        var $action = '<form action="{{route('order.index')}}/' + id + '" method="post" style="margin-top:5px;">';
                $action += '@csrf';
                $action += '@method('DELETE')';
                $action += '<a class="btn btn-primary btn-sm" href="{{route('order.index')}}/order-detail-box/' + id + '" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
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
            { "name": "id_name", "targets": 1 },
            { "name": "first_name",  "targets": 2 },
            { "name": "space_name", "targets": 3 },
            { "name": "type_duration", "targets": 4 },
            { "name": "amount", "sClass": "right", "targets": 5 },
            { "name": "start_date", "sClass": "center",  "targets": 6 },
            { "name": "status_name", "sClass": "center",  "targets": 7 },
        ],
        "ajax": {
            "url": "{{ route('order.space.ajax') }}",
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
            { "data": "space_name", "bSortable": false },
            { "data": function ( row, type, val, meta ) { return row.duration + ' x ' + row.duration_alias; }, "sClass": "center", "bSortable": false },
            { "data": "amount", "bSortable": true, "sClass": "right" },
            { "data": "range_date", "bSortable": true, "sClass": "center" },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

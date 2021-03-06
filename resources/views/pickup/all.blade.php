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
            Deliver to user
        </h3>
    </div>
    <!-- <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <button onclick="window.location.href='{{ $url }}'" class="btn waves-effect waves-light m-r-10" style="background-color: white;"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button>
        </ol>
    </div> -->
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
              <h4 class="card-title"><span class="lstick"></span>List Deliver to user</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <div style="width:90%; position: relative;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="140"><label>Tanggal Awal</label></th>
                            <th width="200">
                                <div class="input-group datepicker">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="from_date" id="from_date" value="{{date('d/m/Y')}}" required>
                                </div>
                            </th>
                            <th width="140"><label>Tanggal Akhir</label></th>
                            <th width="200">
                                <div class="input-group datepicker">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="to_date" id="to_date" value="{{date('t/m/Y')}}" required>
                                </div>
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                    </table>
                  </div>
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="12%">OrderID</th>
                          <th width="">Name</th>
                          <th width="14%">Type</th>
                          <th width="14%">Box</th>
                          <th width="18%">Date Request</th>
                          <th width="16%" style="text-align: right;">Delivery Fee</th>
                          <th width="14%" class="text-center no-sort">Status</th>
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

    $('#from_date, #to_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        keyboardNavigation : true
    }).on('changeDate', function (ev) {
        $table.api().ajax.reload();
    });


    function action(id, transaction_type){
        if(transaction_type == 'start storing'){
        var $action = '<a class="btn btn-primary btn-sm" href="{{route('pickup.index')}}/' + id + '/edit" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
        } else if(transaction_type == 'take') {
        var $action = '<a class="btn btn-primary btn-sm" href="{{route('take.index')}}/' + id + '/edit" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
        } else if(transaction_type == 'back warehouse'){
        var $action = '<a class="btn btn-primary btn-sm" href="{{route('return.index')}}/' + id + '/edit" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
        } else if(transaction_type == 'terminate'){
        var $action = '<a class="btn btn-primary btn-sm" href="{{route('terminate.index')}}/' + id + '/edit" title="View Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></a>';
        }
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
            { "name": "transaction_type", "targets": 3 },
            { "name": "box_name", "targets": 4 },
            { "name": "date_request", "sClass": "right", "targets": 5 },
            { "name": "deliver_fee", "sClass": "right", "targets": 6 },
            { "name": "status_name", "sClass": "center",  "targets": 7 },
        ],
        "ajax": {
            "url": "{{ route('pickup.allAjax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token = $('meta[name="_token"]').attr('content');
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
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
            { "data": "transaction_type", "bSortable": false },
            { "data": "box_name", "bSortable": false },
            { "data": "date_request", "bSortable": false },
            { "data": "deliver_fee", "bSortable": true, "sClass": "right" },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.label + ' label-rounded">' + row.status_name + '</span>'; }, "bSortable": true, "sClass": "center" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.ids, row.transaction_type)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });

    // $('#from_date, #to_date').on('change', function(){
    //     $table.api().ajax.reload();
    // });
    
});
</script>
@endsection

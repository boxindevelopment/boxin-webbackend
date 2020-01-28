@extends('layouts.master')

@section('plugin_css')
  <!-- page css -->
  <link href="{{asset('assets/css/pages/tab-page.css')}}" rel="stylesheet">
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
          Settings Price
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><span class="lstick"></span>List Settings Price</h4>
                @include('error-template')
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Price Box</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Price Room</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="p-20">
                            <a href="{{ route('price.priceBox') }}" class="btn waves-effect waves-light btn-sm btn-primary" title="Add" style="margin-right: 10px;"><i class="fa fa-plus"></i>&nbsp;Add Price Box</a>
                            <div class="table-responsive m-t-10">
                              <table id="table-box" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                      <th width="3%">No</th>
                                      <th width="">Area</th>
                                      <th width="">Type Size</th>
                                      <th width="">Type Duration</th>
                                      <th width="" class="text-right">Price (Rp)</th>
                                      <th width="3%" class="text-center no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="profile" role="tabpanel">
                      <a href="{{ route('price.priceRoom') }}" class="btn waves-effect waves-light btn-sm btn-primary" title="Add" style="margin-right: 10px;"><i class="fa fa-plus"></i>&nbsp;Add Price Room
                      </a>
                      <div class="table-responsive m-t-10">
                        <table id="table-room" class="table table-striped table-bordered" style="width: 100%;">
                          <thead>
                              <tr>
                                <th width="3%">No</th>
                                <th width="">Area</th>
                                <th width="">Type Size</th>
                                <th width="">Type Duration</th>
                                <th width="" class="text-right">Price (Rp)</th>
                                <th width="3%" class="text-center no-sort"></th>
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

    function actionBox(id){
        var $action = '<a class="btn btn-info btn-sm" href="{{route('price.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a>';
        return $action;
    }

    var $table = $('#table-box').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "name": "prices.id", "sClass": "center", "targets": 0 },
            { "name": "area_name", "targets": 1 },
            { "name": "types_of_size_name",  "targets": 2 },
            { "name": "duration", "targets": 3 },
            { "name": "price", "sClass": "center", "targets": 4 },
        ],
        "ajax": {
            "url": "{{ route('price.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token            = $('meta[name="_token"]').attr('content');
                d.box_or_room_id    = 1;
                // etc
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:15%; position: fixed; left: 20%;'><img src='{{asset('assets/images/preloader.gif')}}'></div>"
        },

        "columns": [
            { "data": "id", "bSortable": false },
            { "data": "area_name", "bSortable": true },
            { "data": "types_of_size_name", "bSortable": true },
            { "data": "duration", "bSortable": true },
            { "data": "price", "bSortable": true },
            { "data": function ( row, type, val, meta ) { return "" + actionBox(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });

    function actionRoom(id){
        var $action = '<a class="btn btn-info btn-sm" href="{{route('price.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a>';
        return $action;
    }

    var $table2 = $('#table-room').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "name": "prices.id", "sClass": "center", "targets": 0 },
            { "name": "area_name", "targets": 1 },
            { "name": "types_of_size_name",  "targets": 2 },
            { "name": "duration", "targets": 3 },
            { "name": "price", "sClass": "center", "targets": 4 },
        ],
        "ajax": {
            "url": "{{ route('price.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token            = $('meta[name="_token"]').attr('content');
                d.box_or_room_id    = 2;
                // etc
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:15%; position: fixed; left: 20%;'><img src='{{asset('assets/images/preloader.gif')}}'></div>"
        },

        "columns": [
            { "data": "id", "bSortable": false },
            { "data": "area_name", "bSortable": true },
            { "data": "types_of_size_name", "bSortable": true },
            { "data": "duration", "bSortable": true },
            { "data": "price", "bSortable": true },
            { "data": function ( row, type, val, meta ) { return "" + actionRoom(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

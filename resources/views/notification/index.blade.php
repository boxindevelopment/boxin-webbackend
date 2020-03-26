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
          Notification list
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
              <h4 class="card-title"><span class="lstick"></span>Notification</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-notif" class="table table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="15%" class="text-center">Date</th>
                          <th width="20%" class="text-center">User</th>
                          <th width="20%" class="text-center">Type</th>
                          <th width="">Title</th>
                          <th width="15%" class="text-center">Read at</th>
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

    var $table = $('#table-notif').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            { "name": "id", "sClass": "center", "targets": 0, "visible": false },
            { "name": "notifications.created_at", "targets": 1 },
            { "name": "first_name", "targets": 2 },
            { "name": "type", "sClass": "left", "targets": 3 },
            { "name": "title", "sClass": "left",  "targets": 4 },
            { "name": "read_at", "sClass": "left",  "targets": 5 }
        ],
        "ajax": {
            "url": "{{ route('notification.ajax') }}",
            "type": "POST",
            "data": function ( d ) {
                d._token = $('meta[name="_token"]').attr('content');
            }
        },
        "oLanguage": {
            "sProcessing": "<div style='top:15%; position: fixed; left: 20%;'><img src='{{asset('assets/images/preloader.gif')}}'></div>"
        },

        "columns": [
            { "data": "id", "bSortable": false },
            { "data": "created_at", "bSortable": true },
            { "data": "user_fullname", "bSortable": false },
            { "data": "type", "bSortable": true },
            { "data": "title", "bSortable": true },
            { "data": "read_at", "bSortable": true }
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            console.log('aData', aData.read_at);
            if(aData.read_at == '-'){
                $('td', nRow).css('background-color', '#e9edf2');
            }
            // if (aData[2] == "5") {
            //     $('td', nRow).css('background-color', 'Red');
            // } else if (aData[2] == "4") {
            //     $('td', nRow).css('background-color', 'Orange');
            // }
        }
    });
});
</script>
@endsection

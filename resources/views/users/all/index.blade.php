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
          All Users
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
              <h4 class="card-title"><span class="lstick"></span>List Users</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-users" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">ID</th>
                          <th width="">Name</th>
                          <th width="15%">Phone</th>
                          <th width="20%">Email</th>
                          <th width="10%">Role</th>
                          <th width="10%">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
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
                              <p>Are you sure to delete this user ?</p>
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
        var $action = '<a class="btn btn-info btn-sm" href="{{route('user.index')}}/' + id + '/edit" title="Edit" style="margin-right:5px;"><i class="fa fa-pencil"></i></a>';
        return $action;
    }

    var $table = $('#table-users').dataTable( {
        "autoWidth": true,
        "processing": true,
        "serverSide": true,
        "bFilter": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "name": "users.id", "sClass": "center", "targets": 0 },
            { "name": "first_name", "targets": 1 },
            { "name": "phone",  "targets": 2 },
            { "name": "email", "targets": 3 },
            { "name": "role_name", "sClass": "center", "targets": 4 },
            { "name": "status_name", "sClass": "center",  "targets": 5 },
        ],
        "ajax": {
            "url": "{{ route('user.ajax') }}",
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
            { "data": "user_fullname", "bSortable": true },
            { "data": "phone", "bSortable": true },
            { "data": "email", "bSortable": true },
            { "data": "role_name", "bSortable": true },
            { "data": function ( row, type, val, meta ) { return '<span class="label ' + row.status_label + ' label-rounded">' + row.status_value + '</span>'; }, "bSortable": true, "sClass": "center" },
            { "data": function ( row, type, val, meta ) { return "" + action(row.id)  ; }, "sClass": "center", "bSortable": false },
        ],
        "initComplete": function( settings, json ) {
            //  $('.count_act').html($count_active);
        }
    });
});
</script>
@endsection

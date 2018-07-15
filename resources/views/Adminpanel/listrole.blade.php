@extends('layouts_admin.master')

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
          List All Role
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

          <div class="button-container mb-4">
            <a href="{{ route('new-user.newrole') }}" class="btn btn-warning"><i class="fa fa-plus-square"></i> New Role</a>
          </div>
          <hr>

          @include('error-template')

          <div class="table-responsive m-t-10">
            <table id="table-role" class="table color-bordered-table inverse-bordered-table">
              <thead>
                  <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Created</th>
                    <th class="text-center no-sort">Action</th>
                  </tr>
              </thead>
              <tbody>
                @if (count($role) > 0)
                  @foreach ($role as $key => $value)
                    <tr>
                      <td>{{ ++$key }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->created_at->format('d/m/Y') }}</td>
                      <td class="text-center">
                        @if (strtolower($value->name) != 'superadmin')
                          <a href="{{ route('new-user.attachrole', ['name' => $value->name]) }}" data-toggle="tooltip" data-original-title="Edit" class="text-muted">
                            <i class="fa fa-pencil text-inverse m-r-10"></i> Permission
                          </a>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endif
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
  $(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
    $(".alert").remove();
  });

});
</script>
@endsection

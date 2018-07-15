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
          List User
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
              <a href="{{ route('new-user.createuser') }}" class="btn btn-warning"><i class="fa fa-plus-square"></i> New User</a>

              @include('error-template')

              <div id="mainDiv" class="table-responsive m-t-10">
                  <table id="table-userRole" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th class="text-center no-sort">Action</th>
                          <th class="text-center no-sort">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($user) > 0)
                        @foreach ($user as $key => $value)
                          <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            @php
                              $role = null;
                              if ($value->getRoleNames()->count()) {
                                echo '<td>'.$value->getRoleNames()->first().'</td>';
                                $role = $value->getRoleNames()->first();
                              } else {
                                echo '<td></td>';
                              }
                            @endphp
                            <td>
                              @if (!$value->deleted_at)
                                <span class="text-success">Aktif</span>
                              @else
                                <span class="text-danger">Non-Aktif</span>
                              @endif
                            </td>

                            <td class="text-center">
                            @if (strtolower($role) !== 'superadmin')
                                <form action="{{ route('new-user.index') }}" method="post">
                                  @csrf
                                  <input type="hidden" name="id" value="{{ $value->id }}">
                                  @if (!$value->deleted_at)
                                    <button class="btn btn-danger btn-sm" type="submit">
                                      Non-Aktifkan
                                    </button>
                                  @else
                                    <button class="btn btn-success btn-sm" type="submit">
                                      Aktifkan
                                    </button>
                                  @endif
                                </form>
                            @endif
                          </td>
                          <td class="text-center">
                            <a href="{{ route('new-user.edituser', ['id' => $value->id]) }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit</a>
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

  $('#table-userRole').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

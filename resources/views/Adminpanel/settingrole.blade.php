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
          Setting Permission
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
          <h4 class="card-title">Role : {{ $name }}</h4>
          <a href="{{ route('new-user.listrole') }}" class="btn btn-secondary">Back</a>
          <hr>
          <form id="formRole" class="form-horizontal" action="{{ route('new-user.attachrole', ['name' => $name]) }}" method="post">
            @csrf
            <div class="form-group">
              <label for=""><h4>Member</h4></label>
              <ul style="list-style:none;">
                <li>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck16" name="member_new" {{ $data['member_new'] > 0 ? 'checked' : null }}>
                    <label for="ck16" class=""><span>Create New</span></label>
                  </div>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck17" name="member_list" {{ $data['member_list'] > 0 ? 'checked' : null }}>
                    <label for="ck17" class=""><span>All List</span></label>
                  </div>
                </li>
              </ul>
            </div>

            <div class="form-group">
              <label for=""><h4>Member Wallet</h4></label>
              <ul style="list-style:none;">
                <li>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck19" name="wallet_add" {{ $data['wallet_add'] > 0 ? 'checked' : null }}>
                    <label for="ck19" class=""><span>Add Wallet</span></label>
                  </div>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck12" name="wallet_list" {{ $data['wallet_list'] > 0 ? 'checked' : null }}>
                    <label for="ck12" class=""><span>List Wallet</span></label>
                  </div>
                </li>
              </ul>
            </div>

            <div class="form-group">
              <label for=""><h4>Withdraw Request</h4></label>
              <ul style="list-style:none;">
                <li>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck14" name="wd_pending" {{ $data['wd_pending'] > 0 ? 'checked' : null }}>
                    <label for="ck14" class=""><span>List Pending</span></label>
                  </div>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck15" name="wd_approve" {{ $data['wd_approve'] > 0 ? 'checked' : null }}>
                    <label for="ck15" class=""><span>List Approval</span></label>
                  </div>
                </li>
              </ul>
            </div>

            <div class="form-group">
              <label for=""><h4>Category Product</h4></label>
              <ul style="list-style:none;">
                <li>
                  <div class="checkbox checkbox-info">
                    <input type="checkbox" id="ck13" name="categoryproduct" {{ $data['categoryproduct'] > 0 ? 'checked' : null }}>
                    <label for="ck13" class=""><span>Open</span></label>
                  </div>
                </li>
              </ul>
            </div>





          <button type="submit" class="btn btn-info">Submit</button>
          </form>
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

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
        <h3 class="text-themecolor">Add Voucher</h3>
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

              @include('error-template')

              <form action="{{ route('voucher.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      
                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="" required>
                      </div>

                      <div class="form-group">
                        <label>Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code" value="" required>
                      </div>

                      <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Enter Description" value="" required>
                      </div>

                      <div class="form-group">
                        <label>Type Voucher <span class="text-danger">*</span></label>
                        <div class="demo-radio-button">
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_percen" checked />
                          <label for="type_voucher_percen">Percen</label>
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_nominal" />
                          <label for="type_voucher_nominal">Nominal</label>
                        </div>
                      </div>

                      <div class="form-group value">
                        <label>Value <span class="text-danger">*</span></label>
                        <input type="text" name="value" id="value1" class="form-control value1" placeholder="Enter Percen" max="100" min="0" >
                        <input style="display: none" type="text" name="value" id="value2" class="form-control value2" placeholder="Enter Nominal" value="" min="0">
                      </div>

                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
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
<script type="text/javascript">  

$(document).ready( function() {

});
</script>
@endsection

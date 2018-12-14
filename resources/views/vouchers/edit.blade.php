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
        <h3 class="text-themecolor">Vouchers</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Voucher</h4>

              <form action="{{ route('voucher.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  name="name" id="name" value="{{ $data->name }}" required>
                      </div>

                      <div class="form-group">
                        <label for="">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ $area->code }}" required>
                      </div>

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $area->name }}" required>
                      </div>

                      <a href="{{ route('area.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save </button>

                    </div>

                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="">Latitude <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter Latitude" value="{{ $area->latitude }}" required >
                      </div>

                      <div class="form-group">
                        <label>Longitude <span class="text-danger">*</span></label>
                        <input type="text" name="longitude" class="form-control" id="longitude" placeholder="Enter Longitude" value="{{ $area->longitude }}" required>
                      </div>

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


<script>
$(function() {

});
</script>
@endsection

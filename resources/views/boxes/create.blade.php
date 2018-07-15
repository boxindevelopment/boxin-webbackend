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
        <h3 class="text-themecolor">Boxes</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Add Box</h4>

              @include('error-template')

              <form action="{{ route('box.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="" required>
                      </div>

                      <div class="form-group">
                        <label>Location </label>
                        <input type="text" name="location" class="form-control" placeholder="Enter Location" value="" >
                      </div>

                      <div class="form-group">
                        <label>Size <span class="text-danger">*</span></label>
                        <input type="text" name="size" class="form-control" placeholder="Enter Size" value="" required="">
                      </div>
                      
                      <div class="form-group">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" placeholder="Enter Price" value="" required="" >
                      </div>
                        
                      <hr>
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

<script>
$(function() {

});
</script>
@endsection

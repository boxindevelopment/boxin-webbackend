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

              <h4 class="card-title"><span class="lstick"></span>Edit Box</h4>

              @include('error-template')

              <form action="{{ route('box.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-8">

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $box->name }}" required>
                      </div>

                      <div class="form-group">
                        <label>Location </label>
                        <input type="text" name="location" class="form-control" placeholder="Enter Location" value="{{ $box->location }}" >
                      </div>

                      <div class="form-group">
                        <label>Size <span class="text-danger">*</span></label>
                        <input type="text" name="size" class="form-control" placeholder="Enter Size" value="{{ $box->size }}" required="">
                      </div>
                      
                      <div class="form-group">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" placeholder="Enter Price" value="{{ $box->price }}" required="" >
                      </div>
                        
                      <hr>
                      <a href="{{ route('box.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Edit</button>
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

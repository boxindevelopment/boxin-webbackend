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
        <h3 class="text-themecolor">Settings Price</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Price</h4>

              <form action="{{ route('price.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                      @foreach ($data as $key => $value)

                      <div class="form-group">
                        <label>Types of Size </label>
                        <input type="text" name="size" class="form-control" value="{{ $value->type_size->name }}" disabled>
                      </div>

                      <div class="form-group">
                        <label>Types of Duration </label>
                        <input type="text" name="duration" class="form-control" value="{{ $value->type_duration->name }}" disabled>
                      </div>

                      <div class="form-group">
                        <label>Price <span class="text-danger">*</span></label>
                        <input type="text" name="price" class="form-control" placeholder="Enter Price" value="{{ $value->price }}" min="0" required>
                      </div>

                      @endforeach
                      <a href="{{ route('price.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
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

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
        <h3 class="text-themecolor">Settings Others</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Others</h4>

              @include('error-template')

              <form action="{{ route('settings.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                      @foreach ($data as $key => $value)

                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $value->name }}" readonly>
                      </div>

                      <div class="form-group">
                        <label>Value <span class="text-danger">*</span></label>
                        <input type="text" name="value" class="form-control" placeholder="Enter Value" value="{{ $value->value }}" required>
                      </div>

                      <div class="form-group">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control" value="{{ $value->unit }}" readonly>
                      </div>

                      <div class="form-group">
                        <label>Description </label>
                        <textarea name="description" class="form-control" placeholder="Enter Description" rows="3">{{ $value->description }}</textarea> 
                      </div>
                      
                      @endforeach
                      <a href="{{ route('settings.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
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

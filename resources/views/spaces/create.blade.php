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
        <h3 class="text-themecolor">Add Space</h3>
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

              <form action="{{ route('space.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Code Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_name_space" id="id_name_space" required readonly>
                      </div>

                      <div class="form-group">
                        <label for="">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city_id" name="city_id" required>
                      </div>

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_id" name="area_id" required>
                      </div>

                      <div class="form-group">
                        <label>Name </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="" >
                      </div>

                      <div class="form-group">
                        <label>Latitude </label>
                        <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude" value="" >
                      </div>

                      <div class="form-group">
                        <label>Longitude </label>
                        <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude" value="" >
                      </div>
                      
                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save </button>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Types of Size <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="type_size_id" required>
                          <option value=""></option>
                          @if (!empty($type_size))
                            @foreach ($type_size as $key => $value)
                              <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->size }})</option>
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Total Space <span class="text-danger">*</span></label>
                        <input type="number" name="count_space" class="form-control" placeholder="How many spaces do you want to create?" min=1 required >
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
<script type="text/javascript">  

  $(document).ready( function() {
  
  });
</script>
@endsection

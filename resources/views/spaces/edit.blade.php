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
        <h3 class="text-themecolor">Spaces</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Space</h4>

              @include('error-template')

              <form action="{{ route('space.update', ['id' => $id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">

                      <div class="form-group">
                        <label for="">Code Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_name_space" id="id_name_space" value="{{ $space->id_name }}" required readonly>
                      </div>

                      <div class="form-group">
                        <label for="">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city_id" name="city_id" value="{{ $space->city_id }}##{{ $space->city_id_name }}" required>
                      </div>

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_id" name="area_id" value="{{ $space->area_id }}##{{ $space->area_id_name }}" required>
                      </div>

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $space->name }}" required>
                      </div>

                      <div class="form-group">
                        <label>Latitude </label>
                        <input type="text" name="latitude" class="form-control" placeholder="Enter Latitude" value="{{ $space->lat }}" >
                      </div>

                      <div class="form-group">
                        <label>Longitude </label>
                        <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude" value="{{ $space->long }}" >
                      </div>
  
                      <a href="{{ route('space.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Types of Size <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="type_size_id" required>
                          @if (!empty($type_size))
                            @foreach ($type_size as $key => $value)
                              @if ($value->id == $space->types_of_size_id)
                                <option value="{{ $value->id }}" selected>{{ $value->name }} ({{ $value->size }})</option>
                              @else
                                <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->size }})</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
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
 
</script>
@endsection

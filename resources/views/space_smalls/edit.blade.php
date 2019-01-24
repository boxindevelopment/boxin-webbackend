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
                        <input type="text" class="form-control" name="code_space_smalls" id="code_space_smalls" value="{{ $space->code_space_smalls }}" required readonly>
                      </div>

                      <div class="form-group">
                        <label for="">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city_id" name="city_id" value="{{ $space->shelves->area->city->id }}##{{ $space->shelves->area->city->id_name }}" required>
                      </div>

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_id" name="area_id" value="{{ $space->shelves->area->id }}##{{ $space->shelves->area->id_name }}" required>
                      </div>

                      <div class="form-group">
                        <label for="">Shelf <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="shelves_id" name="shelves_id" value="{{ $space->shelves_id }}##{{ $space->shelves->name }}" required>
                      </div>

                      <a href="{{ route('box.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                    </div>
                    <div class="col-md-6">
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

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $space->name }}" required="">
                      </div>

                      <div class="form-group">
                        <label>Location </label>
                        <input type="text" name="location" class="form-control" placeholder="Enter Location" value="{{ $space->location }}" >
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

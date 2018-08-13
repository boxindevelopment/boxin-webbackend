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
        <h3 class="text-themecolor">Rooms</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Room</h4>

              <form action="{{ route('room.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label for="">Space <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="space_id" required>
                          <option value=""></option>
                          @if (!empty($space))
                            @foreach ($space as $key => $value)
                              @if ($value->id == $room->space_id)
                                <option value="{{ $value->id }}" selected>{{ $value->name }} ({{ $value->warehouse->name }})</option>
                              @else
                                <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->warehouse->name }})</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="">Types of Size <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="type_size_id" required>
                          <option value=""></option>
                          @if (!empty($type_size))
                            @foreach ($type_size as $key => $value)
                              @if ($value->id == $room->types_of_size_id)
                                <option value="{{ $value->id }}" selected>{{ $value->name }} ({{ $value->size }})</option>
                              @else
                                <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->size }})</option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Name </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $room->name }}" >
                      </div>

                      <a href="{{ route('room.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
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

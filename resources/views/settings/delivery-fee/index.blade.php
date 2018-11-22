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
        <h3 class="text-themecolor">
          Settings Delivery Fee
        </h3>
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
              
              <h4 class="card-title"><span class="lstick"></span>Add Delivery Fee</h4>

              @include('error-template')

              <form action="{{ route('delivery-fee.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city_id" name="city_id" required>
                      </div>

                      <div class="form-group">
                        <label for="">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="area_id" name="area_id" required>
                      </div>

                      <div class="form-group">
                        <label>Fee <span class="text-danger">*</span></label>
                        <input type="text" name="fee" class="form-control" placeholder="Enter Fee" value="" required>
                      </div>

                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save </button>
                    </div>
                </div>
              </form>

            </div>
        </div>
    </div> 

    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><span class="lstick"></span>List Delivery Fee</h4>

              <div class="table-responsive m-t-10">
                  <table id="table-setting" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Area</th>
                          <th width="40%">Fee</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($data) > 0)
                        @foreach ($data as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->area->name }}</td>                            
                            <td>{{ $value->fee }}</td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('delivery-fee.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="4" class="text-center">There are no results yet</td>
                        </tr>
                      @endif
                    </tbody>
                </table>
              </div>

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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-setting').DataTable({
    "aaSorting": []
  });
});
</script>
@endsection

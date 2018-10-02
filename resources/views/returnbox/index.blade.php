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
          Return Boxes
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
    <div class="col-6">
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><span class="lstick"></span>Delivery Box</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-data1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Customer Name</th>
                          <th width="25%" class="text-center">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($data1) > 0)
                        @foreach ($data1 as $key => $value)
                          <tr style="background-color: antiquewhite">
                            <td align="center">{{ $key+1 }}</td>
                            <td>{{ $value->first_name}} {{ $value->last_name}}</td>
                            <td class="text-center">
                              @php
                                if($value->status_id == 11){
                                  $label = 'label-danger';
                                }else if($value->status_id == 2 || $value->status_id == 3){
                                  $label = 'label-warning';
                                }else{
                                  $label = 'label-success';
                                }
                              @endphp
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('return.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
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

    <div class="col-6">
        <div class="card">
            <div class="card-body">
              <h4 class="card-title"><span class="lstick"></span>Get On Warehouse</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-data2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Customer Name</th>
                          <th width="25%" class="text-center">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($data2) > 0)
                        @foreach ($data2 as $key => $value)
                          <tr style="background-color: aliceblue">
                            <td align="center">{{ $key+1 }}</td>
                            <td>{{ $value->first_name}} {{ $value->last_name}}</td>
                            <td class="text-center">
                              @php
                                if($value->status_id == 11){
                                  $label = 'label-danger';
                                }else if($value->status_id == 2 || $value->status_id == 3){
                                  $label = 'label-warning';
                                }else{
                                  $label = 'label-success';
                                }
                              @endphp
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('return.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
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
  $('#table-data1').DataTable({
    "aaSorting": []
  });
  $('#table-data2').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

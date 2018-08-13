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
          Settings Price
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
              <h4 class="card-title"><span class="lstick"></span>Price Box</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-box" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="3%">No</th>
                          <th width="">Type Size</th>                          
                          <th width="">Type Duration</th>
                          <th width="20%">Price</th>
                          <th width="3%" class="text-center no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($boxes) > 0)
                        @foreach ($boxes as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->type_size->name }}</td>   
                            <td>{{ $value->type_duration->name }}</td>                            
                            <td>{{ $value->price }}</td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('price.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="4" class="text-center"> Data Not Found</td>
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
              <h4 class="card-title"><span class="lstick"></span>Price Rooms</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-room" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="3%">No</th>
                          <th width="">Type Size</th>                          
                          <th width="">Type Duration</th>
                          <th width="20%">Price</th>
                          <th width="3%" class="text-center no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($rooms) > 0)
                        @foreach ($rooms as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->type_size->name }}</td>   
                            <td>{{ $value->type_duration->name }}</td>                            
                            <td>{{ $value->price }}</td>
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('price.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="4" class="text-center"> Data Not Found</td>
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
  $('#table-box').DataTable({
    "aaSorting": []
  });
  $('#table-room').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

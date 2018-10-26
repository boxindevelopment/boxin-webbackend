@extends('layouts.master')

@section('plugin_css')
  <!-- page css -->
  <link href="{{asset('assets/css/pages/tab-page.css')}}" rel="stylesheet">
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><span class="lstick"></span>Settings Price</h4>
                @include('error-template')
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Price Box</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Price Room</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="p-20">
                            <div class="table-responsive m-t-10">
                              <table id="table-box" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                      <th width="3%">No</th>
                                      <th width="">City</th>
                                      <th width="">Type Size</th>                           
                                      <th width="">Type Duration</th>
                                      <th width="" class="text-right">Price (Rp)</th>
                                      <th width="3%" class="text-center no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @if (count($boxes) > 0)
                                    @foreach ($boxes as $key => $value)
                                      <tr>
                                        <td align="center">{{ $key+1 }}</td>
                                        <td>{{ $value->city->name }}</td>   
                                        <td>{{ $value->type_size->name }}</td>   
                                        <td>{{ $value->type_duration->name }}</td>                            
                                        <td class="text-right">{{ number_format($value->price, 0, '', '.') }}</td>
                                        <td class="text-center">
                                          <a class="btn btn-primary btn-sm" href="{{route('price.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                                        </td>
                                      </tr>
                                    @endforeach
                                  @else
                                    <tr>
                                      <td colspan="6" class="text-center">There are no results yet</td>
                                    </tr>
                                  @endif
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-20" id="profile" role="tabpanel">
                      <div class="table-responsive m-t-10">
                        <table id="table-room" class="table table-striped table-bordered">
                          <thead>
                              <tr>
                                <th width="3%">No</th>
                                <th width="">City</th>
                                <th width="">Type Size</th>                           
                                <th width="">Type Duration</th>
                                <th width="" class="text-right">Price (Rp)</th>
                                <th width="3%" class="text-center no-sort"></th>
                              </tr>
                          </thead>
                          <tbody>
                            @if (count($rooms) > 0)
                              @foreach ($rooms as $key => $value)
                                <tr>
                                  <td align="center">{{ $key+1 }}</td>
                                  <td>{{ $value->city->name }}</td>   
                                  <td>{{ $value->type_size->name }}</td>   
                                  <td>{{ $value->type_duration->name }}</td>                            
                                  <td class="text-right">{{ number_format($value->price, 0, '', '.') }}</td>
                                  <td class="text-center">
                                    <a class="btn btn-primary btn-sm" href="{{route('price.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="6" class="text-center"> Data Not Found</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
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

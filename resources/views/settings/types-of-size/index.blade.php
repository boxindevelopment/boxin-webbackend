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
          Settings Size
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
                <h4 class="card-title"><span class="lstick"></span>List Settings Size</h4>
                @include('error-template')
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Size Box</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Size Room</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="home" role="tabpanel">
                        <div class="p-20">
                            <a href="{{ route('types-of-size.createBox') }}" class="btn waves-effect waves-light btn-sm btn-primary" title="Add" style="margin-right: 10px;"><i class="fa fa-plus"></i>&nbsp;Add Size Box
                            </a>
                            <div class="table-responsive m-t-10">
                              <table id="table-box" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                      <th width="5%">No</th>
                                      <th width="">Name</th>
                                      <th width="30%">Size</th>
                                      <th width="5%" class="text-center no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @if (count($boxes) > 0)
                                    @foreach ($boxes as $key => $value)
                                      <tr>
                                        <td align="center">{{ $key+1 }}</th>
                                        <td>{{ $value->name }}</td>                            
                                        <td>{{ $value->size }}</td>
                                        <td class="text-center">
                                          <a class="btn btn-info btn-sm" href="{{route('types-of-size.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
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
                    <div class="tab-pane p-20" id="profile" role="tabpanel">
                      <a href="{{ route('types-of-size.createRoom') }}" class="btn waves-effect waves-light btn-sm btn-primary" title="Add" style="margin-right: 10px;"><i class="fa fa-plus"></i>&nbsp;Add Size Room
                      </a>
                      <div class="table-responsive m-t-10">
                        <table id="table-room" class="table table-striped table-bordered">
                          <thead>
                              <tr>
                                <th width="5%">No</th>
                                <th width="">Name</th>
                                <th width="">Size</th>
                                <th width="5%" class="text-center no-sort">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @if (count($rooms) > 0)
                              @foreach ($rooms as $key => $value)
                                <tr>
                                  <td align="center">{{ $key+1 }}</th>
                                  <td>{{ $value->name }}</td>                            
                                  <td>{{ $value->size }}</td>
                                  <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{route('types-of-size.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
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

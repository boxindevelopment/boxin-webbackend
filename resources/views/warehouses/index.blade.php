@extends('layouts.master')

@section('plugin_css')
<!-- Popup CSS -->
<link href="{{asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
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
          List Warehouse
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

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-menus" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="15%" class="text-center">Code Number</th>
                          <th width="20%">Area</th>
                          <th width="">Name</th>
                          <th width="12%" class="no-sort">Latitude</th>
                          <th width="12%" class="no-sort">Longitude</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($warehouse) > 0)
                        @foreach ($warehouse as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>                              
                            <td align="center">{{ $value->id_name }}</td>
                            <td>{{ $value->area->name }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->lat }}</td>
                            <td>{{ $value->long }}</td>
                            <td class="text-center">
                              <form action="{{route('warehouses.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-info btn-sm" href="{{route('warehouses.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                                @method('DELETE')
                                <button type="submit" name="remove" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
              </div>
            
              <!-- sample modal content -->
              <div class="modal fade bs-example-modal-lg" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myLargeModalLabel">Confirmation</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          </div>
                          <div class="modal-body" style="text-align: center;">
                              <h4>[Delete]</h4>
                              <p>Are you sure to delete this warehouse ?</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
                              <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete</button>
                          </div>
                      </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->   

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
<!-- Magnific popup JavaScript -->
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
    
<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-menus').DataTable({
    "aaSorting": []
  });
});
</script>
@endsection

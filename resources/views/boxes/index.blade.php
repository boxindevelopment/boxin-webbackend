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
          Boxes
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

              <h4 class="card-title"><span class="lstick"></span>Add Box</h4>

              @include('error-template')

              <form action="{{ route('box.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Space <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="space_id" required>
                          <option value=""></option>
                          @if (!empty($space))
                            @foreach ($space as $key => $value)
                              <option value="{{ $value->id }}">{{ $value->name }} ({{ $value->warehouse->name }})</option>
                            @endforeach
                          @endif
                        </select>
                      </div> 
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
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="">
                      </div>
                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Location </label>
                        <input type="text" name="location" class="form-control" placeholder="Enter Location" value="" >
                      </div>                      
                    </div>

                </div>
              </form>

            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">

              <h4 class="card-title"><span class="lstick"></span>List Boxes</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-ingrd" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Name</th>
                          <th width="10%">Type</th>
                          <th width="12%">Size</th>
                          <th width="20%">Space</th>
                          <th width="20%">Location</th>
                          
                          <th width="15%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($box) > 0)
                        @foreach ($box as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->type_size->name }}</td>
                            <td>{{ $value->type_size->size }}</td>
                            <td>{{ $value->space->name }}</td>
                            <td>{{ $value->location }}</td>
                            <td class="text-center">
                              <form action="{{route('box.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-info btn-sm" href="{{route('box.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i> Edit</a>
                                @method('DELETE')
                                <button type="submit" name="remove" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
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
                              <p>Are you sure to delete this box ?</p>
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


<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-ingrd').DataTable({
    "aaSorting": []
  });


});
</script>
@endsection

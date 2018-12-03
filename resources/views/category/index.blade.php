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
          Category
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
              
              <h4 class="card-title"><span class="lstick"></span>Add Category</h4>

              @include('error-template')

              <form action="{{ route('category.store') }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="" required>
                      </div>

                      <div class="form-group">
                        <label>Description </label>
                        <textarea name="description" class="form-control" placeholder="Enter Description" rows="3"></textarea> 
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
              <h4 class="card-title"><span class="lstick"></span>List Category</h4>

              <div class="table-responsive m-t-10">
                  <table id="table-setting" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Name</th>
                          <th width="60%">Description</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($data) > 0)
                        @foreach ($data as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->name }}</td>  
                            <td>{{ $value->description }}</td> 
                            <td class="text-center">
                              <form action="{{route('category.destroy', ['id' => $value->id])}}" method="post">
                                @csrf
                                <a class="btn btn-info btn-sm" href="{{route('category.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
                                @method('DELETE')
                                <button type="submit" name="remove" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                              </form>                              
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="3" class="text-center">There are no results yet</td>
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

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
          Settings Others
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
              <h4 class="card-title"><span class="lstick"></span>List Others</h4>

              <div class="table-responsive m-t-10">
                  <table id="table-setting" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="">Name</th>
                          <th width="">Value</th>
                          <th width="">Unit</th>
                          <th width="20%">Description</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (count($data) > 0)
                        @foreach ($data as $key => $value)
                          <tr>
                            <td align="center">{{ $key+1 }}</th>
                            <td>{{ $value->name }}</td>                            
                            <td>{{ $value->value }}</td>                      
                            <td>{{ $value->unit }}</td>
                            <td>{{ $value->name != 'term_and_conditions' ? $value->description : substr($value->description,0,100).'...' }}</td>  
                            <td class="text-center">
                              <a class="btn btn-primary btn-sm" href="{{route('settings.edit', ['id' => $value->id])}}"><i class="fa fa-pencil"></i></a>
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

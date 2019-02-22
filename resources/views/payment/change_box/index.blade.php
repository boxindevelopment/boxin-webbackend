@extends('layouts.master')

@section('plugin_css')
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
          Change Item Box Payments
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
              <h4 class="card-title"><span class="lstick"></span>List Change Item Box Payments</h4>

              @include('error-template')

              <div class="table-responsive m-t-10">
                  <table id="table-pay" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th width="10%">ID</th>
                          <th width="">Customer Name</th>
                          <th width="10%" class="text-center">Image</th>
                          <th width="15%" class="text-center">Status</th>
                          <th width="5%" class="text-center no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($data) > 0)
                        @foreach ($data as $key => $value)
                          @php
                            if($value->status_id == 15){
                              $label = 'label-warning';
                            }else if($value->status_id == 7){
                              $label = 'label-success';
                            }else if($value->status_id == 8){
                              $label = 'label-danger';
                            }
                          @endphp
                          <tr>
                            <td align="center">{{ $key+1 }}</td>
                            <td align="center">{{ $value->id_name }}</td>
                            <td>{{ $value->first_name}} {{ $value->last_name}} </td>
                            <td class="text-center">
                              <a class="btn default btn-info btn-sm image-popup-vertical-fit" href="{{ $value->image }}">
                                <i class="fa fa-file-image-o"></i>
                                <div style="display: none;">
                                    <img width="50%" src="{{ $value->image }}" alt="image" />
                                </div>
                              </a>
                            </td>
                            <td class="text-center">
                              <span class="label {{ $label }} label-rounded">{{ $value->status->name }}</span>
                            </td>
                            <td class="text-center">
                              <a class="btn btn-info btn-sm" href="{{route('change-box-payment.edit', ['id' => $value->id])}}" title="Edit"><i class="fa fa-pencil"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <tr>
                          <td colspan="5" class="text-center">There are no results yet</td>
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
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>

<!--END PLUGIN JS -->


<!--SCRIPT JS -->
<script>
$(function() {
  $('#table-pay').DataTable({
    "aaSorting": []
  });
});
</script>
@endsection

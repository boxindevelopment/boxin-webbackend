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
        <h3 class="text-themecolor">Vouchers</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Voucher</h4>

              <form action="{{ route('voucher.update', ['id' => $id]) }}" method="POST" enctype="multipart/form-data" id="myForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                      
                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $data->name }}" required>
                      </div>

                      <div class="form-group">
                        <label>Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code" value="{{ $data->code }}" required>
                      </div>

                      <div class="form-group">
                        <label>Available Date <span class="text-danger">*</span></label>
                          <div class="col-md-6" style="display: flex">
                              <input class="form-control" type="date" value="{{ date_format($data->start_date, 'Y-m-d') }}" placeholder="Start Date" name="start_date" id="start_date" >&nbsp;-&nbsp; 
                              <input class="form-control" type="date" value="{{ date_format($data->end_date, 'Y-m-d') }}" placeholder="End Date" name="end_date" id="end_date">
                          </div>
                      </div>                     

                      <div class="">
                        <label>Type Voucher <span class="text-danger">*</span></label>
                        <div class="demo-radio-button">
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_percen" value="1" <?php if ($data->type_voucher == 1) echo 'checked' ; ?>/>
                          <label for="type_voucher_percen">Percen</label>
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_nominal" value="2" <?php if ($data->type_voucher == 2) echo 'checked'; ?> />
                          <label for="type_voucher_nominal">Nominal</label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Value <span class="text-danger">*</span></label>                      
                        <div class="input-group" <?php if ($data->type_voucher == 2) echo 'style="display: none"' ; ?> >
                            <input type="number" name="value1" id="value1" class="form-control value1" placeholder="Enter Percen" max="100" min="0" aria-describedby="basic-addon2" value="{{ $data->value }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                        <input <?php if ($data->type_voucher == 1) echo 'style="display: none"' ; ?> type="number" name="value2" id="value2" class="form-control value2" placeholder="Enter Nominal" min="0"  value="{{ $data->value }}" >
                      </div>
                    </div>

                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description" rows="3" required>{{ $data->description }}</textarea>
                      </div>

                      <div class="form-group">
                        <label>Image <span class="text-danger">*</span></label>
                        <input type="file" class="dropify" data-height="200" name="image" data-default-file="{{ asset('images/voucher')}}/{{ $data->image }}" value="{{ asset('images/voucher')}}/{{ $data->image }}" />
                      </div>

                      <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="status_id" required>
                            <option value="20" {{ $data->status_id == 20 ? 'selected' : '' }}>Actived</option>
                            <option value="21" {{ $data->status_id == 21 ? 'selected' : '' }}>Non Actived</option>
                        </select>
                      </div> 

                    </div>

                    <div class="col-md-12">
                      <hr>
                      <a href="{{ route('voucher.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
              </form>

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
<script type="text/javascript">  

$(document).ready( function() {
  $('#myForm input').on('change', function() {
     var val = $('input[name=type_voucher]:checked', '#myForm').val(); 
     if(val == '1'){
      $('#myForm .form-group .input-group').show();$('#value2').hide();
     }else if(val == '2'){
      $('#value2').show();$('#myForm .form-group .input-group').hide();
     }
  });
});

</script>

<script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>

<script>
$(document).ready(function() {
    // Basic
    $('.dropify').dropify();

    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });

    // Used events
    var drEvent = $('#input-file-events').dropify();

    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    })
});
</script>
@endsection

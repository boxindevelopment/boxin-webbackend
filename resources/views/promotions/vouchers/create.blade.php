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
        <h3 class="text-themecolor">Add Voucher</h3>
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

              <form action="{{ route('voucher.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
                      </div>

                      <div class="form-group">
                        <label>Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Enter Code" value="{{ old('code') }}" required>
                      </div>

                      <div class="form-group">
                        <label>Available Date <span class="text-danger">*</span></label>
                        <div class="col-md-12" style="display: flex">
                            <div class="input-group datepicker">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Enter Start Date" value="{{date('d/m/Y')}}" required>
                            </div>
                            <div class="input-group datepicker">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" name="end_date" id="end_date" placeholder="Enter End Date" value="{{date('d/m/Y')}}" required>
                            </div>
                        </div>
                      </div>

                      <div class="">
                        <label>Type Voucher <span class="text-danger">*</span></label>
                        <div class="demo-radio-button">
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_percen" value="1" {{ old('type_voucher')=="1" ? 'checked='.'"checked"' : '' }} checked />
                          <label for="type_voucher_percen">Percent</label>
                          <input name="type_voucher" type="radio" class="with-gap" id="type_voucher_nominal" value="2" {{ old('type_voucher')=="2" ? 'checked='.'"checked"' : '' }}/>
                          <label for="type_voucher_nominal">Nominal</label>
                        </div>
                    </div>

                      <div class="form-group">
                        <label>Value <span class="text-danger">*</span></label>
                        <div class="input-group" >
                            <div class="input-group-append value_nominal" style="display: none">
                                <span class="input-group-text" id="basic-addon2">Rp</span>
                            </div>
                            <input type="number" name="value" id="value" class="form-control value" placeholder="Enter Persen" max="" min="0" aria-describedby="basic-addon2" value="{{ old('value') }}" base_value="">
                            <div class="input-group-append value_discount">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                      </div>

                      <div class="form-group div_max_value">
                        <label>Max value <span class="text-danger">*</span></label>
                        <div class="input-group" >
                            <div class="input-group-append max_value_addon">
                                <span class="input-group-text" id="basic-addon3">Rp</span>
                            </div>
                            <input type="number" name="max_value" id="max_value" class="form-control max_value" placeholder="Enter Max Value" min="0" aria-describedby="basic-addon2" value="{{ old('max_value') }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Min Amount <span class="text-danger">*</span></label>
                        <div class="input-group" >
                            <div class="input-group-append min_amount_addon">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                            </div>
                            <input type="number" name="min_amount" id="min_amount" class="form-control min_amount" placeholder="Enter Min Amount" aria-describedby="basic-addon2" value="{{ old('min_amount') }}" base_value="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="select2" name="status_id" required>
                            <option value="20" {{ old('status_id') == 20 ? 'selected' : '' }}>Actived</option>
                            <option value="21" {{ old('status_id') == 21 ? 'selected' : '' }}>Non Actived</option>
                        </select>
                      </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Image <span class="text-danger">*</span></label>
                            <input type="file" class="dropify" data-height="200" name="image" data-default-file="" value="" required />
                        </div>

                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" rows="3" required>
                                {{Request::old('description')}}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label>Term & Conditions <span class="text-danger">*</span></label>
                            <textarea name="term_condition" id="term_condition" class="form-control" placeholder="Enter Term & Conditions" rows="3" required>
                                {{Request::old('term_condition')}}
                            </textarea>
                        </div>

                    </div>

                    <div class="col-md-12">
                      <hr>
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


$('#start_date').datepicker({
    autoclose: true,
	format: 'dd/mm/yyyy',
	todayHighlight: true,
	startDate: '0d'
}).on('changeDate', function(selected){
    startDate = new Date(selected.date.valueOf());
    startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
    $('#end_date').datepicker('setStartDate', startDate);
});
$('#end_date').datepicker({
    autoclose: true,
	format: 'dd/mm/yyyy',
	todayHighlight: true,
	startDate: '0d'
 });

$(document).ready( function() {
  $('#value').on('keyup', function() {
      value = $(this).val();
      $('#value').attr('base_value', value);
     var val = $('input[name=type_voucher]:checked', '#myForm').val();
     if(val == '2'){
        $('#myForm .div_max_value #max_value').val(value);
     }   
  });
  $('#myForm input').on('change', function() {
     var val = $('input[name=type_voucher]:checked', '#myForm').val();
     if(val == '1'){
        $('#myForm .form-group .input-group .value_discount').show();
        $('#myForm .form-group .input-group .value_nominal').hide();
        $('#myForm .div_max_value').show();
        // $('#value2').hide();
        $('#value').attr('placeholder', 'Enter Percent');
        $('#value').attr('max', 100);
        var value = $('.form-group .input-group #value').val();
        if(value > 100){
            $('#value').val(100);
        }
     }else if(val == '2'){
        // $('#value2').show();
        $('#myForm .form-group .input-group .value_discount').hide();
        $('#myForm .form-group .input-group .value_nominal').show();
        $('#myForm .div_max_value').hide();
        $('#value').attr('placeholder', 'Enter Nominal');
        $('#value').attr('max', 10000000000000000);
        var value = $('#value').attr('base_value');
        $('#value').val(value);
        $('#max_value').val(value);
     }
  });
});

</script>

<script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
<!-- CKeditor -->
<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script>
$(document).ready(function() {

    CKEDITOR.replace('description', {
        // Remove the redundant buttons from toolbar groups defined above.
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,Image,About,Preview,Source'
    });

    CKEDITOR.replace('term_condition', {
        // Remove the redundant buttons from toolbar groups defined above.
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,Image,About,Preview,Source'
    });

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

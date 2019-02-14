@extends('layouts.master')

@section('plugin_css')
  <link rel="stylesheet" href="{{asset('assets/plugins/html5-editor/bootstrap-wysihtml5.css')}}" />
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
        <h3 class="text-themecolor">Settings Others</h3>
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

              <h4 class="card-title"><span class="lstick"></span>Edit Others</h4>

              @include('error-template')

              <form action="{{ route('settings.update', ['id' => $id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
                @csrf
                @method('PUT')
                <div class="row">
                    @foreach ($data as $key => $value)
                    
                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $value->name }}" readonly>
                      </div>

                      <div class="form-group">
                        <label>Value <span class="text-danger">*</span></label>
                        <input type="text" name="value" class="form-control" placeholder="Enter Value" value="{{ $value->value }}" required>
                      </div>

                      @if($value->name != 'term_and_conditions')
                      <div class="form-group">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control" value="{{ $value->unit }}" readonly>
                      </div>
                      
                      <div class="form-group">
                        <label>Description </label>
                        <textarea name="description" class="form-control" placeholder="Enter Description" rows="3">{{ $value->description }}</textarea> 
                      </div>

                      <a href="{{ route('settings.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                      @endif

                    </div>

                    @if($value->name == 'term_and_conditions')                      
                      <div class="col-12">
                        <label>Description</label>
                          <div class="card">
                            {{-- <textarea id="mymce" name="description">{{ $value->description }}</textarea>    --}}
                            <div class="form-group">
                                <textarea class="textarea_editor form-control" rows="15" placeholder="Enter text ..." name="description">{{ $value->description }}</textarea>
                            </div>
                          </div>
                      <a href="{{ route('settings.index') }}" class="btn btn-secondary waves-effect waves-light m-r-10">Back</a>
                      <button type="submit" class="btn btn-info waves-effect waves-light m-r-10"><i class="fa fa-pencil"></i> Save</button>
                      </div>
                    @endif

                    @endforeach
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

{{-- <script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
<script>
$(document).ready(function() {

    if ($("#mymce").length > 0) {
        tinymce.init({
            selector: "textarea#mymce",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

        });
    }
});
</script> --}}

<script src="{{asset('assets/plugins/html5-editor/wysihtml5-0.3.0.js')}}"></script>
<script src="{{asset('assets/plugins/html5-editor/bootstrap-wysihtml5.js')}}"></script>
<script>
$(document).ready(function() {

    $('.textarea_editor').wysihtml5();


});
</script>

@endsection

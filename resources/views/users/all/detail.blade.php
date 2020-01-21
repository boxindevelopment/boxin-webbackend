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
          Detail User
        </h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <button onclick="window.location.href='{{ $url }}'" class="btn waves-effect waves-light m-r-10" style="background-color: white;"><i class="mdi mdi-arrow-left-bold-circle"></i> Back</button>
        </ol>
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

          <div class="card-body collapse show">
            @include('error-template')
            <h5 class="card-title"><span class="lstick"></span><b>* Profile User</b></h5>
            <form class="form-material row">
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">First Name</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $user->first_name }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Last Name</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $user->last_name }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Phone</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $user->phone }}" readonly>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Email</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control form-control-line" value="{{ $user->email }}" readonly>{{$user->image}}
                </div>
                <div class="form-group col-md-2">
                    <label for="inputEmail3" class="text-right control-label col-form-label">Status</label>
                </div>
                <div class="form-group col-md-4">
                    <span class="label {{ $user->status == 1 ? 'label-success' : 'label-danger' }} label-rounded" style="margin-top: 9px;">{{ $user->status == 1 ? 'Verified' : 'Not Verified'  }}</span>
                </div>
                @if($user->image)
                    <div class="form-group col-md-12">
                        <img src="{{$user->image}}">
                    </div>
                @endif
            </form>
            @if(count($user->addresses))
                <h5 class="card-title"><span class="lstick"></span><b>* Address</b></h5>
                <form class="form-material row">
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Address</label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->address }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Kel./Desa</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->village->name }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Kecamatan</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->village->district->name }}" readonly>
                    </div>
                    @if($user->addresses[0]->apartment_name != '')
                        <div class="form-group col-md-2">
                            <label for="inputEmail3" class="text-right control-label col-form-label">Nama Apartemen</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->apartment_name }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail3" class="text-right control-label col-form-label">Tower Apartemen</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->apartment_tower }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail3" class="text-right control-label col-form-label">Lantai Apartemen</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->apartment_floor }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputEmail3" class="text-right control-label col-form-label">Nomor Apartemen</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->apartment_number }}" readonly>
                        </div>
                    @endif
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">RT</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->rt }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">RW</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->village->rw }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">KAB/Kota</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->village->district->regency->name }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Propinsi</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->village->district->regency->province->name }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputEmail3" class="text-right control-label col-form-label">Kode Pos</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control form-control-line" value="{{ $user->addresses[0]->postal_code }}" readonly>
                    </div>
                </form>
            @endif
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

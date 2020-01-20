@extends('layouts.master')

@section('plugin_css')

@endsection

@section('script_css')
<style>
.form-group {
    text-align: left;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Add Sale</h3>
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

              <form action="{{ route('order.store') }}" method="POST" id="myForm" class="formUser">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>User <span class="text-danger">*</span></label>
                        <input type="text" class="form-control user_select2" name="user_id" id="user_id" placeholder="Enter Name" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control area_select2" name="area_id" id="area_id" placeholder="Enter Area" required>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control address_select2" name="address_id" id="address_id" placeholder="Enter Adress" required>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <div class="input-group datepicker">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" name="date" id="date" placeholder="Enter Date" value="{{date('d/m/Y')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Time <span class="text-danger">*</span></label>
                            <div class="input-group clockpicker">
                                <input type="text" class="form-control" name="time" id="time" placeholder="Enter Time" value="{{date('H:i')}}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ti-timer"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pickup fee <span class="text-danger">*</span></label>
                            <select class="form-control" name="types_of_pickup_id" id="types_of_pickup_id" required>
                                <option value=""></option>
                                <option value="1" '+userSelected+'>Delivery box</option>
                                <option value="2" '+warehouseSelected+'>Box on warehouse</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pickup fee <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" name="pickup_fee" id="pickup_fee" placeholder="Enter Pickup fee" value="50000" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="note" id="note" placeholder="Enter Note">
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <table id="table-det-order" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th width="20%">Space/Box</th>
                              <th width="25%">Type Size</th>
                              <th width="45%">Duration</th>
                              <th width="10%" class="text-center no-sort">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;">
                                    <button type="button" class="btn btn-primary waves-effect waves-light m-r-10 btn-add-row"><i class="fa fa-plus"></i>Add Row</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <hr>
                      <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save</button>
                    </div>
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

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" id="ModalUserForm" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 1024px;">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myLargeModalLabel">Create New User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <form action="{{ route('user.store') }}" method="POST" id="myFormUser" class="formUser">
              @csrf
              <div class="modal-body" style="text-align: center;">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>First Name <span class="text-danger">*</span></label>
                          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Last Name <span class="text-danger">*</span></label>
                          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name">
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Phone <span class="text-danger">*</span></label>
                          <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email <span class="text-danger">*</span></label>
                          <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Password <span class="text-danger">*</span></label>
                          <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Password Confirmation <span class="text-danger">*</span></label>
                          <input type="password" name="confirmation_password" id="confirmation_password" class="form-control" required>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Propinsi <span class="text-danger">*</span></label>
                          <input type="text" name="province_id" id="province_id" class="form-control" placeholder="Enter Propinsi" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>KAB/Kota <span class="text-danger">*</span></label>
                          <input type="text" name="regency_id" id="regency_id" class="form-control" placeholder="Enter KAB/Kota" required>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Kecamatan <span class="text-danger">*</span></label>
                          <input type="text" name="district_id" id="district_id" class="form-control" placeholder="Enter Kecamatan" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>KEL/Desa <span class="text-danger">*</span></label>
                          <input type="text" name="village_id" id="village_id" class="form-control" placeholder="Enter KEL/Desa" required>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>ALamat <span class="text-danger">*</span></label>
                          <input type="text" name="address" id="addres" class="form-control" placeholder="Enter Alamat" required>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Kode Pos <span class="text-danger">*</span></label>
                          <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Enter Kode Pos" required>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="save-user">Save</button>
              </div>
        </form>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('close_html')
<!--PLUGIN JS -->
<script type="text/javascript">

$('#date').datepicker();

function user_Selectdata(values) {
    var data = $.ajax({
        url: "{{ url('/user/dataSelect/all') }}",
        type: "GET",
        data: { }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            arrs.push( {
                id : obj[i].id,
                text : obj[i].text
            } );
        }
        console.log(arrs);
        $("#user_id").select2({
            multiple: false,
            placeholder: 'Choose User',
            tags: true,
            data : arrs,
            language: {
            noResults: function() {
                return "<a v href='#'class='add-new-user' data-toggle='modal' data-target='#ModalUserForm'>Add new user</a>";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }).on('change', function (e) {
            var user_id = $(this).val();
        });
    });

    if(values != ''){
        $("#user_id").val(values).trigger('change');
    }
}
if($("#user_id").hasClass("user_select2")){
    user_Selectdata('');
}

$(document).on('click','.add-new-user', function(){
    var valSelect2 = $(this).parent().parent().parent().parent().find('.select2-search input').val();
    console.log(`valSelect2:${valSelect2}`);
    $('#first_name').val(valSelect2);
    $('#first_name').focus();
    $('#ModalUserForm').on('shown.bs.modal', function () {
        $('#first_name').focus();
    })
    $("#user_id").select2().trigger("select2:close");
});

function province_Selectdata(values) {
    var data = $.ajax({
        url: "{{ url('/country/province/dataSelect/all') }}",
        type: "GET",
        data: { }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            arrs.push( {
                id : obj[i].id,
                text : obj[i].text
            } );
        }
        $("#province_id").select2({
            multiple: false,
            placeholder: 'Choose Province',
            tags: true,
            data : arrs
        }).on('change', function (e) {
            var province_id = $(this).val();
            regency_Selectdata(province_id, '');
        });
    });

    if(values != ''){
        $("#province_id").val(values).trigger('change');
    }

}
province_Selectdata('');
function regency_Selectdata(province_id, values) {
    var data = $.ajax({
        url: "{{ url('/country/regency/dataSelect/all') }}",
        type: "GET",
        data: { province_id: province_id }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            arrs.push( {
                id : obj[i].id,
                text : obj[i].text
            } );
        }
        $("#regency_id").select2({
            multiple: false,
            placeholder: 'Choose Regency',
            tags: true,
            data : arrs
        }).on('change', function (e) {
            var regency_id = $(this).val();
            district_Selectdata(regency_id, '');
        });
    });

    if(values != ''){
        $("#regency_id").val(values).trigger('change');
    }

}
function district_Selectdata(regency_id, values) {
    var data = $.ajax({
        url: "{{ url('/country/district/dataSelect/all') }}",
        type: "GET",
        data: { regency_id: regency_id }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            arrs.push( {
                id : obj[i].id,
                text : obj[i].text
            } );
        }
        $("#district_id").select2({
            multiple: false,
            placeholder: 'Choose District',
            tags: true,
            data : arrs
        }).on('change', function (e) {
            var district_id = $(this).val();
            village_Selectdata(district_id, values);
        });
    });

    if(values != ''){
        $("#district_id").val(values).trigger('change');
    }

}
function village_Selectdata(district_id, values) {
    var data = $.ajax({
        url: "{{ url('/country/village/dataSelect/all') }}",
        type: "GET",
        data: { district_id: district_id }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            arrs.push( {
                id : obj[i].id,
                text : obj[i].text
            } );
        }
        $("#village_id").select2({
            multiple: false,
            placeholder: 'Choose Village',
            tags: true,
            data : arrs
        }).on('change', function (e) {
            var village_id = $(this).val();
        });
    });

    if(values != ''){
        $("#village_id").val(values).trigger('change');
    }

}

if($("#user_id").hasClass("user_select2")){
    user_Selectdata('');
}
function area_Selectdata(values) {
    var data = $.ajax({
        url: "{{ url('/area/dataSelect') }}",
        type: "GET",
        data: { }
    })
    .done(function(data) {
        var obj = jQuery.parseJSON(data);
        arrs = [];
        for (var i = 0; i<obj.length; i++) {
            var $area_id =  obj[i].id.split('##');
            arrs.push( {
                id : $area_id[0],
                text : obj[i].text
            } );
        }
        $("#area_id").select2({
            multiple: false,
            placeholder: 'Choose Area',
            tags: true,
            data : arrs
        }).on('change', function (e) {
            var area_id = $(this).val();
        });
    });

    if(values != ''){
    }
}
area_Selectdata('');

function tableDetOrder(spaceBox, typeSize, duration, typeDuration, typePickup, row){
    var daySelected = (typeDuration == 1) ? 'selected' : '';
    var weekSelected = (typeDuration == 2) ? 'selected' : '';
    var monthSelected = (typeDuration == 3) ? 'selected' : '';
    var boxSelected = (spaceBox == 1) ? 'selected' : '';
    var spaceSelected = (spaceBox == 2) ? 'selected' : '';
    var userSelected = (typePickup == 1) ? 'selected' : '';
    var warehouseSelected = (typePickup == 2) ? 'selected' : '';
    var htmlDetail = '<tr no="'+row+'">';
        htmlDetail += '<td>';
            htmlDetail += '<select class="form-control" name="types_of_box_room_id[]" required>';
                htmlDetail += '<option value=""></option>';
                htmlDetail += '<option value="1" '+boxSelected+'>Box</option>';
                htmlDetail += '<option value="2" '+spaceSelected+'>Space</option>';
            htmlDetail += '</select>';
        htmlDetail += '</td>';
        htmlDetail += '<td><select class="form-control" name="types_of_size_id[]" required><option value="1">Small Box</option></select></td>';
        htmlDetail += '<td>';
            htmlDetail += '<div class="row">';
                htmlDetail += '<div class="col-md-6" style="padding-right: 1px;">';
                    htmlDetail += '<input type="number" name="duration[]" id="duration" class="form-control" value="'+duration+'" required>';
                htmlDetail += '</div>';
                htmlDetail += '<div class="col-md-6" style="padding-left: 1px;">';
                    htmlDetail += '<select class="form-control" name="types_of_duration_id[]" required>';
                        htmlDetail += '<option value="1" '+daySelected+'>Day</option>';
                        htmlDetail += '<option value="2" '+weekSelected+'>Week</option>';
                        htmlDetail += '<option value="3" '+monthSelected+'>Month</option>';
                    htmlDetail += '</select>';
                htmlDetail += '</div>';
            htmlDetail += '</div>';
        htmlDetail += '</td>';
        htmlDetail += '<td style="text-align: center;"><button type="button" class="btn btn-danger btn-delete-row"><i class="fa fa-close" aria-hidden="true"></i></a></td>';
        htmlDetail += '</tr>';

    $('#table-det-order tbody').append(htmlDetail);
    actionDetailRow($('#table-det-order tbody'));
}

tableDetOrder('', '', 1, 1, '', 1);

$(document).on('click', '.btn-add-row', function(){
    var row = $('#table-det-order tbody tr').length;
        row++;
    tableDetOrder('', '', 1, 1, '', row);
})

function actionDetailRow(content){
    content.find('.btn-delete-row').click(function(){
        var row = $(this).parent().parent();
        if(row.attr('no') > 1){
            row.remove();
        }
        $('#table-det-order > tbody > tr').each(function(index, tr) {
            var no = 1 + index;
            $(this).attr('no', no);
        });
    });
}

$('#myFormUser').on('submit', function(e){
    $.ajax({
        url: "{{ url('/user/store') }}",
        type: "POST",
        data: $('#myFormUser').serialize()
    })
    .done(function(data) {
        user_Selectdata(data);
        $('#ModalUserForm').modal('hide');
        $('#ModalUserForm input').val('');
    });
    e.preventDefault();
});

</script>
@endsection

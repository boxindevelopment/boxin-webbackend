<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/icon.png') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <!-- This page CSS -->
    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}" rel="stylesheet" type="text/css">

    @yield('plugin_css')

    <!-- chartist CSS -->
    <link href="{{asset('assets/plugins/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <!--c3 CSS -->
    <link href="{{asset('assets/plugins/c3-master/c3.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('assets/css/pages/dashboard1.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('assets/css/colors/default-dark.css')}}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    @php
        $hash = Auth::user()->email . Auth::user()->phone . Auth::user()->roles_id . date('H');
        $code = password_hash($hash, PASSWORD_DEFAULT);
    @endphp
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "622c31f4-a1ac-4677-ac9d-0c07148d93d0",
            });
            OneSignal.on('permissionPromptDisplay', function () {
                console.log("The prompt displayed");
            });
            
            OneSignal.push(function() {
                /* These examples are all valid */
                OneSignal.getUserId(function(userId) {
                    console.log("OneSignal User ID:", userId);
                    
                    var xhttp = new XMLHttpRequest();
                    var params = 'device=web&code={{$code}}&token=' + userId;
                    var url = 'usertoken/store?' + params;
                    xhttp.open('GET', url, true);
                    console.log(params);
                    //Send the proper header information along with the request
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.onreadystatechange = function() {//Call a function when the state changes.
                        if(xhttp.readyState == 4 && xhttp.status == 200) {
                            console.log("responseText", xhttp.responseText);
                        }
                    }
                    xhttp.send(params);
                    
                });
            });
        });
    </script>

    @yield('script_css')

</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Box-in</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Horizontal navbar and right sidebar toggle -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> © 2018 twiscode.com </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('assets/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
    <!--Table -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <!--Select -->
    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- Datepicker -->
    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- FileUpload -->
    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <!-- for Date / time use moment.js -->
    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
    <!-- for selected data -->
    <script src="{{asset('assets/js/select-data.js')}}"></script>

    <script type="text/javascript">

         
        setTimeout(getNotif, 4000);

        function getNotif(){
            $.get("{{route('dashboard')}}/notification/ajax/notif", function(data, status){
                // const dataGet = JSON.parse(data);
                $('.notif-count').html(data.count);
                if(data.count > 0){
                    $('.waves-effect .notify').show();
                } else {
                    $('.waves-effect .notify').hide();
                }
                $('.message-center-notification').html('');
                let messageHtml = '';
                let urlNotif = "{{route('notification.index')}}";
                $.each(data.data, function(index, element) {
                    let backgroundColor = '#fff';
                    if(element.read_at == null){
                        backgroundColor = '#e4e5e8';
                    }
                    messageHtml += '<a href="'+urlNotif+'/id/'+element.id+'" style="background-color: '+backgroundColor+';">';
                        // messageHtml += '<div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>';
                        messageHtml += '<div class="mail-contnet">';
                            messageHtml += '<h5>'+element.type+'</h5>';
                            messageHtml += '<span class="mail-desc">'+element.title+'</span>';
                            messageHtml += '<span class="time">'+element.datetime_notif+'</span>';
                        messageHtml += '</div>';
                    messageHtml += '</a>';
                });
                $('.message-center-notification').html(messageHtml);
                // console.log("Data: " + data + "\nStatus: " + status);
            });
        }

        function city_Selectdata(values) {
            var data = $.ajax({
                url: "{{ url('/city/dataSelect') }}",
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
                var area_id = $("area_id").val();
                $("#city_id").select2({
                    multiple: false,
                    placeholder: 'Choose City',
                    tags: true,
                    data : arrs,
                }).on('change', function (e) {
                    var city_ext = $(this).val().split('##');
                    var city_id = city_ext[0];
                    get_id_number_area(city_ext[0], city_ext[1]);
                    area_Selectdata(city_id, $(this).val());

                });
            });

            if(values != ''){
                split_city = values.split('##');
                @if(isset($space->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $space->area_id }}##{{ $space->area_id_name }}');
                @elseif(isset($shelves->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $shelves->area_id }}##{{ $shelves->area_id_name }}');
                @elseif(isset($box->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $box->area_id }}##{{ $box->area_id_name }}');
                @elseif(isset($space->shelves->area->id))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $space->shelves->area->id }}##{{ $space->shelves->area->id_name }}');
                @elseif(isset($user->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $user->area_id }}##{{ $user->area_id_name }}');
                @elseif(isset($delfee->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $delfee->area_id }}##{{ $delfee->area_id_name }}');
                @elseif(isset($price->area_id_name))
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '{{ $price->area_id }}##{{ $price->area_id_name }}');
                @else
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(split_city[0], '');
                @endif
            }
        }
        @if(isset($edit_space))
            @if(isset($space->shelves->area->city->id))
                city_Selectdata('{{$space->shelves->area->city->id}}##{{$space->shelves->area->city->id_name}}');
            @endif
        @elseif(isset($edit_shelves))
            @if(isset($shelves))
                city_Selectdata('{{$shelves->city_id}}##{{$shelves->city_id_name}}');
            @endif
        @elseif(isset($edit_box))
            @if(isset($box))
                city_Selectdata('{{$box->city_id}}##{{$box->city_id_name}}');
            @endif
        @elseif(isset($edit_user))
            @if(isset($user))
                city_Selectdata('{{$user->city_id}}##{{$user->city_id_name}}');
            @endif
        @elseif(isset($edit_delfee))
            @if(isset($delfee))
                city_Selectdata('{{$delfee->city_id}}##{{$delfee->city_id_name}}');
            @endif
        @elseif(isset($edit_price))
            @if(isset($price))
                city_Selectdata('{{$price->city_id}}##{{$price->city_id_name}}');
            @endif
        @else
            city_Selectdata('');
        @endif

        function get_id_number_area(city_id, city_number){

            var data = $.ajax({
                url: "{{ url('/area/getNumber') }}",
                type: "GET",
                data: { city_id : city_id }
            })
            .done(function(data) {
                $('input[name="id_name_area"]').val(city_number + data);
            });
        }

        function area_Selectdata(city_id, values) {
            var data = $.ajax({
                url: "{{ url('/area/dataSelect/') }}/"+city_id,
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
                var area_id = $("#area_id").val();
                $("#area_id").select2({
                    multiple: false,
                    placeholder: 'Choose Area',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var area_ext = $(this).val().split('##');
                    var area_id = area_ext[0];
                    // get_id_number_space(area_ext[0], area_ext[1]);
                    // space_Selectdata(area_id, $(this).val());
                    get_id_number_shelves(area_ext[0], area_ext[1]);
                    shelves_Selectdata(area_id, $(this).val());
                })

            });
            if(values != ''){
                split_area = values.split('##');
                @if(isset($shelves->space_id_name))
                    $("#area_id").val(values).trigger("change");
                    space_Selectdata(split_area[0], '{{ $shelves->space_id }}##{{ $shelves->space_id_name }}');
                @elseif(isset($box->code_shelves))
                    $("#area_id").val(values).trigger("change");
                    // space_Selectdata(split_area[0], '{{ $box->space_id }}##{{ $box->space_id_name }}');
                    shelves_Selectdata(split_area[0], '{{ $box->shelves_id }}##{{ $box->shelves->code_shelves }}');
                    get_id_number_box('{{ $box->shelves_id }}', '{{ $box->shelves->code_shelves }}');
                @elseif(isset($space->shelves->code_shelves))
                    $("#area_id").val(values).trigger("change");
                    shelves_Selectdata(split_area[0], '{{ $space->shelves_id }}##{{ $space->shelves->code_shelves }}');
                @else
                    // $("#area_id").val(values).trigger("change");
                    // space_Selectdata(split_area[0], '');
                @endif
            }
        }

        function get_id_number_space(shelve_id, shelve_code){
            if(shelve_id){

                var data = $.ajax({
                    url: "{{ url('/space/getNumber') }}",
                    type: "GET",
                    data: { shelve_id : shelve_id, shelve_code: shelve_code }
                })
                .done(function(data) {
                    if(data == 0){
                        $('#code_space_small').val(shelve_code + 'S1');
                        $('.message-error_code').hide();
                        $('.message-error_code .alert').html('');
                    } else {
                        $('#code_space_small').val('');
                        $('.message-error_code .alert').html('code space is used');
                        $('.message-error_code').show();
                    }
                });
            }
        }

        function space_Selectdata(area_id, values) {
            var split_area = values.split('##');
            var $id = area_id;
            var data = $.ajax({
                url: "{{ url('/space/dataSelect/') }}/"+area_id,
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
                var space_id = $("#space_id").val();
                $("#space_id").select2({
                    multiple: false,
                    placeholder: 'Choose Space',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    // var space_ext = $(this).val().split('##');
                    // var space_id = space_ext[0];
                    // get_id_number_shelves(space_ext[0], space_ext[1]);
                    // shelves_Selectdata(space_id, $(this).val());
                });

            });
            if(values != ''){
                $("#space_id").val(values).trigger("change");
                split_space = values.split('##');
                @if(isset($box->space_id_name))
                    shelves_Selectdata(split_space[0], '{{ $box->space_id }}##{{ $box->space_id_name }}');
                @elseif(isset($room->space_id_name))
                    shelves_Selectdata(split_space[0], '{{ $room->space_id }}##{{ $room->space_id_name }}');
                @else
                    // shelves_Selectdata(split_space[0], '');
                @endif
            }

        } 


        function get_id_number_shelves(area_id, area_number){
            console.log('shelves in');
            console.log('area:' + area_number);
            var data = $.ajax({
                url: "{{ url('/shelves/getNumber') }}",
                type: "GET",
                data: { area_id : area_id }
            })
            .done(function(data) {
                $('input[name="code_shelves"]').val(area_number + data);
            });
        }

        function shelves_Selectdata(area_id, values) {
            var data = $.ajax({
                url: "{{ url('/shelves/dataSelect/') }}/"+area_id,
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
                var shelves_id = $("#shelves_id").val();
                $("#shelves_id").select2({
                    multiple: false,
                    placeholder: 'Choose Shelves',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var shelves_ext = $(this).val().split('##');
                    var space_id = shelves_ext[0];
                    get_id_number_box(shelves_ext[0], shelves_ext[1]);
                    get_id_number_space(shelves_ext[0], shelves_ext[1]);
                });
            });
            if(values != ''){
                $("#shelves_id").val(values);
            }
        }

        $('#shelves_box, #row_box, #column_box, #height_box').on('change', function(){
            var shelves_id = $('#shelves_id').val().split('##');
            get_id_number_box(shelves_id[0], shelves_id[1]);
        });

        function get_id_number_box(shelves_id, code_shelves){
            if($('#code_box_hide').length){
                var code = $('#code_box_hide').val();
            } else {
                var code = '';
            }
            if(shelves_id && $('#code_box').length > 0) {
                var data = $.ajax({
                    url: "{{ url('/box/getCodeUsed') }}",
                    type: "GET",
                    data: { shelves_id : shelves_id, code_shelves: code_shelves, code: code }
                })
                .done(function(data) {
                    var obj = jQuery.parseJSON(data);
                    var $code_boxes = $('#code_box');
                    $code_boxes.html('');
                    $code_boxes.append('<option  value=""></option>');
                    for (var i = 0; i < obj.length; i++) {
                        if(obj[i] == code) {
                            $code_boxes.append("<option  value='" + obj[i] + "' selected>" + obj[i] + "</option>");
                        } else {
                            $code_boxes.append("<option  value='" + obj[i] + "'>" + obj[i] + "</option>");
                        }
                    }
                });
            }

        }

        function userForAdmin_Selectdata(values) {
            if($("#admin_id")[0]){
                var data = $.ajax({
                    url: "{{ url('/user/getDataSelectForAdmin') }}",
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
                    $("#admin_id").select2({
                        multiple: false,
                        placeholder: 'Choose User',
                        tags: true,
                        data : arrs
                    }).on('change', function (e) {
                        var user_id = $(this).val();
                    });
                    if(values != ''){
                        $("#admin_id").val(values).trigger('change');
                    }
                });

                if(values != ''){
                    $("#admin_id").val(values).trigger('change');
                }
            }
        }
        userForAdmin_Selectdata('');

        function userForSuperadmin_Selectdata(values) {
            if($("#superadmin_id")[0]){
                var data = $.ajax({
                    url: "{{ url('/user/getDataSelectForSuperadmin') }}",
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
                    $("#superadmin_id").select2({
                        multiple: false,
                        placeholder: 'Choose User',
                        tags: true,
                        data : arrs
                    }).on('change', function (e) {
                        var user = $(this).val();
                    });
                    if(values != ''){
                        $("#superadmin_id").val(values).trigger('change');
                    }
                });

                if(values != ''){
                    $("#superadmin_id").val(values).trigger('change');
                }
            }
        }
        userForSuperadmin_Selectdata('');

        function userForFinance_Selectdata(values) {
            if($("#finance_id")[0]){
                var data = $.ajax({
                    url: "{{ url('/user/getDataSelectForFinance') }}",
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
                    $("#finance_id").select2({
                        multiple: false,
                        placeholder: 'Choose User',
                        tags: true,
                        data : arrs
                    }).on('change', function (e) {
                        var user = $(this).val();
                    });
                    if(values != ''){
                        $("#finance_id").val(values).trigger('change');
                    }
                });

                if(values != ''){
                    $("#finance_id").val(values).trigger('change');
                }
            }
        }
        userForFinance_Selectdata('');

    </script>

    @yield('close_html')
</body>
</html>

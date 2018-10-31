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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
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
    @yield('script_css')

</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Boxin</p>
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
                var area_id = $("area_id").val();
                $("#city_id").select2({
                    multiple: false,
                    placeholder: 'Choose City',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var city_ext = $(this).val().split('##');
                    var city_id = city_ext[0];
                    get_id_number_area(city_ext[0], city_ext[1]);
                    area_Selectdata(city_id, area_id);

                });
                if(values != ''){
                    $("#city_id").val(values).trigger('change');
                    area_Selectdata(values, area_id);
                }
            });

            if(values != ''){
                $("#city_id").val(values).trigger('change');
                area_Selectdata(values, area_id);
            }
        }
        city_Selectdata('');

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

        @if(isset($warehouse->area_id))
          area_Selectdata({{$warehouse->area_id}}, '');
        @endif

        @if(isset($box->area_id))
          area_Selectdata({{$box->area_id}}, '');
        @endif

        @if(isset($space->area_id))
          area_Selectdata({{$space->area_id}}, '');
        @endif

        @if(isset($room->area_id))
          area_Selectdata({{$room->area_id}}, '');
        @endif

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
                    console.log(area_ext);
                    var area_id = area_ext[0];
                    console.log(area_ext[0]);
                    get_id_number_warehouse(area_ext[0], area_ext[1]);
                    warehouse_Selectdata(area_id);
                })


                if(values != ''){
                    $("#area_id").val(values).trigger("change");
                    warehouse_Selectdata(area_id);
                }
            });
            if(values != ''){
                $("#area_id").val(values).trigger("change");
                warehouse_Selectdata(area_id);
            }
        }

        function get_id_number_warehouse(area_id, area_number){

            var data = $.ajax({
                url: "{{ url('/warehouse/getNumber') }}",
                type: "GET",
                data: { area_id : area_id }
            })
            .done(function(data) {
                $('input[name="id_name_warehouse"]').val(area_number + data);
            });
        }

        @if(isset($box->area_id))
          warehouse_Selectdata({{$box->area_id}});
        @endif

        @if(isset($space->area_id))
          warehouse_Selectdata({{$space->area_id}});
        @endif

        @if(isset($room->area_id))
          warehouse_Selectdata({{$room->area_id}});
        @endif

        function warehouse_Selectdata(area_id) {
            var $id = area_id;
            var data = $.ajax({
                url: "{{ url('/warehouse/dataSelect/') }}/"+area_id,
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
                var warehouse_id = $("#warehouse_id").val();
                $("#warehouse_id").select2({
                    multiple: false,
                    placeholder: 'Choose Warehouse',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var warehouse_ext = $(this).val().split('##');
                    var warehouse_id = warehouse_ext[0];
                    get_id_number_space(warehouse_ext[0], warehouse_ext[1]);
                    space_Selectdata(warehouse_id);
                });


                if(warehouse_id != ""){
                    $("#warehouse_id").val(warehouse_id).trigger("change");
                    space_Selectdata(warehouse_id);
                }else{
                    $("#warehouse_id").val('').trigger("change");
                }
            });
        }

        function get_id_number_space(warehouse_id, warehouse_number){

            var data = $.ajax({
                url: "{{ url('/space/getNumber') }}",
                type: "GET",
                data: { warehouse_id : warehouse_id }
            })
            .done(function(data) {
                $('input[name="id_name_space"]').val(warehouse_number + data);
            });
        }

        @if(isset($box->warehouse_id))
          space_Selectdata({{$box->warehouse_id}});
        @endif

        @if(isset($room->warehouse_id))
          space_Selectdata({{$room->warehouse_id}});
        @endif

        function space_Selectdata(warehouse_id) {
            var data = $.ajax({
                url: "{{ url('/space/dataSelect/') }}/"+warehouse_id,
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
                    var space_ext = $(this).val().split('##');
                    var space_id = space_ext[0];
                    get_id_number_box(space_ext[0], space_ext[1]);
                    get_id_number_room(space_ext[0], space_ext[1]);
                });

                // if(space_id != ""){
                //     $("#space_id").val(space_id).trigger("change");
                // }else{
                //     $("#space_id").val('').trigger("change");
                // }
            });
        }

        function get_id_number_box(space_id, space_number){

            var data = $.ajax({
                url: "{{ url('/box/getNumber') }}",
                type: "GET",
                data: { space_id : space_id }
            })
            .done(function(data) {
                $('input[name="id_name_box"]').val(space_number +'1'+ data);
            });
        }

        function get_id_number_room(space_id, space_number){

            var data = $.ajax({
                url: "{{ url('/room/getNumber') }}",
                type: "GET",
                data: { space_id : space_id }
            })
            .done(function(data) {
                $('input[name="id_name_room"]').val(space_number +'2'+ data);
            });
        }

        function usernotAdmin_Selectdata(values) {
            var data = $.ajax({
                url: "{{ url('/user/getDataSelectNotAdmin') }}",
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
                $("#user_id").select2({
                    multiple: false,
                    placeholder: 'Choose User',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var user_id = $(this).val();
                });
                if(values != ''){
                    $("#user_id").val(values).trigger('change');
                }
            });

            if(values != ''){
                $("#user_id").val(values).trigger('change');
            }
        }
        usernotAdmin_Selectdata('');

        function usernotSuperadmin_Selectdata(values) {
            var data = $.ajax({
                url: "{{ url('/user/getDataSelectNotSuperadmin') }}",
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
                $("#user").select2({
                    multiple: false,
                    placeholder: 'Choose User',
                    tags: true,
                    data : arrs
                }).on('change', function (e) {
                    var user = $(this).val();
                });
                if(values != ''){
                    $("#user").val(values).trigger('change');
                }
            });

            if(values != ''){
                $("#user").val(values).trigger('change');
            }
        }
        usernotSuperadmin_Selectdata('');
    </script>

    @yield('close_html')
</body>
</html>

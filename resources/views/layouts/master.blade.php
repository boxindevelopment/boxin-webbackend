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
                    var city_id = $(this).val();
                    area_Selectdata(city_id);

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
                    var area_id = $(this).val();
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
                    var warehouse_id = $(this).val();
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

        @if(isset($box->warehouse_id))
          space_Selectdata({{$box->warehouse_id}});
        @endif

        @if(isset($space->warehouse_id))
          space_Selectdata({{$space->warehouse_id}});
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
                    var space_id = $(this).val();
                });


                if(space_id != ""){
                    $("#space_id").val(space_id).trigger("change");
                }else{
                    $("#space_id").val('').trigger("change");
                }
            });
        }
    </script>

    @yield('close_html')
</body>
</html>

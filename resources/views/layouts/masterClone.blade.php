@php
    use Illuminate\Support\Facades\DB;
    use App\Utilities\AwinHelper;
@endphp
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Dashboard - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/uniform/css/uniform.default.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
    <link href="{{ asset('assets/bootstrap/css/bootstrap-helpers.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/dt-1.11.4/b-2.2.2/datatables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    {{-- CKEditor CDNs for Wizard Include Services By RANA --}}
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    @yield('style')
    <style>
        .bg-blue {
            background-color: #4a8bc2;


        }

        .bg-blue:active {
            color: #4a8bc2;


        }

        .text-blue {
            background-color: #4a8bc2;


        }
    </style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="fixed-top">
    <!-- BEGIN HEADER -->
    @include('layouts.topnav')
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div id="container" class="row-fluid">
        <!-- BEGIN SIDEBAR -->
        @include('layouts.sidenav')
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div id="main-content">
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN THEME CUSTOMIZER-->
                        {{-- <div id="theme-change" class="hidden-phone">
                       <i class="icon-cogs"></i>
                        <span class="settings">
                            <span class="text">Theme Color:</span>
                            <span class="colors">
                                <span class="color-default" data-style="default"></span>
                                <span class="color-green" data-style="green"></span>
                                <span class="color-gray" data-style="gray"></span>
                                <span class="color-purple" data-style="purple"></span>
                                <span class="color-red" data-style="red"></span>
                            </span>
                        </span>
                   </div> --}}
                        <!-- END THEME CUSTOMIZER-->

                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                @yield('content')

                <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
    <div id="footer">
        <?php echo date('Y'); ?> &copy; Searlco.
    </div>
    <!-- END FOOTER -->

    <!-- BEGIN JAVASCRIPTS -->

    <!-- Load javascripts at bottom, this will reduce page load time -->
    {{-- <script src="https://use.fontawesome.com/4b1ba7eb60.js"></script> --}}
    <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>

    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->

    <script type="text/javascript" src="{{ asset('assets/uniform/jquery.uniform.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"
        integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.4/b-2.2.2/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>


    <!--common script for all pages-->
    <script src="{{ asset('js/common-scripts.js') }}"></script>
    <script src="{{ asset('js/dynamic-table.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="{{ asset('./js/chartjs_script.js') }}"></script>



    <!-- END JAVASCRIPTS -->
    <!--common script for Specific pages-->
    @yield('scripts')

    <!-- END JAVASCRIPTS -->
    @yield('script')




</body>
<script>
    $(document).ready(function() {




        $('input[type=number]').attr('min', '1');

    });
</script>
<!-- END BODY -->

</html>

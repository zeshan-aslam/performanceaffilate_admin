<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Dashboard - @yield('title')</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-responsive.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-fileupload.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-default.css')}}" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   @include('layouts.auth.topnav')
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class='space15'></div>
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div class="span3">

      </div>
      <div class="span6">
        @yield('content')
      </div>
       <!-- END PAGE -->
   </div>

   <div id="footer">
       <?php echo date('Y');?> &copy; Searlco.
   </div>
   <!-- END FOOTER -->

   <!-- BEGIN JAVASCRIPTS -->

   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="{{asset('js/jquery-1.8.3.min.js')}}"></script>
   <script src="{{asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
   <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>

   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->

   <script type="text/javascript" src="{{asset('assets/uniform/jquery.uniform.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('assets/data-tables/jquery.dataTables.js')}}"></script>
   <script type="text/javascript" src="{{asset('assets/data-tables/DT_bootstrap.js')}}"></script>


   <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js" integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>



   <!--common script for all pages-->
   <script src="{{asset('js/common-scripts.js')}}"></script>
   <script src="{{asset('js/editable-table.js')}}"></script>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
   <script src="{{asset('./js/chartjs_script.js')}}"></script>



   <!-- END JAVASCRIPTS -->

   <!-- END JAVASCRIPTS -->
   @yield('script')




</body>
<!-- END BODY -->
</html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Dashboard - @yield('title')</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta content="" name="description" />
   
   <meta content="" name="author" />
   <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-responsive.min.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/bootstrap/css/bootstrap-fileupload.css')}}" rel="stylesheet" />
   <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" />
   <link href="{{asset('css/style-default.css')}}" rel="stylesheet" id="style_color" />

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
                   
                   <!-- END THEME CUSTOMIZER-->
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title">
                     Blank
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Sample Pages</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           Blank
                       </li>
                       <li class="pull-right search-wrap">
                           <form action="search_result.html" class="hidden-phone">
                               <div class="input-append search-input-area">
                                   <input class="" id="appendedInputButton" type="text">
                                   <button class="btn" type="button"><i class="icon-search"></i> </button>
                               </div>
                           </form>
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
             <div class="container">
              
               @yield('content')
                 
             </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <!-- BEGIN FOOTER -->
   <div id="footer">
       2022 &copy; Searlco.net
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
   <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>

   

   <!--common script for all pages-->
   <script src="{{asset('js/common-scripts.js')}}"></script>
   <!--script for this page only-->
   <script src="{{asset('js/editable-table.js')}}"></script>

   <!-- END JAVASCRIPTS -->
   
   <!-- END JAVASCRIPTS -->
   <script>
      @yield('scripts')
      </script>
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
</body>
<!-- END BODY -->
</html>
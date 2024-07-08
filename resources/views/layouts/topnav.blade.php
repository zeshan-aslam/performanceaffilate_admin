<div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               <!-- BEGIN LOGO -->
               <a class="brand" href="{{ url('/') }}">
                   <!-- <img src="img/logo.png" alt="Metro Lab" /> -->
                   <img src="{{asset('img/logo.png') }}" alt="" height="80px" width="170px" style="margin-top:-11%">
                   {{-- <p style="color:white; font-weight:bold; font-size:18px; font-family:Cambria;">Searlco Admin</p> --}}
               </a>
               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
               <!-- <div id="top_menu" class="nav notify-row">

                   <ul class="nav top-menu">





                   </ul>
               </div> -->
               <!-- END  NOTIFICATION -->
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >

                       <!-- BEGIN USER LOGIN DROPDOWN -->





                       @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               {{-- <img src="img/avatar1_small.jpg" alt=""> --}}
                               <span class="username">{{ Auth::user()->username }}</span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu extended logout">
                               <!-- <li><a href="#"><i class="icon-user"></i> My Profile</a></li> -->
                               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                                <li><a  href="{{ route('password.changePasswordForm') }}">
                                     {{ __('Change Password') }}
                                 </a></li>
                                 <li>
                                    <a class="icon-key" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                        </li>
                           </ul>
                       </li>
                       @endguest
                       <!-- END USER LOGIN DROPDOWN -->
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
   </div>

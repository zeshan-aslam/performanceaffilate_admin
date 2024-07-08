<div id="header" class="navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">

            <!-- BEGIN LOGO -->
            <a class="center brand" href="{{ url('/') }}">
                <!-- <img src="img/logo.png" alt="Metro Lab" /> -->
                <p style="color:white; font-weight:bold; font-size:18px; font-family:Cambria;">Searlco Admin</p>
            </a>
            <!-- END LOGO -->

            <div class="top-nav ">
                <ul class="nav pull-right top-menu" >

                    <!-- BEGIN USER LOGIN DROPDOWN -->





                    @guest
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                         </li>

                     @else
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="img/avatar1_small.jpg" alt="">
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

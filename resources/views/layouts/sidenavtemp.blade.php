<div class="sidebar-scroll">
          <div id="sidebar" class="nav-collapse collapse">

              <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
              <div class="navbar-inverse">
                  <form class="navbar-search visible-phone">
                      <input type="text" class="search-query" placeholder="Search" />
                  </form>
              </div>
              <!-- END RESPONSIVE QUICK SEARCH FORM -->
              <!-- BEGIN SIDEBAR MENU -->
              <ul class="sidebar-menu">
                  <li class="sub-menu">
                      <a class="" href="{{route('admin.home')}}">
                          <i class="icon-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{route('Merchant.index')}}">
                      <i class="icon-briefcase"></i>
                          <span>Merchants</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('Affiliate.index') }}">
                      <i class="icon-th-large"></i>
                          <span>Affiliates</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('Program.index') }}">
                          <i class=" icon-tasks"></i>
                          <span>Programs</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('payment.paymentHistoryForm') }}">
                          <i class="icon-book"></i>
                          <span>Payments</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('Report.index') }}">
                          <i class=" icon-signal"></i>
                          <span>Reports</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('Options.index') }}">
                          <i class="icon-wrench"></i>
                          <span>Options</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="{{ route('PGMStatus.index') }}">
                          <i class="icon-list"></i>
                          <span>PGM Status</span>
                      </a>
                  </li>
                  <li class="sub-menu open">
                    <a href="#">
                        <i class="icon-fire"></i>
                        <span>Searlco Home</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="{{route('searlco.slides')}}">Slider</a></li>
                        <li><a class="" href="{{route('searlco.services')}}">Services</a></li>
                        <li><a class="" href="{{route('searlco.searlcoNetwork')}}">Searlo Network</a></li>
                        <li><a class="" href="{{route('searlco.features')}}">Features</a></li>
                        <li><a class="" href="{{route('searlco.benifits')}}">Benifits</a></li>
                        <li><a class="" href="{{route('searlco.trustedBrands')}}">Trusted Brands</a></li>


                    </ul>
                   </li>
                  <li>
                      <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form-side').submit();">
                          <i class="icon-user"></i>

                          <span>Logout</span>
                          <form id="logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                      </a>
                  </li>
              </ul>
              <!-- END SIDEBAR MENU -->
          </div>
      </div>

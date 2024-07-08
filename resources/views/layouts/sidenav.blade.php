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
            @foreach (SiteHelper::sideMenu() as $key => $row)
            @if (url()->full()==route($row['href']))
             <?php $class='active';?>
            @else
            <?php $class='';?>
            @endif
                @if (array_key_exists('submenu', $row))
                    <li class="sub-menu <?php echo $class?>">
                        <a href="javascript:;">
                            <i class="{{ $row['icon'] }}"></i>
                            <span>{{ $row['name'] }}</span>
                            <span class="arrow"></span>
                        </a>
                        @foreach ($row as $subKey => $subRow)
                            @if ($subKey == 'submenu')
                                <?php $subArray = array_values($subRow); ?>
                                <ul class="sub">
                                    @foreach ($subArray as $subKeyK => $subRowR)
                                    @if (url()->full()==route($subRowR['href']))
                                    <?php $subclass='active';?>
                                   @else
                                   <?php $subclass='';?>
                                   @endif
                                    <li class='sub-menu-item <?=$subclass?>'>
                                      <a class="" href="{{ route($subRowR['href']) }}">{{ $subRowR['name'] }}</a>
                                    </li>
                                    @endforeach
                                </ul>

                            @endif
                            @endforeach
                     </li>
         @else
         <li class="sub-menu <?=$class?>">
            <a class="" href="{{route($row['href'])}}">
                <i class="{{$row['icon']}}"></i>
                <span>{{$row['name']}}</span>
            </a>
        </li>
         @endif
        @endforeach
        <li class='sub-menu'>
            <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
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

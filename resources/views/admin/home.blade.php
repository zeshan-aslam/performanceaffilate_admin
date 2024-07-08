
@extends('layouts.masterClone')

@section('title', 'Merchant')

@section('content')


                    <div class="row-fluid">
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-light-green">
                        <a data-original-title="" href="{{route('admin.users')}}">
                            <i class="icon-user"></i>
                            <div class="info">
                                 @php
                                echo DB::table('users')->count();
                                 @endphp
                             </div>
                            <div class="status"> Users</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="{{route('Merchant.index')}}">
                            <i class="icon-briefcase"></i>
                            <div class="info"> @php
                                echo DB::table('partners_merchant')->count();
                                 @endphp</div>
                            <div class="status">Merchants</div>
                        </a>
                    </div>

                    <div class="metro-nav-block nav-olive">
                        <a data-original-title="" href="{{route('Affiliate.index')}}">
                            <i class="icon-th-large"></i>
                            <div class="info"> @php
                                echo DB::table('partners_affiliate')->count();
                                 @endphp</div>
                            <div class="status">Affiliates</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="{{ route('Program.index') }}">
                            <i class="icon-tasks"></i>
                            <div class="info"> @php
                                echo DB::table('partners_program')->count();
                                 @endphp</div>
                            <div class="status">Programs</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-green ">
                        <a data-original-title="" href="{{route('payment.paymentHistoryForm') }}">
                            <i class="icon-book"></i>
                            <div class="info"></div>
                            <div class="status">Payments</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="{{ route('Report.index') }}">
                            <i class="icon-signal"></i>
                            <div class="info"></div>
                            <div class="status">Reports</div>
                        </a>
                    </div>

                <div class="metro-nav">
                    <div class="metro-nav-block nav-light-purple">
                        <a data-original-title="" href="{{ route('Options.index') }}">
                            <i class="icon-wrench"></i>
                            <div class="info"> </div>
                            <div class="status">Options</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-blue ">
                        <a data-original-title="" href="{{ route('PGMStatus.index') }}">
                            <i class="icon-foursquare"></i>
                            <div class="info"></div>
                            <div class="status">PGM Status</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="{{ route('Merchant.keywordCounter') }}">
                            <i class="icon-key"></i>
                            <div class="info">{{ count($unique_brands) }}</div>
                            <div class="status">Acitve Brands/Keywords</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-olive">
                        <a data-original-title="" href="{{ route('admin.totalkeywords') }}">
                            <i class="icon-key"></i>
                            <div class="info">{{ count($unique_brands) }}</div>
                            <div class="status">Brands List</div>
                        </a>
                    </div>
                    {{-- <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="#">
                            <i class="icon-key"></i>
                            <div class="info"></div>
                            <div class="status">Acitve Brands/Keywords</div>
                        </a>
                    </div> --}}

                    <div class="metro-nav-block bg-dark">
                        <a  data-original-title="" class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                             </form>
                             <i class="icon-remove-sign"></i>
                             <div class="info"></div>
                             <div class="status">Logout</div>
                        </a>

                    </div>

                </div>
                <div class="space10"></div>
                <!--END METRO STATES-->
            </div>

<!-- Chart -->



@endsection

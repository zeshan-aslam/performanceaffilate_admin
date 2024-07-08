
@extends('layouts.masterClone')

@section('title', 'Merchant')

@section('content')


                    <div class="row-fluid">
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="{{route('Merchant.index')}}">
                            <i class="icon-user"></i>
                            <div class="info">321</div>
                            <div class="status">Merchant</div>
                        </a>
                    </div>
                   
                    <div class="metro-nav-block nav-olive">
                        <a data-original-title="" href="{{route('Affiliate.index')}}">
                            <i class="icon-tags"></i>
                            <div class="info">+970</div>
                            <div class="status">Affiliate</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="{{ route('Program.index') }}">
                            <i class="icon-comments-alt"></i>
                            <div class="info">49</div>
                            <div class="status">Program</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-green double">
                        <a data-original-title="" href="{{route('payment.paymentHistoryForm') }}">
                            <i class="icon-eye-open"></i>
                            <div class="info">+897</div>
                            <div class="status">Payments</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="{{ route('Report.index') }}">
                            <i class="icon-bar-chart"></i>
                            <div class="info">+288</div>
                            <div class="status">Report</div>
                        </a>
                    </div>
                </div>
                <div class="metro-nav">
                    <div class="metro-nav-block nav-light-purple">
                        <a data-original-title="" href="{{ route('Options.index') }}">
                            <i class="icon-shopping-cart"></i>
                            <div class="info">29</div>
                            <div class="status">Option</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-light-blue double">
                        <a data-original-title="" href="{{ route('PGMStatus.index') }}">
                            <i class="icon-tasks"></i>
                            <div class="info">$37624</div>
                            <div class="status">PGM Status</div>
                        </a>
                    </div>
                    <!-- <div class="metro-nav-block nav-light-green">
                        <a data-original-title="" href="#">
                            <i class="icon-envelope"></i>
                            <div class="info">123</div>
                            <div class="status">Messages</div>
                        </a>
                    </div> -->
                    <div class="metro-nav-block nav-light-brown">
                        <a data-original-title="" href="{{ route('logout') }}">
                            <i class="icon-remove-sign"></i>
                            <div class="info">34</div>
                            <div class="status">Logout</div>
                        </a>
                    </div>
                    <!-- <div class="metro-nav-block nav-block-grey ">
                        <a data-original-title="" href="#">
                            <i class="icon-external-link"></i>
                            <div class="info">$53412</div>
                            <div class="status">Total Profit</div>
                        </a>
                    </div> -->
                </div>
                <div class="space10"></div>
                <!--END METRO STATES-->
            </div>
 
<!-- Chart -->


                 
@endsection

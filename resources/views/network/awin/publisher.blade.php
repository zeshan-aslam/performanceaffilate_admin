
@extends('layouts.masterClone')

@section('title', 'Publisher')

@section('content')

<h1 class="page-title">Dashboard of <span class="text-primary">{{ AwinHelper::getPublisher($id) }}</span></h1>
                    <div class="row-fluid">
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">
                    <div class="metro-nav-block nav-block-green">
                        <a data-original-title="" href="{{route('awin.program',$id)}}">
                            <i class="icon-list-alt"></i>
                            <div class="info">
                        
                             </div>
                            <div class="status"> Programs</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-red">
                        <a data-original-title="" href="{{route('awin.commissiongroup',$id)}}">
                            <i class="icon-user"></i>
                            <div class="info">
                        
                             </div>
                            <div class="status"> Commission Groups</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-yellow">
                        <a data-original-title="" href="{{route('awin.transaction',$id)}}">
                            <i class="icon-usd"></i>
                            <div class="info">
                        
                             </div>
                            <div class="status"> Transactions</div>
                        </a>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="{{route('awin.report',$id)}}">
                            <i class="icon-calendar"></i>
                            <div class="info">
                        
                             </div>
                            <div class="status"> Reports</div>
                        </a>
                    </div>

                    <div class="metro-nav-block bg-info">
                        <a data-original-title="" href="{{route('awin.notifications',$id)}}">
                            <i class="icon-bell"></i>
                            <div class="info">
                        
                             </div>
                            <div class="status"> Notifications</div>
                        </a>
                    </div>
                    
            </div>

<!-- Chart -->



@endsection

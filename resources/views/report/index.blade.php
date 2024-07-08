@extends('layouts.masterClone')

@section('title', 'Merchant')
@section('links')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />

@endsection

@section('content')

    <div class="row-fluid">

      
            <div class="card p-4">

                <div class="bs-docs-example ">
                    <ul class="nav nav-tabs" id="myTab">
                        <li><a href="#Daily" data-toggle="tab">Daily</a></li>
                        <li><a href="#For_Period" data-toggle="tab">For Period</a></li>
                        <li> <a href="#Transaction" data-toggle="tab">Transaction</a></li>
                        <li><a href="#Link" data-toggle="tab">Link</a></li>
                        <li><a href="#Referer" data-toggle="tab">Referrer</a></li>
                        <li><a href="#Products" data-toggle="tab">Products</a></li>
                        <li><a href="#RecurringComission" data-toggle="tab">Recurring Commission</a></li>
                        <li><a href="#Graphs" data-toggle="tab">Graphs</a></li>
                        <li><a href="#AffiliateReferrals" data-toggle="tab">Affiliate Referrals</a></li>
                        <li><a href="#ReferralComission" data-toggle="tab">Referral Commission</a></li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade in " id="Daily">
                            @include('report.daily')
                        </div>
                        <!-- For Period Start -->
                        <div class="tab-pane fade in" id="For_Period">
                            @include('report.forperiod')
                        </div>
                        <!-- For Period End -->
                        <!-- Transaction Start -->
                        <div class="tab-pane  fade in" id="Transaction">
                            @include('report.transaction')
                        </div>
                        <div class="tab-pane fade in" id="Link">
                            @include('report.link')
                        </div>
                        <div class="tab-pane fade in" id="Referer">
                            @include('report.referer')
                        </div>
                        <div class="tab-pane fade in" id="Products">
                            @include('report.products')
                        </div>
                        <!-- Transaction End -->
                        <div class="tab-pane fade in" id="RecurringComission">
                            @include('report.recurringcomission')
                        </div>
                        <div class="tab-pane fade in" id="Graphs">
                            @include('report.graphs')
                        </div>
                        <div class="tab-pane fade in" id="AffiliateReferrals">
                            @include('report.affiliatereferral')
                        </div>
                        <div class="tab-pane fade in " id="ReferralComission">
                            @include('report.referralcomission')
                        </div>
                    </div>
                </div>
          
    </div>

@endsection

@section('script')
    <script>
        //   affiliateRefrral File URLS
        var GetAffiliateReferralDataURL = "{{ url('Report/GetAffiliateReferralData') }}";
        //   Daily Data File URLS
        var GetDailyDataURL = "{{ url('Report/GetDailyData') }}";
        //   For Period File URLS
        var GetForPeriodDataURL = "{{ url('Report/GetForPeriodData') }}";
        //   Graphs File URLS
        var GetGraphsDataURL = "{{ url('Report/GetGraphsData') }}";
         //   Links File URLS
         var GetLinkDataURL = "{{ url('Report/GetLinkData') }}";
        //   Graphs File URLS
        var GetProductsDataURL = "{{ url('Report/GetProductsData') }}";
           //   Recurring File URLS
           var GetRecurringDataURL = "{{ url('Report/GetRecurringData') }}";
        //   Graphs File URLS
        var GetRefererDataURL = "{{ url('Report/GetRefererData') }}";
        //   Recurring File URLS
        var GetReferralCommissionDataURL = "{{ url('Report/GetReferralCommissionData') }}";
        var GetSubReferralCommissionURL = "{{ url('Report/GetSubReferralCommission') }}";
        var SaleURL = "{{ url('Report/Sale') }}";
        //   Graphs File URLS
        var GetTransactionDataURL = "{{ url('Report/GetTransactionData') }}";

        function getUrl() {
            return "{{ url()->current() }}";
        }



        var calander = new Calendar({
            id: '#color-calendar',

        });
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            console.log("Current URL is = ", getUrl());


            transTable = $('#transTable')
                .on('init.dt', function() {

                    console.log('Transaction Table initialisation complete: ' + new Date().getTime());
                }).DataTable();
            refererTable = $('#refererTable')
                .on('init.dt', function() {

                    console.log('Referer Table initialisation complete: ' + new Date().getTime());
                }).DataTable();
            RecurringTable = $('#RecurringTable')
                .on('init.dt', function() {

                    console.log('Recurring Table initialisation complete: ' + new Date().getTime());
                }).DataTable();

            $('#productsTable')
                .on('init.dt', function() {

                    console.log('Products Table initialisation complete: ' + new Date().getTime());
                }).DataTable();

            $('#afReferralTable')
                .on('init.dt', function() {

                    console.log('Affiliate Referral Table initialisation complete: ' + new Date().getTime());
                }).DataTable();
                $('#RefCommissionTable')
                .on('init.dt', function() {

                    console.log('RefCommissionTable Table initialisation complete: ' + new Date().getTime());
                }).DataTable();

            getAffiliateReferral();


            $('a[data-toggle=tab]').addClass('btn btn-primary ');
            // $('li.active > a[data-toggle=tab]').removeClass('text-white');

            $('a[data-toggle=tab]').on('mouseover', function() {
                $(this).addClass('text-white bg-info');
            });
            $('a[data-toggle=tab]').on('mouseout', function() {
                $(this).removeClass('text-white bg-info');
            });

            $('#AffiliateGraphsControlGroup').hide();
        $('#myChart').hide();

            $('#approved').hide();
            $('#pending').hide();

            var RCType = $('select[name=RCType]').val();
            var RCMerchant = $('select[name=RCMerchant]').val();
            console.log("Merchant = " + RCMerchant + " Type = " + RCType);

            let _token = $('#tokenRecurring').val();
            let _url = "{{ url('Report/GetRecurringData') }}";
            $.ajax({
                url: _url,
                data: {
                    merchant: RCMerchant,
                    rcType: RCType,
                },
                _token: _token,
                type: "POST",
                success: function(response) {
                    console.log(response);




                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("No Data Found");

                },
            });

            // End Recurring Transactions


            var currentPage = "<?php echo $tabId; ?>";
            console.log(currentPage);

            $(currentPage).attr('class', 'tab-pane fade in active');
            $("a[href=" + currentPage + "]").parent().attr('class', 'active');

            $("#check").on('click', function() {


            });



            const myEvents = [{
                start: '2021-04-15T06:00:00',
                end: '2021-04-15T20:30:00',
                name: 'Event 1',
                url: 'https://www.cssscript.com',
                desc: 'Description 1',
                // more key value pairs here
            }, ];


            new Calendar({
                id: '#color-calendar',
                // small or large
                theme: 'glass',
                primaryColor: '#74B749',
                headerColor: 'white',
                headerBackgroundColor: '#74B749',
                calendarSize: 'small',
                eventsData: myEvents,
                dateChanged: (currentDate, DateEvents) => {
                    const m = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
                    const dateArray = [
                        "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12",
                        "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24",
                        "25", "26", "27", "28", "29", "30", "31",
                    ];
                    calander.setDate(currentDate);
                    const d = currentDate;
                    let date = dateArray[d.getDate() - 1];
                    let month = m[d.getMonth()];
                    let year = d.getFullYear();
                    dateToPass = year + "-" + month + "-" + date;
                    console.log("Date To Pass = " + dateToPass);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    let Merchant = $("select[name=MerchantDaily]").val();
                    let Affiliate = $("select[name=AffiliateDaily]").val();
                    console.log("Merchant = " + Merchant);
                    console.log("Affiliate = " + Affiliate);

                    let _token = $('#tokenDaily').val();
                    dateToPass = year + "-" + month + "-" + date;

                    let _url = "{{ url('Report/GetDailyData') }}";
                    $.ajax({
                        url: _url,
                        data: {
                            date: dateToPass,
                            affiliate: Affiliate,
                            merchant: Merchant,


                        },
                        _token: _token,
                        type: "POST",
                        success: function(response) {
                            if (response) {
                                $('#rawClicks').html(response['rawClick']);
                                $('#rawImpressions').html(response['rawImp']);
                                $('#nClick').html(response['nClick']);
                                $('#nLead').html(response['nLead']);
                                $('#nSale').html(response['nSale']);
                                $('#nImpression').html(response['nImpression']);
                                $('#clickCommission').html(response['clickCommission']);
                                $('#leadCommission').html(response['leadCommission']);
                                $('#saleCommission').html(response['saleCommission']);
                                $('#impressionCommission').html(response[
                                    'impressionCommission']);
                                console.log(response);

                            } else {
                                $('#rawClicks').html('NULL');
                                $('#rawImpressions').html('NULL');
                                $('#nClick').html('NULL');
                                $('#nLead').html('NULL');
                                $('#nSale').html('NULL');
                                $('#nImpression').html('NULL');
                                $('#clickCommission').html('NULL');
                                $('#leadCommission').html('NULL');
                                $('#saleCommission').html('NULL');
                                $('#impressionCommission').html('NULL');
                            }


                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert("No Data Found");

                        },



                        //   Success end

                    });
                    /////////
                },
                monthChanged: (currentDate, DateEvents) => {
                    // do something
                },

            });









        });

        $('#color-calendar').click(function() {
            console.log("Current Date = " + calander.getSelectedDate());




        });
    </script>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>
    <script src="{{ asset('js/reports/reports.js') }}"></script>
    <script src="{{ asset('js/reports/daily.js') }}"></script>
    <script src="{{ asset('js/reports/forPeriod.js') }}"></script>
    <script src="{{ asset('js/reports/transactions.js') }}"></script>
    <script src="{{ asset('js/reports/referer.js') }}"></script>
    <script src="{{ asset('js/reports/products.js') }}"></script>
    <script src="{{ asset('js/reports/recurringCommission.js') }}"></script>
    <script src="{{ asset('js/reports/affiliateReferral.js') }}"></script>
    <script src="{{ asset('js/reports/graphs.js') }}"></script>
    <script src="{{ asset('js/reports/link.js') }}"></script>
    <script src="{{ asset('js/reports/referralCommission.js') }}"></script>


@endsection

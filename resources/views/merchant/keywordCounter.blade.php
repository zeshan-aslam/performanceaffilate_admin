{{-- @php
    $symbol = DB::table('partners_currency')
        ->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
        ->select('currency_symbol')
        ->first();

@endphp --}}
@extends('layouts.masterClone')

@section('title', 'keywordCounter')
@section('style')
    <style>
        table {
            table-layout: fixed;
        }

        td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td:hover {
            overflow: visible;
            white-space: normal;
            -ms-word-break: break-all;
        }

        td:hover {
            overflow: visible;
            white-space: normal;
        }
    </style>
@endsection

@section('content')
    <h1 class="page-title">Keyword Counter({{ count($unique_brands) }})</h1>
    <div class='row-fluid'>


        <div class="span12">

            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4 class="text-white">Merchants Approved</h4>
                    <span class="tools">

                    </span>
                </div>
                <div class="widget-body">
                    <div class='row-fluid '>

                        {{-- <table class="table table-borderless">
                            <tr>
                                <td><i class="icon-refresh"></i><a href='javascript:;'
                                        onclick="javascript:searchCol('£Pending');">
                                        Pending </a></td>
                                <td><i class="icon-refresh"></i> Merchant has pending transactions</td>
                            </tr>
                            <tr>
                                <td><i class="icon-check-sign"></i><a href='javascript:;'
                                        onclick="javascript:searchCol('Approved');"> Approved </a></td>
                                <td><i class="icon-check-sign"></i> Merchant is approved to publish advertising links </td>
                            </tr>
                            <tr>
                                <td><i class="icon-remove-circle"></i> <a href='javascript:;'
                                        onclick="javascript:searchCol('Not Paid');">Not Paid</a></td>
                                <td><i class="icon-remove-circle"></i> Merchant has registered, but doesn't complete the
                                    payment
                                    process</td>
                            </tr>
                            <tr>
                                <td><i class="icon-spinner"></i><a href='javascript:;'
                                        onclick="javascript:searchCol('Waiting');"> Waiting </a></td>
                                <td><i class="icon-spinner"></i> Merchant is waiting for approval to publish advertising
                                    links
                                </td>
                            </tr>
                            <tr>
                                <td><i class="icon-meh"></i><a href='javascript:;'
                                        onclick="javascript:searchCol('£Empty');">
                                        Money Empty </a></td>
                                <td><i class="icon-meh"></i> Merchant has no money in his account</td>
                            </tr>
                            <tr>
                                <td><i class="icon-ban-circle"></i><a href='javascript:;'
                                        onclick="javascript:searchCol('Suspend');">
                                        Suspended </a></td>
                                <td><i class="icon-ban-circle"></i> Merchants are blocked. Can't login </td>
                            </tr>
                        </table> --}}
                        <hr>

                        <table id='merchants' class=" table table-striped table-hover table-bordered">
                            <thead class="text-dark">
                                <tr>

                                    <th>Merchant ( Brand Power )</th>
                                    <th>Brands</th>
                                    <th>Country of promotion</th>
                                    <th>Category</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot class="text-dark">
                                <tr>

                                    <th>Merchant ( Brand Power )</th>
                                    <th>Brands</th>
                                    <th>Country of promotion</th>
                                    <th>Category</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE widget-->


    @endsection
    @section('script')

        <script>
            var table = '';
            var successSound = new Audio("{{ asset('audio/success.mp3') }}");
            var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
            var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
            $(document).ready(function() {
                $("input").attr({

                    "min": 1 // values (or variables) here
                });
                console.log('Merchants ready');


                drawData();

                var merchantId = 0;
                var payMerchantId = 0;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });


                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

            });

            function drawData() {

                //===================OLD datatable================================//
                table = $('#merchants')
                    .on('init.dt', function() {

                        console.log('Table initialisation complete: ' + new Date().getTime());
                    })

                    .DataTable({
                        "initComplete": function() {
                            var api = this.api();
                            api.$('span').click(function() {
                                var tr = $(this).closest('tr');

                                var row = table.row(tr);
                                var data = row.data();
                                api.search(data.merchant_status).draw();
                            });

                        },
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        ajax: "{{ url('Merchant/getkeywords') }}",
                        "deferRender": true,
                        "stateSave": true,
                        "bDestroy": false,
                        "autoWidth": false,
                        columns: [

                            // {
                            //     "class": "details-control",
                            //     data:'brand_power',
                            // },
                            {
                                "class": "details-control",
                                // data:'brand_power',
                                // data: 'merchant_company',
                                render: function(data, type, row) {
                                    return "<a href ='javascript:;' class='text-link'><b>" + row.merchant_company +
                                        "</b></a> (" + row.brand_power + ")";
                                }
                            },

                            {

                                'data': 'brands',
                                render: function(data, type, row) {
                                    // data.replace("|", "");
                                    let mer_brands = data.split("|");

                                    var brand_label = "";
                                    for (var i = 0; i < mer_brands.length; i++) {
                                        if (mer_brands[i] !== "") {
                                            brand_label +=
                                                "<a href ='javascript:;' onclick='javascript:getConsMerchants()'  class='label label-info' style='margin:3px;'><b>" +
                                                mer_brands[i] +
                                                "</b></a> ";
                                        }

                                    }
                                    return brand_label;

                                }
                            },
                            {
                                data: 'countryOfPromotion',
                                render: function(data, type, row) {
                                    // data.replace("|", "");
                                    let mer_cop = data.split("<br />");

                                    var cop_label = "";
                                    for (var i = 0; i < mer_cop.length; i++) {
                                        if (mer_cop[i] !== "") {
                                            cop_label +=
                                                "<a href ='javascript:;' onclick=''  class='label label-warning' style='margin:3px;'><b>" +
                                                mer_cop[i] +
                                                "</b></a> ";
                                        }

                                    }
                                    return cop_label;

                                }
                            },
                            {
                                data: 'cat_name',
                                render: function(data, type, row) {


                                    category_label =
                                        "<a href ='javascript:;' onclick=''  class='label label-inverse' style='margin:3px;'><b>" +
                                        data +
                                        "</b></a> ";
                                    return category_label;



                                }
                            }



                        ],
                        "order": [
                            [1, "desc"]
                        ]

                    });

            }


            function searchCol(value) {
                // console.log("This is table value:", $('#merchants input').val());
                table.search(value).draw();

            }



            function getConsMerchants(id) {
                console.log('working fine');

            }
        </script>

    @endsection

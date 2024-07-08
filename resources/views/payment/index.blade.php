@extends('layouts.masterClone')

@section('title', 'Payments')

@section('content')

    @include('payment.viewModel')
    <h1 class="page-title"> Payments</h1>
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TAB PORTLET-->
            <div class="widget widget-tabs blue">
                <div class="widget-title">
                
                </div>
                <div class="widget-body">
                    <div class="tabbable ">

                        <ul class="nav nav-tabs">

                            <li><a href="#widget_tab1" data-toggle="tab">Invoice</a></li>
                            <li><a href="#widget_tab2" data-toggle="tab">Reverse Recurring Sale </a></li>
                            <li><a href="#widget_tab3" data-toggle="tab">Reverse Sale</a></li>
                            <li><a href="#widget_tab4" data-toggle="tab">Merchant Requests</a></li>
                            <li class="active"><a href="#widget_tab5" data-toggle="tab">Affiliate Requests</a></li>


                            <!-- <li class="active"><a href="#widget_tab1" data-toggle="tab">Tab 1</a></li> -->
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane" id="widget_tab1">
                                <div class="widget-body">

                                    @include('payment.invoice')

                                </div>
                            </div>
                            <div class="tab-pane" id="widget_tab2">

                                @include('payment.ReverseRecurringSale')

                            </div>
                            <div class="tab-pane" id="widget_tab3">

                                @include('payment.ReverseSale')

                            </div>
                            <div class="tab-pane" id="widget_tab4">

                                @include('payment.merchantReq')

                            </div>
                            <div class="tab-pane active" id="widget_tab5">

                                @include('payment.affiliateReq')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TAB PORTLET-->
        </div>


    </div>
@endsection

@section('script')

    <script type="text/javascript">
        
        let affreqsURL = "{{ url('Payments/affreqs') }}";
        let showAffURL = "{{ url('Payments/showAff') }}";
        let affReqDeclineURL = "{{ url('Payments/affReqDecline') }}";
        let affReqDeleteURL = "{{ url('Payments/affReqDelete') }}";
        let manualpayURL = "{{ url('Payments/manualpay') }}";

        let MerRequestURL = "{{ url('Payments/MerRequest') }}";
        let MerchantPayURL = "{{ url('Payments/MerchantPay') }}";
        let showMerURL = "{{ url('Payments/showMer') }}";
        let rejectMerURL = "{{ url('Payments/rejectMer') }}";

        let ReverseSaleURL = "{{ url('Payments/ReverseSale') }}";
        let payReverseURL = "{{ url('Payments/payReverse') }}";

        let ReverseRecureSaleURL = "{{ url('Payments/ReverseRecureSale') }}";
        let payReverseRecureURL = "{{ url('Payments/payReverseRecure') }}";

        let getInvoiceDataURL = "{{ url('Payments/getInvoiceData') }}";
        let detailstransURL = "{{ url('Payments/detailstrans') }}";
        let InvoicepaystatusURL = "{{ url('Payments/Invoicepaystatus') }}";

        var successSound = new Audio("{{asset('audio/success.mp3')}}");
        var errorSound = new Audio("{{asset('audio/error.mp3')}}");
        var warningSound = new Audio("{{asset('audio/warning.wav')}}");
        var invoicetable;


        $(document).ready(function() {

            var invoicetable = $('#invoiceTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            invoicedata();
            console.log("Ready to Main");
            $("#Invoice").click(function() {
                invoicedata();
            });

        });



        // -----------------------------Invoice----------------------//
        function invoicedata() {

            console.log('Transaction data below');


            let from = $("input[name=invoiceFrom]").val();
            let to = $("input[name=invoiceTo]").val();
            let status = $("select[name=status]").val();
            let _token = "{{ csrf_token() }}";

            $.ajax({
                type: "POST",
                url: getInvoiceDataURL,
                data: {
                    From: from,
                    To: to,
                    Status: status,
                },
                token: token,
                success: function(response) {
                    console.log("peachty hutt", response);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);

                },

            }).done(function(response) {

                console.log("Agay aaaaa", response);
                $('#invoiceTable').on('error.dt', function(e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                }).DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    "stateSave": true,
                    "bDestroy": true,
                    "autoWidth": false,



                    data: response['data'],
                    columns: [{
                            "_": "plain",
                            data: null,
                            render: function( data, type,row) {
                                return row.invoice_id;
                            }
                        },
                        {
                            data: 'invoice_monthyear',
                        },
                        {
                            "_": "plain",
                            data: null,
                            render: function(data, type,row) {
                                return row.merchant_company ;
                            }
                        },
                        {
                            "_": "plain",
                            data: null,
                            render: function(data, type,row) {
                                return "£ " + row.invoice_amount;
                            }
                        },
                        
                        {
                            "_": "plain",
                            data: null,
                            render: function(data, type,row) {
                                return "<a  href='javascript:;' onclick='javascript:transactionview(" +
                                    row.invoice_id + ")' > View Transaction </a>";
                            }

                        },
                        {
                            "_": "plain",
                            data: null,
                            render: function(data, type,row) {
                                if (row.invoice_paidstatus == 1) {
                                    return "<a  href='javascript:;' class='btn btn-danger btn-sm' onclick='javascript:invoiceUnPaidstatus(" +
                                        row.invoice_id + ")' >Mark as Unpaid</a>"
                                } else {
                                    return "<a  href='javascript:;' class='btn btn-success btn-sm' onclick='javascript:invoicePaidstatus(" +
                                        row.invoice_id + ")' >Mark as Paid</a>"
                                }
                            }

                        },


                    ],



                });



            });



        }


        function invoiceUnPaidstatus(id) {
            let status=0;
            $.ajax({
                type: "post",
                url: InvoicepaystatusURL,
                data: {
                    id: id,
                    status:status,
                },
            }).done(function(data) {
                console.log("Check data ", data);
                invoicedata();

                    if (data == 1) {
                        invoicedata();
                        successSound.play();
                        Command: toastr["success"]("Payments successfully", "Success")
                    }
                    else {
                        errorSound.play();
                        Command: toastr["error"](" ", "Error Payments Method")
                    }


            });
        }
        function invoicePaidstatus(id) {
            let status=1;
            $.ajax({
                type: "post",
                url: InvoicepaystatusURL,
                data: {
                    id: id,
                    status:status,
                },
            }).done(function(data) {
                console.log("Check data ", data);
                invoicedata();

                    if (data == 1) {
                        invoicedata();
                        successSound.play();
                        Command: toastr["success"]("Payments successfully", "Success")
                    }
                    else {
                        errorSound.play();
                        Command: toastr["error"](" ", "Error Payments Method")
                    }


            });
        }

        function transactionview(id) {
            console.log("id data", id);
            $.ajax({
                    type: "post",
                    url: detailstransURL,
                    data: {
                        id: id,
                    },
                })
                .done(function(data) {
                    console.log("check model", data);
                    warningSound.play();
                    let total = data.transaction_amttobepaid + data.transaction_admin_amount;
                    Swal.fire({
                        title: "Transaction Details ",
                        html: "<table class='table table-striped table-hover table-bordered' id='editable-sample1'>" +
                            "<tbody>" +
                            "<tr>" +
                            "<td><b>ID </b></td>" +
                            "<td>" + data.invoice_id + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Name </b></td>" +
                            "<td>" + data.merchant_firstname +" "+ data.merchant_lastname +"</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Address </b></td>" +
                            "<td>" + data.merchant_address + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>City </b></td>" +
                            "<td>" + data.merchant_city + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>state </b></td>" +
                            "<td>" + data.merchant_state + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Transaction </b></td>" +
                            "<td>" + data.transaction_type + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Date </b></td>" +
                            "<td>" + data.transaction_dateoftransaction + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Affiliate Commission </b></td>" +
                            "<td>£ " + data.transaction_amttobepaid + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b>Admin Commission </b></td>" +
                            "<td>£ " + data.transaction_admin_amount + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td><b> Total Amount </b></td>" +
                            "<td><b>£ " + total + "</b></td>" +
                            "</tr>" +
                            "</tbody>" +
                            "</table>",

                        showCancelButton: true,
                        cancelButtonColor: "#d33",

                    })
                });
        }
    </script>
@endsection
@section('scripts')

    <script src="{{ asset('js/Payments/payment.js') }}"></script>
    <script src="{{ asset('js/Payments/AffiliateReq.js') }}"></script>
    <script src="{{ asset('js/Payments/MerReq.js') }}"></script>
    <script src="{{ asset('js/Payments/ReverseSale.js') }}"></script>
    <script src="{{ asset('js/Payments/RevrseRecure.js') }}"></script>
    <script src="{{ asset('js/Payments/Invoice.js') }}"></script>

@endsection

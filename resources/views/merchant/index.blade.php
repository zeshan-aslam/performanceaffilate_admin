@php
$symbol = DB::table('partners_currency')
->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
->select('currency_symbol')
->first();

@endphp
@extends('layouts.masterClone')

@section('title', 'Merchant')

@section('content')
@section('style')
<style>
    table {
        table-layout: fixed;
    }

    .action {
        width: 85px !important;
    }
    .fontSize {
        font-size: 10px;
    }

    .check {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .check {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .check:hover {
        overflow: visible;
        white-space: normal;
        -ms-word-break: break-all;
    }

    .check:hover {
        overflow: visible;
        white-space: normal;
    }
</style>
@endsection
<h1 class="page-title">Merchants</h1>


<div class='row-fluid'>


    <div class="span12">

        <!-- BEGIN EXAMPLE TABLE widget-->
        <div class="widget blue">
            <div class="widget-title">
                <h4 class="text-white">Merchants ({{ count($merchants) }}) </h4>
                <span class="tools">

                </span>
            </div>
            <div class="widget-body">
                <div class='row-fluid '>

                    <table class="table table-borderless">
                        <tr>
                            <td><i class="icon-desktop"></i><a href='javascript:;' onclick="javascript:searchCol('Set Live');"> Live Merchants (With Setup) ({{ $setup_live }}) </a></td>
                            <td><i class="icon-desktop"></i> Merchants Live after Setup</td>
                        </tr>
                        <tr>
                            <td><i class="icon-spinner"></i><a href='javascript:;' onclick="javascript:searchCol('Set AA');"> Awaiting Authorization ({{ $Awaiting_Authorization }}) </a></td>
                            <td><i class="icon-spinner"></i> Waiting to be approved</td>
                        </tr>
                        <tr>
                            <td><i class="icon-star-half-empty"></i><a href='javascript:;' onclick="javascript:searchCol('Set NC');"> In Set Up ({{ $setup_NotCompleted }}) </a></td>
                            <td><i class="icon-star-half-empty"></i> Not Completed</td>
                        </tr>
                        <tr>
                            <td><i class="icon-refresh"></i><a href='javascript:;' onclick="javascript:searchCol('£Pending');"> Pending (<b id="pendingCount">0</b>)</a></td>
                            <td><i class="icon-refresh"></i> Merchant has pending transactions</td>
                        </tr>
                        <tr>
                            <td><i class="icon-check-sign"></i><a href='javascript:;' onclick="javascript:searchCol('Approved');"> Approved ({{ $approved }})</a></td>
                            <td><i class="icon-check-sign"></i> Merchant is approved to publish advertising links </td>
                        </tr>
                        <tr>
                            <td><i class="icon-desktop"></i><a href='javascript:;' onclick="javascript:searchCol('Set Old');"> Live Merchants (Without Setup) ({{ $setup_without_live }}) </a></td>
                            <td><i class="icon-desktop"></i> Merchants Live without Setup</td>
                        </tr>
                        <tr>
                            <td><i class="icon-remove-circle"></i> <a href='javascript:;' onclick="javascript:searchCol('NP');">Not Paid ({{ $NP }})</a></td>
                            <td><i class="icon-remove-circle"></i> Merchant has registered, but doesn't complete the
                                payment
                                process</td>
                        </tr>
                        <tr>
                            <td><i class="icon-spinner"></i><a href='javascript:;' onclick="javascript:searchCol('Waiting');"> Waiting ({{ $waiting }})</a></td>
                            <td><i class="icon-spinner"></i> Merchant is waiting for approval to publish advertising
                                links
                            </td>
                        </tr>
                        <tr>
                            <td><i class="icon-meh"></i><a href='javascript:;' onclick="javascript:searchCol('£0.00');">
                                    Money Empty (<b id="emptyCount">0</b>)</a></td>
                            <td><i class="icon-meh"></i> Merchant has no money in his account</td>
                        </tr>
                        <tr>
                            <td><i class="icon-ban-circle"></i><a href='javascript:;' onclick="javascript:searchCol('Suspend');">
                                    Suspended ({{ $suspend }})</a></td>
                            <td><i class="icon-ban-circle"></i> Merchants are blocked. Can't login </td>
                        </tr>
                    </table>
                    <hr>

                    <table id='merchants' class=" table table-striped table-hover table-bordered">
                        <thead class="text-dark">
                            <tr>

                                <th>Merchant</th>
                                <th>Status</th>
                                <th>In Setup</th>
                                <th>PGM Approval</th>
                                <th>Category </th>
                                <th>Country Of Promotion</th>
                                <th>Invoice Status</th>
                                <th>Registered</th>
                                <th>Pending Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                                <th>Notes</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot class="text-dark">
                            <tr>

                                <th>Merchant</th>
                                <th>Status</th>
                                <th>In Setup</th>
                                <th>PGM Approval</th>
                                <th>Category </th>
                                <th>Country Of Promotion</th>
                                <th>Invoice Status</th>
                                <th>Registered</th>
                                <th>Pending Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                                <th>Notes</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE widget-->


    <!-- END -->


    @endsection
    @section('script')

    <script>
        var table = '';
        var successSound = new Audio("{{ asset('audio/success.mp3') }}");
        var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
        var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
        $(document).ready(function() {

            $.ajax({
                url: "{{ url('Merchant/merchantPendings') }}",
                context: document.body,
                success: function(response) {
                    console.log("Pending:  ", response.pending);
                    console.log("Empty:  ", response.empty);
                    console.log("pending value:  ", $("#pendingCount").text());
                    $("#pendingCount").text(response.pending);
                    $("#emptyCount").text(response.empty);
                }
            });

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


        function format(d) {
            var detail = '';
            detail += "<tr class='well'>" +
                " <td class='text-success'><b>Name</b></td><td>" + d.merchant_firstname + " " + d.merchant_lastname +
                "</td> <td class='text-success'><b>Company</b></td><td>" + d.merchant_company +
                "</td> <td class='text-success'><b>Address</b></td><td>" + d.merchant_address + "</td>" +
                " <td class='text-success'><b>City</b></td><td>" + d.merchant_city +
                "</td> <td class='text-success'><b>Country</b></td><td>" + d.country_name +
                "</td> <td class='text-success'><b>Phone</b></td><td>" + d.merchant_phone + "</td>" +

                "</tr>";
            detail += "<tr>" +
                " <td class='text-success'><b>Category</b></td><td colspan='2'>" + d.cat_name +
                "</td> <td class='text-success'><b>Status</b></td><td colspan='2'>" + d.merchant_status +

                " <td class='text-success'><b>Type</b></td><td>" + d.merchant_type +
                "</td> <td class='text-success'><b>Currency</b></td><td>" + d.merchant_currency +
                "</td> <td class='text-success'><b>PGM Approval</b></td><td>" + d.merchant_pgmapproval + "</td>" +

                "</tr>";
            detail += "<tr>" +
                " <td class='text-success'><b>State</b></td><td>" + d.merchant_state +
                "</td> <td class='text-success'><b>Zip</b></td><td>" + d.merchant_zip +
                "</td> <td class='text-success'><b>Tax Id</b></td><td>" + d.merchant_taxId + "</td>" +
                " <td class='text-success'><b>Order Id</b></td><td>" + d.merchant_orderId +
                "</td> <td class='text-success'><b>Sale Amount</b></td><td>" + d.merchant_saleAmt +
                "</td> <td class='text-success'><b>Invoice Status</b></td><td>" + d.merchant_invoiceStatus + "</td>" +

                "</tr>";
            return detail;
        }


        function drawData() {



            table = $('#merchants')
                .on('init.dt', function() {

                    console.log('Table initialisation complete: ' + new Date().getTime());
                })

                .DataTable({
                    // "autoWidth": true,
                    // responsive: true;
                    'serverSide': true,
                    'processing': true,
                    'searching': true,
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
                        [5, 10, 25, 50, 100, 150, 200, 300],
                        [5, 10, 25, 50, 100, 150, 200, 300]
                    ],
                    ajax: "{{ url('Merchant/getMerchants') }}",
                    "deferRender": true,
                    "stateSave": true,
                    "bDestroy": false,
                    "autoWidth": false,
                    columns: [{
                            "class": "details-control action check",

                            data: 'merchant_company',
                            render: function(data, type, row) {
                                return "<a href ='javascript:;' class='text-link'><b>" + data +
                                    "</b></a>";
                            }
                        },

                        {
                            // "class" :"fontSize",
                            data: 'merchant_status',

                            render: function(data, type) {
                                if (type === 'display') {
                                    if (data == 'suspend')
                                        return "<span class='label bg-danger fontSize'><i class='icon-ban-circle'></i> Suspend</span>";
                                    else if (data == 'approved')
                                        return "<span class='label bg-success fontSize'><i class='icon-ok'></i>Approved</span>";
                                    else if (data == 'waiting')
                                        return "<span class='label bg-warning fontSize'><i class='icon-refresh'></i> Waiting</span>";
                                    else if (data == 'empty')
                                        return "<span class='label bg-dark fontSize'><i class='icon-meh'></i> Empty</span>";
                                    else if (data == 'NP')
                                        return "<span class='label bg-info fontSize'><i class='icon-remove-circle'></i> NP </span>";


                                }

                                return data;
                            }
                        },
                        {
                            // 'searchable': true,
                            data: 'in_setup',

                            render: function(data, type) {
                                if (type === 'display') {
                                    if (data == 'Set NC')
                                        return "<span class='label bg-danger fontSize'><i class='icon-ban-circle'></i>Set NC</span>";
                                    else if (data == 'Set Live')
                                        return "<span class='label bg-success fontSize'><i class='icon-ok'></i>Set Live</span>";
                                    else if (data == 'Set AA')
                                        return "<span class='label bg-warning fontSize'><i class='icon-refresh'></i>Set AA</span>";
                                }

                                return data;
                            }
                        },
                        {
                            "class": "text-dark check",
                            'data': 'merchant_pgmapproval',
                        },
                        {
                            orderable: false,
                            "class": "text-dark check",
                            'data': 'cat_name',
                        },
                        {
                            orderable: false,
                            "class": "text-dark check",
                            'data': 'countryOfPromotion',
                        },
                        {
                            "class": "text-dark",
                            'data': 'merchant_invoiceStatus',
                        },

                        {
                            'data': 'merchant_date',
                        },
                        {
                            orderable: false,
                            data: 'pending_amount',

                            render: function(data, type, row) {
                                if (data == null || data == 0) {
                                    return "<?php echo $symbol->currency_symbol; ?>0.00";
                                } else if (data != 0) {
                                    return "<?php echo $symbol->currency_symbol; ?><i style='display:none'>Pending</i>" + data
                                        .toFixed(1);
                                }
                            }
                        },
                        {
                            data: 'pay_amount',
                            render: function(data, type, row) {
                                if (data == null || data == 0) {
                                    return "<?php echo $symbol->currency_symbol; ?><i style='display:none'>Empty</i>0.00";
                                } else if (data != 0) {
                                    return "<?php echo $symbol->currency_symbol; ?>" + data.toFixed(2);
                                }

                            }
                        },
                        {
                            orderable: false,
                            "_": "plain",
                            data: null,
                            "class": "action",
                            'searchable': false,
                            render: function(data, type, row) {
                                var actions = "";


                                actions += "<div class='btn-group'>" +
                                    "<button data-toggle='dropdown' class='btn btn-info btn-small dropdown-toggle'>Select Action <span class='caret'></span></button>" +
                                    "<ul class='dropdown-menu'>" +
                                    "<li><a  href='javascript:;' onclick='javascript:addBrandPowerModel(" +
                                    row.merchant_id + "," + row.brand_power + ")' >Add Brands Power</a></li>" +
                                    "<li><a  href='javascript:;' onclick='javascript:adjustMoneyModel(" +
                                    row
                                    .merchant_id + ")' >Adjust Money</a></li>" +
                                    "<li><a href='" + "{{ url('Merchant/PaymentHistoryForm') }}/" + row
                                    .merchant_id +
                                    "'>Payment History</a></li>" +
                                    "  <li><a href='" + "{{ url('Merchant/TransactionForm') }}/" + row
                                    .merchant_id +
                                    "'>Transaction</a></li>";
                                if (row.merchant_status == 'suspend') {
                                    actions +=
                                        "<li><a   href='javascript:;' onclick='javascript:approveMerchant(" +
                                        row.merchant_id +
                                        ")' >Approve</a></li>" +
                                        "<li><a  href='javascript:;' onclick='javascript:deleteMerchantModel(" +
                                        row.merchant_id +
                                        ")'>Remove</a></li>";
                                }
                                if (row.in_setup == 'Set AA') {
                                    actions +=
                                        "<li><a   href='javascript:;' onclick='javascript:makeLiveMerchant(" +
                                        row.merchant_id +
                                        ")' >Make Live</a></li>";
                                }
                                if (row.in_setup == 'Set NC') {
                                    actions +=
                                        "<li><a   href='javascript:;' onclick='javascript:makeLiveMerchantWithoutSetup(" +
                                        row.merchant_id +
                                        ")' >Make Live (Without Setup)</a></li>";
                                }
                                if (row.merchant_status == 'approved') {
                                    actions +=
                                        "<li><a  href='javascript:;' onclick='javascript:suspendMerchant(" +
                                        row
                                        .merchant_id +
                                        ")' >Suspend</a></li>";
                                }
                                actions +=
                                    "<li><a href ='javascript:;'  onclick='javascript:confirmPassword(" +
                                    row
                                    .merchant_id +
                                    ")' ><span>Change Password </span></a></li>" +

                                    "<li><a  href ='javascript:;'  onclick='javascript:changePGM(" + row
                                    .merchant_id +
                                    ")' >Change PGM Approval</a></li>";
                                if (row.merchant_invoiceStatus == 'inactive') {
                                    actions +=
                                        "<li><a  href ='javascript:'  onclick='javascript:activateInvoive(" +
                                        row.merchant_id +
                                        ")'>Activate Invoice Status</a></li>";
                                }
                                if (row.merchant_invoiceStatus == 'active') {
                                    actions +=
                                        "<li><a  href ='javascript:;'  onclick='javascript:deactivateInvoive(" +
                                        row.merchant_id +
                                        ")' >Deactivate Invoice Status</a></li>";
                                }
                                actions += "</ul>" +
                                    "</div>";

                                return actions;
                            }
                        },
                        {

                            data: "merchant_id",
                            render: function(data, type) {

                                return "<a class='btn' target='_blank' href='{{ url('Merchant/Login') }}/" +
                                    data +
                                    "'>Login</a>";
                            },

                        },
                    ],
                    "order": [
                        [1, "desc"]
                    ]

                });

            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#merchants tbody').on('click', 'tr td.details-control', function() {
                var tr = $(this).closest('tr');
                var i = $(this).closest('i.icon-plus-sign');
                var row = table.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                if (row.child.isShown()) {
                    i.removeClass('icon-minus-sign');
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    i.addClass('icon-minus-sign');
                    row.child(format(row.data())).show();

                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            });
            table.on('draw', function() {
                $.each(detailRows, function(i, id) {
                    $('#' + id + ' td.details-control').trigger('click');
                });
            });


        }

        function searchCol(value) {

        
            table.search(value).draw();

        }

        //........................................................................................................................................
        function deleteMerchantModel(id) {
            console.log('Remove merchant ID', id);
            $.ajax({
                    type: "GET",
                    url: "{{ url('Merchant') }}/" + id,

                })
                .done(function(data) {
                    console.log(data);

                    merchantId = data.merchant_id;
                    console.log(data);
                    warningSound.play();
                    Swal.fire({
                        title: "Are you sure you want to delete " + data.merchant_company + " ?",
                        text: "You won't be able to revert this",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it"
                    }).then((result) => {
                        if (result.isConfirmed) {


                            let _token = "{{ csrf_token() }}";
                            $.ajax({
                                type: "POST",
                                url: "Merchant/RemoveMerchant",
                                data: {
                                    id: id,

                                },
                                _token: _token,
                            }).done(function(data) {
                                table.ajax.reload(null, false);
                                if (data == 1) {

                                    Swal.fire(
                                        "Deleted",
                                        "Merchant has been Removed Successfully",
                                        "success"
                                    )
                                    successSound.play();
                                }

                            });
                        }


                    })



                });

        }



        function adjustMoneyModel(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "GET",
                url: "{{ url('Merchant/AdjustMoneyForm') }}/" + id,

            }).done(function(data) {
                console.log(data);


                Swal.fire({
                    title: 'Adjust Money',
                    html: "<div class='form-horizontal'>" +


                        "<div class='control-group'>" +
                        "<label class='control-label'>Current Amount</label>" +
                        "<div class='controls'>" +
                        "  <input name='old_pay_amount'  type='number'  value='" + data.pay_amount +
                        "' placeholder='Current Amount' class='input-large' readonly/>" +

                        "  </div>" +
                        "</div>" +


                        "<div class='control-group'>" +
                        "<label class='control-label'>Amount</label>" +
                        "<div class='controls'>" +
                        "  <input name='pay_amount' min='1' max='100000' type='number' placeholder='Amount' class='input-large' />" +

                        "  </div>" +
                        "</div>" +
                        "<div class='control-group'>" +
                        "<label class='control-label'>Action</label>" +
                        "<div class='controls'>" +
                        "<select name='action'class='input-medium' >" +
                        "<option value='add'>Add</option>" +
                        "<option value='deduct'>Deduct</option>" +
                        "</select>" +

                        " </div>" +
                        "</div>" +


                        "</div>",

                    confirmButtonText: 'Adjust',
                    focusConfirm: false,
                    showCloseButton: true,
                    preConfirm: () => {
                        const old_pay_amount = parseInt(Swal.getPopup().querySelector(
                            'input[name=old_pay_amount]').value, 10)
                        const pay_amount = parseInt(Swal.getPopup().querySelector(
                            'input[name=pay_amount]').value, 10)
                        const action = Swal.getPopup().querySelector('select[name=action]').value

                        if (!pay_amount) {
                            if (!pay_amount) {
                                Swal.showValidationMessage(`Please enter Amount`)
                            }


                        } else if (pay_amount < 1) {
                            Swal.showValidationMessage(
                                `Please input Amount must not be 0 or Negative`)
                        } else if (pay_amount > 100000) {
                            Swal.showValidationMessage(`Amount Limit 100000`)
                        } else if (action == 'deduct') {
                            if (pay_amount > old_pay_amount) {
                                Swal.showValidationMessage(
                                    `You cannot deduct more than current Amount`)
                            } else {
                                return {
                                    old_pay_amount: old_pay_amount,
                                    action: action,
                                    pay_amount: pay_amount
                                }

                            }

                        } else {
                            return {
                                old_pay_amount: old_pay_amount,
                                action: action,
                                pay_amount: pay_amount
                            }
                        }





                    }
                }).then((result) => {
                    console.log(result);

                    let _token = "{{ csrf_token() }}";
                    $.ajax({
                        type: "POST",
                        url: "Merchant/AdjustMoney",
                        data: {
                            id: data.pay_merchantid,
                            pay_amount: result.value.pay_amount,
                            action: result.value.action,

                        },
                        _token: _token,
                        success: function(response) {


                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            errorSound.play();
                            Command: toastr["error"](" ", thrownError)

                        },

                    }).done(function(data) {
                        if (data == 1) {
                            table.ajax.reload(null, false);
                            successSound.play();
                            Command: toastr["success"]("Money Adjusted successfully", "Success")

                        } else if (data == 0) {
                            errorSound.play();
                            Command: toastr["error"](" ", "Cannot Updated Money")

                        } else {
                            errorSound.play();
                            Command: toastr["error"](" ", "Error Adjusting Money")

                        }




                    });


                });



            });
        }




        function confirmPassword(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "GET",
                url: "{{ url('Merchant/ChangePasswordForm') }}/" + id,

            }).done(function(data) {
                console.log(data);


                Swal.fire({
                    title: 'Change Password Form',
                    html: "<div class='form-horizontal'>" +


                        "<div class='control-group'>" +
                        "<label class='control-label'>Email</label>" +
                        "<div class='controls'>" +
                        "  <input name='cpEmail' type='text'  value='" + data.login_email +
                        "' placeholder='Email'  maxlength='25' minlength='5'class='input-large' readonly/>" +
                        "<span class='help-inline'></span>" +
                        "  </div>" +
                        "</div>" +


                        "<div class='control-group'>" +
                        "<label class='control-label'>Password</label>" +
                        "<div class='controls'>" +
                        "  <input name='cpPassword'maxlength='20' minlength='8' type='password' value='' placeholder='Password' class='input-large' />" +
                        "<span class='help-inline'></span>" +
                        "  </div>" +
                        "</div>" +
                        "<div class='control-group'>" +
                        "<label class='control-label'>Confirm Password</label>" +
                        "<div class='controls'>" +
                        "  <input name='cpConPassword' maxlength='20' minlength='8'type='password'value='' placeholder='Confirm Password' class='input-large' />" +
                        "<span class='help-inline'></span>" +
                        "  </div>" +
                        "</div>" +


                        "</div>",

                    confirmButtonText: 'Change Password',
                    focusConfirm: false,
                    showCloseButton: true,
                    preConfirm: () => {
                        const email = Swal.getPopup().querySelector('input[name=cpEmail]').value
                        const password = Swal.getPopup().querySelector('input[name=cpPassword]')
                            .value
                        const ConPassword = Swal.getPopup().querySelector(
                                'input[name=cpConPassword]')
                            .value

                        if (email == '' || password == '' || ConPassword == '') {

                            if (email == '') {
                                Swal.showValidationMessage(`Please enter Email`)
                            }
                            if (password == '') {
                                Swal.showValidationMessage(`Please enter Password`)
                            }

                            if (ConPassword == '') {
                                Swal.showValidationMessage(`Please enter confirm Password`)

                            }
                            if (password == '' && ConPassword == '') {
                                Swal.showValidationMessage(
                                    `Please enter Password & Confirm Password`)
                            }
                        } else if (password.length < 8) {
                            Swal.showValidationMessage(`Please enter at least 8 Characters`)

                        } else if (password != ConPassword) {
                            Swal.showValidationMessage(`Passwords do not Match`)
                        } else {
                            return {
                                email: email,
                                password: password
                            }
                        }


                    }
                }).then((result) => {

                    let _token = "{{ csrf_token() }}";
                    $.ajax({
                        type: "POST",
                        url: "Merchant/ChangePassword",
                        data: {
                            id: data.login_id,
                            password: result.value.password,



                        },
                        _token: _token,
                        success: function(response) {


                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            errorSound.play();
                            Command: toastr["error"](" ", "Error Changing Password")

                        },

                    }).done(function(data) {
                        if (data == 1) {
                            table.ajax.reload(null, false);
                            successSound.play();
                            Command: toastr["success"]("Password Changed", "Success")

                        } else {
                            errorSound.play();
                            Command: toastr["error"](" ", "Error Changing Password")

                        }




                    });


                });



            });
        }

        function approveMerchant(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/ApproveMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);

                    successSound.play();
                    Command: toastr["success"]("Merchant Approved", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error Approving Merchant")

                }

            });

        }

        function makeLiveMerchant(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/MakeLiveMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);

                    successSound.play();
                    Command: toastr["success"]("Merchant is Live Now ", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error Making Merchant Live")

                }

            });

        }
        function makeLiveMerchantWithoutSetup(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/MakeLiveMerchantWithoutSetup') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);

                    successSound.play();
                    Command: toastr["success"]("Merchant is Live Now ", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error Making Merchant Live")

                }

            });

        }

        function addBrandPowerModel(id, brand_power) {
            options = '';
            if (brand_power == "1") {
                options += "<div class='form-horizontal'>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Add Brands Power</label>" +
                    "<div class='controls'>" +
                    "<select name='power' id='power'><option value='1' selected>1</option><option value='2'>2</option>" +
                    "<option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select>" +
                    // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>",
                    console.log(brand_power);
            }
            if (brand_power == "2") {
                options += "<div class='form-horizontal'>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Add Brands Power</label>" +
                    "<div class='controls'>" +
                    "<select name='power' id='power'><option value='1'>1</option><option value='2' selected>2</option>" +
                    "<option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select>" +
                    // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>",
                    console.log(brand_power);
            }
            if (brand_power == "3") {
                options += "<div class='form-horizontal'>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Add Brands Power</label>" +
                    "<div class='controls'>" +
                    "<select name='power' id='power'><option value='1'>1</option><option value='2' >2</option>" +
                    "<option value='3' selected>3</option><option value='4'>4</option><option value='5'>5</option></select>" +
                    // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>",
                    console.log(brand_power);
            }
            if (brand_power == "4") {
                options += "<div class='form-horizontal'>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Add Brands Power</label>" +
                    "<div class='controls'>" +
                    "<select name='power' id='power'><option value='1'>1</option><option value='2' >2</option>" +
                    "<option value='3' >3</option><option value='4' selected>4</option><option value='5'>5</option></select>" +
                    // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>",
                    console.log(brand_power);
            }
            if (brand_power == "5") {
                options += "<div class='form-horizontal'>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Add Brands Power</label>" +
                    "<div class='controls'>" +
                    "<select name='power' id='power'><option value='1'>1</option><option value='2'>2</option>" +
                    "<option value='3'>3</option><option value='4'>4</option><option value='5' selected>5</option></select>" +
                    // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>",
                    console.log(brand_power);
            }


            //    options="<div class='form-horizontal'>" +
            //         "<div class='control-group'>" +
            //         "<label class='control-label'>Add Brands Power</label>" +
            //         "<div class='controls'>" + 
            // //   "<select name='power' id='power'><option value='1' "+brand_power== '3' ? 'selected':''+">1</option><option value='2' >2</option></select>" +
            //     //  "<select name='power' id='power'>"+
            //         // "<option value='3' "+brand_power== '3' ? 'selected':''">3</option></select>"+
            //         "<select name='power' id='power'><option value=''>"+brand_power+"</option><option value='1'>1</option><option value='2'>2</option>"+
            //          "<option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select>" +
            //         // " <input name='power' type='text'  value='"+brand_power+"' placeholder='Brands Power' class='input-large'/>" +
            //         "<span class='help-inline'></span>" +
            //         "  </div>" +
            //         "</div>" +
            //         "</div>",
            Swal.fire({

                title: "Add Brands Power To This Merchant",
                html: options,
                confirmButtonText: 'Confirm',
                focusConfirm: false,
                showCloseButton: true,
                preConfirm: () => {
                    const power = Swal.getPopup().querySelector('select[name=power]').value
                    return {
                        power: power,
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('AddBrandPower') }}",
                        data: {
                            id: id,
                            power: result.value.power
                        },
                    }).done(function(data) {
                        console.log(data);
                        if (data == 1) {
                            table.ajax.reload(null, false);
                            successSound.play();
                            Command: toastr["success"]("Brands Power Added", "Success")

                        }
                        if (data.code == 0) {
                            errorSound.play();
                            Command: toastr["error"](" ", data.message)
                        }

                    });
                }
            });
        }

        function suspendMerchant(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/SuspendMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {

                if (data == 1) {
                    table.ajax.reload(null, false);
                    successSound.play();
                    Command: toastr["success"]("Merchant Suspended", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error Suspending Merchant")


                }

            });

        }

        function changePGM(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/PGMApprovelMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);
                    successSound.play();
                    Command: toastr["success"]("Merchant PGM Approvel Status Changed", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in Changing PGM Approvel")

                }

            });

        }

        function activateInvoive(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/ActivateInvoiceStatusMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);
                    successSound.play();
                    Command: toastr["success"]("Merchant Inoice Activated", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in Activating Invoice")

                }

            });

        }

        function deactivateInvoive(id) {
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ url('Merchant/DeActivateInvoiceStatusMerchant') }}",
                data: {
                    id: id,
                },
                _token: _token,

            }).done(function(data) {
                if (data == 1) {
                    table.ajax.reload(null, false);
                    successSound.play();
                    Command: toastr["success"]("Merchant Inoice Deactivated", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in deactivating Invoice")

                }

            });

        }
    </script>
    @endsection
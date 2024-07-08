@php
$symbol = DB::table('partners_currency')
->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
->select('currency_symbol')
->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Affiliate')

@section('content')


<h1 class="page-title">Affiliate</h1>
<div class='row-fluid'>
    <div class="span12">

        <div class="widget blue">
            <div class="widget-title">
                <h4 class="text-white">All Affiliate ({{ count($affiliate) }}) </h4>
                <span class="tools">

                </span>
            </div>
            <div class="widget-body">
                <div class='row-fluid '>

                    <table class="table table-borderless">
                        <tr>
                            <td><i class="icon-refresh"></i><a href='javascript:;' onclick="javascript:searchCol('£Pending');">
                                    Pending (<b id="pendingCount">0</b>)</a></td>
                            <td><i class="icon-refresh"></i> Affiliate has pending transactions </td>
                        </tr>
                        <tr>
                            <td><i class="icon-check-sign"></i><a href='javascript:;' onclick="javascript:searchCol('Approved');"> Approved ({{ $approved }})</a></td>
                            <td><i class="icon-check-sign"></i> Affiliate is approved to publish advertising links </td>
                        </tr>
                        <tr>
                            <td><i class="icon-spinner"></i><a href='javascript:;' onclick="javascript:searchCol('Waiting');">
                                    Waiting ({{ $waiting }})</a></td>
                            <td><i class="icon-spinner"></i> Affiliate is waiting for approval to publish advertising
                                links </td>
                        </tr>
                        <tr>
                            <td><i class="icon-ban-circle"></i><a href='javascript:;' onclick="javascript:searchCol('Suspend');">
                                    Suspended ({{ $suspend }})</a></td>
                            <td><i class="icon-ban-circle"></i> Affiliate is blocked. Can't login </td>
                        </tr>


                    </table>
                    <hr>

                    <table id='affiliates' class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>

                                <th>Affiliate</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Pending Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                        <tfoot>
                            <tr>

                                <th>Affiliate</th>
                                <th>Status</th>
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
</div>

@endsection

@section('script')
<script>
    var successSound = new Audio("{{ asset('audio/success.mp3') }}");
    var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
    var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
    $(document).ready(function() {

        $.ajax({
            url: "{{ url('Affiliate/affiliatePendings')  }}",
            context: document.body,
            success: function(response) {
                console.log("Pending:  ", response.pending);
                $("#pendingCount").text(response.pending);
            }
        });

        var table = '';
        console.log('Affiliate ready');

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
            " <td class='text-success'><b>Name</b></td><td>" + d.affiliate_firstname + " " + d.affiliate_lastname +
            "</td> <td class='text-success'><b>Company</b></td><td>" + d.affiliate_company +
            "</td> <td class='text-success'><b>Address</b></td><td>" + d.affiliate_address + "</td>" +
            " <td class='text-success'><b>City</b></td><td>" + d.affiliate_city +
            "</td> <td class='text-success'><b>Country</b></td><td>" + d.affiliate_country +
            "</td> <td class='text-success'><b>Phone</b></td><td>" + d.affiliate_phone + "</td>" +
            "</td> <td class='text-success'><b>Zip</b></td><td>" + d.affiliate_zipcode + "</td>" +
            "<td class='text-success'><b>Email</b></td><td>" + d.affiliate_url + "</td>" +
            "</tr>";
        detail += "<tr>" +
            "<td class='text-success'><b>Category</b></td><td>" + d.affiliate_category +
            "</td> <td class='text-success'><b>Status</b></td><td>" + d.affiliate_status +
            "</td> <td class='text-success'><b>Tax Id</b></td><td>" + d.affiliate_taxId + "</td>" +
            "<td class='text-success'><b>Currency</b></td><td>" + d.affiliate_currency + "</td>" +
            "<td class='text-success'><b>State</b></td><td>" + d.affiliate_state + "</td>" +
            "<td class='text-success'><b>URL</b></td><td>" + d.affiliate_url + "</td>" +
            "</tr>";
        return detail;
    }

    function drawData() {

        table = $('#affiliates')
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
                        api.search(data.affiliate_status).draw();
                    });

                },
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                ajax: "{{ url('Affiliate/getAffiliates') }}",
                "deferRender": true,
                "stateSave": true,
                "bDestroy": false,
                "autoWidth": false,

                columns: [{
                        "class": "affiliate-control",
                        "_": "plain",
                        data: null,
                        render: function(row, data, type) {
                            return "<a href ='javascript:; class='text-link'>" + row.affiliate_company + "</a>";
                        }
                    },
                    {
                        data: 'affiliate_status',
                        render: function(data, type) {
                            if (type === 'display') {
                                if (data == 'suspend')
                                    return "<span class='label bg-danger'><i class='icon-ban-circle'></i> Suspend</span>";
                                else if (data == 'approved')
                                    return "<span class='label bg-success'><i class='icon-ok'></i> Approved</span>";
                                else if (data == 'waiting')
                                    return "<span class='label bg-warning'><i class='icon-refresh'></i> Waiting</span>";
                                else if (data == 'empty')
                                    return "<span class='label bg-dark'><i class='icon-meh'></i> Empty</span>";
                                else if (data == 'NP')
                                    return "<span class='label bg-info'><i class='icon-remove-circle'></i> Not Paid</span>";


                            }
                            return data;
                        }
                    },

                    {
                        'data': 'affiliate_date',
                    },

                    {

                        data: 'pending_amount',
                        render: function(data, type) {
                            if (data == null || data == 0) {
                                return "<?php echo $symbol->currency_symbol; ?>0.00";
                            } else if (data != 0) {
                                return "<?php echo $symbol->currency_symbol; ?><i style='display:none'>Pending</i>" +
                                    data.toFixed(1);
                            }
                        }
                    },
                    {

                        data: 'pay_amount',
                        render: function(data, type, row) {
                            if (data == null) {
                                return "<?php echo $symbol->currency_symbol; ?> 0";
                            } else {
                                return "<?php echo $symbol->currency_symbol; ?> " + data.toFixed(2);
                            }

                        }
                    },
                    {
                        "_": "plain",
                        'searchable': false,
                        data: null,
                        render: function(row, data, type) {
                            var actions = "";


                            actions += "<div class='btn-group'>" +
                                "<button data-toggle='dropdown' class='btn btn-info btn-small dropdown-toggle'>Select Action <span class='caret'></span></button>" +
                                "<ul class='dropdown-menu'>";
                            if (row.affiliate_status == 'approved') {
                                actions +=
                                    "<li><a  href='javascript:;' onclick='javascript:suspendAffiliate(" +
                                    row
                                    .affiliate_id +
                                    ")' >Suspend</a></li>";
                            }
                            if (row.affiliate_status == 'suspend') {
                                actions +=
                                    "<li><a   href='javascript:;' onclick='javascript:approveAffiliate(" +
                                    row.affiliate_id +
                                    ")' >Approve</a></li>";
                            }
                            if (row.affiliate_status == 'waiting') {
                                actions +=
                                    "<li><a   href='javascript:;' onclick='javascript:approveAffiliate(" +
                                    row.affiliate_id +
                                    ")' >Approve</a></li>";

                            }
                            actions +=
                                "<li><a  href='javascript:;' onclick='javascript:RejectAffiliate(" +
                                row.affiliate_id + ")' >Reject</a></li>" +

                                "<li><a  href='javascript:;' onclick='javascript:deleteAffiliateModel(" +
                                row.affiliate_id + ")' >Remove</a></li>" +

                                "<li><a class='affiliate-control' href ='javascript:;' ><span>View Profile</span></a></li>" +

                                "<li><a href ='javascript:;'  onclick='javascript:confirmPassword(" + row
                                .affiliate_id +
                                ")' ><span>Change Password</span></a></li>" +

                                "<li><a href='" + "{{ url('Affiliate/PaymentHistoryForm') }}/" +
                                row.affiliate_id + "'>Payment History</a></li>" +

                                "  <li><a href='" + "{{ url('Affiliate/TransactionForm') }}/" + row
                                .affiliate_id +
                                "'>Transaction</a></li>" +

                                "<li><a  href='javascript:;' onclick='javascript:adjustMoneyAffiliate(" +
                                row.affiliate_id + ")'>Adjust Money</a></li>" +

                                "<li><a  href='javascript:;' onclick='javascript:SetCommission(" +
                                row.affiliate_id + ")' >Set Commission Group</a></li>";


                            actions += "</ul>" +
                                "</div>";

                            return actions;
                        }
                    },
                    {
                        data: "affiliate_id",
                        render: function(data, type) {
                            return "<a class='btn btn-primary btn-sm' target='_blank' href='Affiliate/Login/" +
                                data +
                                "'>Login</a>";
                        },
                    },
                ],
                "order": [
                    [0, 'asc']
                ],


            });

        function formatAffiliate(d) {
            var detail = '';
            detail +=
                "<table style='font-size:12px' class='table table-bordered table-hover'><tbody><tr class='well'>" +
                " <td class='text-success'><b>Name</b></td><td>" + d.affiliate_firstname + " " + d.affiliate_lastname +
                "</td> <td class='text-success'><b>Company</b></td><td>" + d.affiliate_company +
                "</td> <td class='text-success'><b>Address</b></td><td>" + d.affiliate_address + "</td>" +

                "</tr >";
            detail +=
                "<tr class='well'><td class='text-success'><b>City</b></td><td>" + d.affiliate_city +
                "</td> <td class='text-success'><b>Country</b></td><td>" + d.affiliate_country +
                "</td> <td class='text-success'><b>Phone</b></td><td>" + d.affiliate_phone + "</td>" +

                "</tr>";
            detail += "<tr class='well'>" +
                " <td class='text-success'><b>Category</b></td><td>" + d.affiliate_category +
                "</td> <td class='text-success'><b>Status</b></td><td>" + d.affiliate_status +
                "</td> <td class='text-success'><b>Tax ID</b></td><td>" + d.affiliate_taxId + "</td>" +
                "</tr>";
            detail += "<tr class='well'>" +
                " <td class='text-success' cols='4' row='4'><b>State</b></td><td>" + d.affiliate_state +
                "</td> <td class='text-success'><b>Zip</b></td><td>" + d.affiliate_zipcode + "</td>" +
                "</td> <td class='text-success'><b>URL</b></td><td>" + d.affiliate_url +
                "</tr>";
            detail += "<tr class='well'>" +
                " <td class='text-success'><b>Currency</b></td><td>" + d.affiliate_currency +
                "</td>" +
                // " <td class='text-success'><b>Email</b></td><td>" + d.login_email +"</td>"+
                "</tr>";

            detail += "</tbody></table>";

            // .swal - text {
            //     max - height: 6 em; /* To be adjusted as you like */
            //     overflow - y: scroll;
            //     width: 100 % ;
            // }

            Swal.fire({
                title: "Affiliate : " + d.affiliate_company,
                html: detail,
                position: 'top',
                // text:{
                //     max-height: 6 em; /* To be adjusted as you like */
                //     overflow - y: scroll;
                //     width: 100 % ;
                // },
                showClass: {
                    popup: `
              animate__animated
              animate__bounceIn
              animate__faster
                 `
                },
                hideClass: {
                    popup: `
             animate__animated
             animate__zoomOut
             animate__faster
                      `
                },
                grow: 'row',
                // overflow: auto;
                width: 600,
                showConfirmButton: false,
                showCloseButton: true
            })
        }
        $('#affiliates tbody').on('click', 'tr td.affiliate-control,.affiliate-control', function() {
            // $('body').css('overflow', 'hidden');
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            formatAffiliate(row.data());

        });

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#affiliates tbody').on('click', 'tr td.details-control', function() {
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
        $('#affiliates').DataTable().search(value, false, true)
            .draw();


    }

    function confirmPassword(id) {
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "GET",
            url: "{{ url('Affiliate/changePasswordForm') }}/" + id,

        }).done(function(data) {
            console.log(data);
            table.ajax.reload(null, false);

            Swal.fire({
                title: 'Change Password Form',
                html: "<div class='form-horizontal'>" +

                    "<div class='control-group'>" +
                    "<label class='control-label'>Email</label>" +
                    "<div class='controls'>" +
                    "  <input name='cpEmail' type='text'  value='" + data.login_email +
                    "' placeholder='Email' class='input-large' readonly/>" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +


                    "<div class='control-group'>" +
                    "<label class='control-label'>Password</label>" +
                    "<div class='controls'>" +
                    "  <input name='cpPassword' type='password'maxlength='20' minlength='8' placeholder='Password' class='input-large' />" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                    "<div class='control-group'>" +
                    "<label class='control-label'>Confirm Password</label>" +
                    "<div class='controls'>" +
                    "  <input name='cpConPassword' type='password' maxlength='20' minlength='8' placeholder='Confirm Password' class='input-large' />" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +


                    "</div>",

                confirmButtonText: 'Change Password',
                focusConfirm: false,
                showCloseButton: true,
                preConfirm: () => {
                    const email = Swal.getPopup().querySelector('input[name=cpEmail]').value
                    const password = Swal.getPopup().querySelector('input[name=cpPassword]').value
                    const ConPassword = Swal.getPopup().querySelector('input[name=cpConPassword]')
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
                            Swal.showValidationMessage(`Please enter Password & Confirm Password`)
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
                    url: "{{ url('Affiliate/changePassword') }}",
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

    function EmailAffiliate(id) {
        console.log("email start");
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ url('Mailsend') }}",
            data: {
                id: id,
            },
            _token: _token,
        }).done(function(data) {
            console.log("Email dataaa checkeddd ", data);
            if (data == 1) {
                table.ajax.reload(null, false);

                successSound.play();
                Command: toastr["success"]("Affiliate Email Send", "Success")

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error Email Affiliate")

            }

        });

    }

    function approveAffiliate(id) {
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ url('Affiliate/approveIt') }}",
            data: {
                id: id,
            },
            _token: _token,

        }).done(function(data) {
            console.log("Wapssiii Approve ka data", data);
            if (data == 1) {
                // EmailAffiliate(id);
                table.ajax.reload(null, false);

                successSound.play();
                Command: toastr["success"]("Affiliate Account Approved and Tier Commission Group Assigned",
                    "Success")

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error Approving Affiliate")

            }

        });

    }

    function suspendAffiliate(id) {
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ url('Affiliate/suspend') }}",
            data: {
                id: id,
            },
            _token: _token,

        }).done(function(data) {
            if (data == 1) {
                table.ajax.reload(null, false);
                successSound.play();
                Command: toastr["success"]("Affiliate Suspended", "Success")

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error Suspending Affiliate")
            }

        });

    }


    function adjustMoneyAffiliate(id) {
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "GET",
            url: "{{ url('Affiliate/adjustMoneyForm') }}/" + id,

        }).done(function(data) {
            console.log(data);
            table.ajax.reload();

            Swal.fire({
                title: 'Adjust Money',
                html: "<div class='form-horizontal'>" +


                    "<div class='control-group'>" +
                    "<label class='control-label'>Current Amount</label>" +
                    "<div class='controls'>" +
                    "  <input name='old_pay_amount' type='number'  value='" + data.pay_amount +
                    "' placeholder='Current Amount' class='input-large' readonly/>" +

                    "  </div>" +
                    "</div>" +


                    "<div class='control-group'>" +
                    "<label class='control-label'>Amount</label>" +
                    "<div class='controls'>" +
                    "  <input name='pay_amount' max='100000' type='number' value='' placeholder='Amount' class='input-large' />" +

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
                    const pay_amount = parseInt(Swal.getPopup().querySelector('input[name=pay_amount]')
                        .value, 10)
                    const action = Swal.getPopup().querySelector('select[name=action]').value

                    if (!pay_amount) {
                        if (!pay_amount) {
                            Swal.showValidationMessage(`Please enter Amount`)
                        }


                    } else if (pay_amount < 1) {
                        Swal.showValidationMessage(`Please input Amount must not be 0 or Negative`)
                    } else if (pay_amount > 100000) {
                        Swal.showValidationMessage(`Amount Limit 100000`)
                    } else if (action == 'deduct') {
                        if (pay_amount > old_pay_amount) {
                            Swal.showValidationMessage(`You cannot deduct more than current Amount`)
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
                    url: "{{ url('Affiliate/adjustMoney') }}",
                    data: {
                        id: data.pay_affiliateid,
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

                    } else {
                        errorSound.play();
                        Command: toastr["error"](" ", "Error Adjusting Money")

                    }

                });


            });



        });
    }

    function SetCommission(id) {
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "GET",
            url: "{{ url('Affiliate') }}/" + id,

        }).done(function(data) {
            console.log("Set comession", data);
            table.ajax.reload();

            Swal.fire({
                title: 'Set Commission Group for Affiliate, ' + data.affiliate_company,
                html: "<div class='form-horizontal'>" +

                    "<div class='control-group'>" +
                    "<label class='control-label'>Commission Group</label>" +
                    "<div class='controls'>" +
                    "<select name='groupId'class='input-medium' >" +
                    "<option value='0'>No Tier Commission</option>" +
                    "<option value='1'>Tier Commission</option>" +
                    "</select>" +

                    "</div>" +
                    "</div>" +
                    "</div>",

                confirmButtonText: 'Set Commission',
                focusConfirm: false,
                showCloseButton: true,
                preConfirm: () => {
                    const groupId = Swal.getPopup().querySelector('select[name=groupId]').value


                    if (!groupId) {
                        Swal.showValidationMessage(`Please enter Details`)
                    }

                    return {
                        groupId: groupId,


                    }
                }

            }).then((result) => {
                console.log(result);

                let _token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "Affiliate/setcommission/" + data.affiliate_id,
                    data: {
                        id: data.affiliate_id,
                        groupId: result.value.groupId,


                    },
                    _token: _token,
                    success: function(response) {

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        errorSound.play();
                        Command: toastr["error"](" ", thrownError)

                    },

                }).done(function(data) {
                    console.log("assign comission", data);
                    if (data == 1) {
                        table.ajax.reload(null, false);
                        successSound.play();
                        Command: toastr["success"](
                            "Tier Commission Group Assigned to Affiliate", "Success")

                    } else if (data == 2) {
                        errorSound.play();
                        Command: toastr["error"](" ",
                            "Tier Commission Group Already Assigned to Affiliate")

                    } else {
                        errorSound.play();
                        Command: toastr["error"](" ",
                            "Tier Commission Group Not Assigned to Affiliate")

                    }

                });

            });

        });
    }

    function RejectAffiliate(id) {

        $.ajax({
                type: "GET",
                url: "{{ url('Affiliate') }}/" + id,
                data: {
                    id: id,

                },

            })
            .done(function(data) {
                console.log(data);

                affiliateId = data.affiliate_id;
                console.log(data);
                warningSound.play();
                Swal.fire({
                    title: "Are you sure you want to Reject " + data.affiliate_company + " ?",
                    html: "<table class='table table-striped table-hover table-bordered' id='editable-sample1'>" +
                        "<tbody>" +
                        "<tr>" +
                        "<td><b>ID </b></td>" +
                        "<td>" + data.affiliate_id + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Company Name</b></td>" +
                        "<td>" + data.affiliate_company + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>First Name </b></td>" +
                        "<td> " + data.affiliate_firstname + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Last Name </b></td>" +
                        "<td> " + data.affiliate_lastname + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Address </b></td>" +
                        "<td> " + data.affiliate_address + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>City</b></td>" +
                        "<td> " + data.affiliate_city + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Country  </b></td>" +
                        "<td> " + data.custom_data.affiliate_country + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Phone </b></td>" +
                        "<td> " + data.affiliate_phone + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>URL </b></td>" +
                        "<td> " + data.affiliate_url + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Category </b></td>" +
                        "<td> " + data.custom_data.affiliate_category + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Status</b></td>" +
                        "<td> " + data.affiliate_status + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Date of Joining  </b></td>" +
                        "<td> " + data.affiliate_date + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td><b>Fax </b></td>" +
                        "<td>" + data.affiliate_fax + "</td>" +
                        "</tr>" +
                        "</tbody>" +
                        "</table>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Reject it"
                }).then((result) => {
                    if (result.isConfirmed) {

                        let _token = "{{ csrf_token() }}";
                        $.ajax({
                            type: "POST",
                            url: "Affiliate/removeAffiliate",
                            data: {
                                id: id,

                            },
                            _token: _token,
                        }).done(function(data) {
                            console.log("Deleteeeeed", data);
                            table.ajax.reload(null, false);
                            if (data == 1) {

                                Swal.fire(
                                    "Rejected",
                                    "Affiliate has been Reject Successfully",
                                    "success"
                                )
                                successSound.play();
                            }

                        });
                    }


                })
            });
    }

    function deleteAffiliateModel(id) {

        $.ajax({
                type: "GET",
                url: "{{ url('Affiliate') }}/" + id,
                data: {
                    id: id,

                },

            })
            .done(function(data) {
                console.log(data);

                affiliateId = data.affiliate_id;
                console.log(data);
                warningSound.play();
                Swal.fire({
                    title: "Are you sure you want to Delete " + data.affiliate_company + " ?",
                    text: "You won't be able to revert this",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Delete it"
                }).then((result) => {
                    if (result.isConfirmed) {

                        let _token = "{{ csrf_token() }}";
                        $.ajax({
                            type: "POST",
                            url: "Affiliate/removeAffiliate",
                            data: {
                                id: id,

                            },
                            _token: _token,
                        }).done(function(data) {
                            console.log("Deleteeeeed", data);
                            table.ajax.reload(null, false);
                            if (data == 1) {

                                Swal.fire(
                                    "Deleted",
                                    "Affiliate has been Removed Successfully",
                                    "success"
                                )
                                successSound.play();
                            }

                        });
                    }


                })
            });
    }
</script>

@endsection
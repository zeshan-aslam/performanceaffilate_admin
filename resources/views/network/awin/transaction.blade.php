@extends('layouts.masterClone')

@section('title', 'Awin | Notifications')
@section('content')
    <h1 class="page-title">Transaction of <span class="text-primary">{{ AwinHelper::getPublisher($id) }}</span></h1>
    <div class='row-fluid'>
        <div class="span12">
            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> Transactions ( Monthly )</h4>

                </div>
                <input type="hidden" value="{{ $id }}" name="id">
                <div class="widget-body">
                    <div class="row-fluid bg-light">
                        <div class="span3 p-3">
                            <div class="control-group">
                                <div class="control-label">Start Date</div>
                                <div class="controls">
                                    <input type="date" name="startDate" class="input-large">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">End Date</div>
                                <div class="controls">
                                    <input type="date" name="endDate" class="input-large">
                                </div>
                            </div>

                        </div>
                        <div class="span3 p-3">
                            <div class="control-group">
                                <div class="control-label">Date Type</div>
                                <div class="controls">
                                    <select class="m-wrap input-large" tabindex="1" name="dateType">
                                        <option value="transaction"> Transaction </option>
                                        <option value="validation"> Validation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">Status</div>
                                <div class="controls">
                                    <select class="m-wrap input-large" tabindex="1" name="status">
                                        <option value="approved"> Approved</option>
                                        <option value="pending"> Pending </option>

                                        <option value="declined"> Declined </option>
                                        <option value="deleted"> Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">

                                <center> <button type="button" onclick="javascript:getFilteredTransactions();"
                                        class="btn btn-success">View</button>
                                    {{-- <button type="button" onclick="javascript:getTransactions();"
                                        class="btn ">Reset</button> --}}

                                </center>


                            </div>

                        </div>
                        <div class="span3 p-3">
                            <div class="control-group">
                                <div class="control-label">Timezone</div>
                                <div class="controls">
                                    <select class="m-wrap input-large" tabindex="1" name="timezone">
                                        <option value="UTC"> UTC </option>
                                        <option value="Europe/Berlin"> Europe/Berlin </option>
                                        <option value="Europe/Paris "> Europe/Paris </option>
                                        <option value="Europe/London"> Europe/London</option>
                                        <option value="Europe/Dublin"> Europe/Dublin</option>
                                        <option value="Canada/Eastern"> Canada/Eastern</option>
                                        <option value="Canada/Central"> Canada/Central</option>
                                        <option value="validation"> Canada/Mountain</option>
                                        <option value="Canada/Pacific"> Canada/Pacific</option>
                                        <option value="US/Eastern"> US/Eastern</option>
                                        <option value="US/Central"> US/Central</option>
                                        <option value="US/Mountain"> US/Mountain</option>
                                        <option value="US/Pacific"> US/Pacific</option>


                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">Advertisers</div>
                                <div class="controls">
                                    <select class="m-wrap input-large" tabindex="1">
                                        <option value="Advertiser1"> Advertiser1 </option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="span2 p-3">

                        </div>
                    </div>
                    <div class="row-fluid mt-5">
                        <div class="span12">
                            @if (session()->has('error'))
                                <div class="alert alert-danger"><strong> Error !</strong>
                                    {{ session()->get('error') }} <button data-dismiss="alert" class="close"
                                        type="button">×</button>
                                </div>
                            @else
                                <table id="transactions" class="table table-hover table-stripped">
                                    <thead>
                                        <th></th>
                                        <th>Advertiser</th>
                                        <th>ID</th>
                                        <th>Click Date</th>
                                        <th>Transaction Date</th>
                                        <th>Validation Date</th>
                                        <th>Payment Progress</th>
                                        <th>Device</th>
                                        <th>Voucher Code</th>
                                        <th>URL</th>
                                        <th>Sale Amount</th>
                                        <th>Commission</th>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                <div class="row mt-5">

                                    <div class="col-11 mx-auto card pb-2">

                                        <h2 class="bg-light text-dark p-2">Grand Totals</h2>


                                        <table class="table table-bordered">
                                            <thead class="text-dark">
                                                <th></th>
                                                <th>Quantity</th>
                                                <th>Sale Amount</th>
                                                <th>Commission</th>



                                            </thead>
                                            <tbody>
                                                <tr class="alert alert-warning">
                                                    <td><b>Pending</b></td>
                                                    <td id="pendingQuantity"></td>
                                                    <td id="pendingSale"></td>
                                                    <td id="pendingCommission"></td>
                                                </tr>
                                                <tr class="alert-success">
                                                    <td><b>Approved</b></td>
                                                    <td id="approvedQuantity"></td>
                                                    <td id="approvedSale"></td>
                                                    <td id="approvedCommission"></td>
                                                </tr>
                                                <tr class="text-dark">
                                                    <td><b>Bonus</b></td>
                                                    <td id="bonusQuantity"></td>
                                                    <td id="bonusSale"></td>
                                                    <td id="bonusCommission"></td>
                                                </tr>
                                                <tr class="alert-success">
                                                    <td><b>Total</b></td>
                                                    <td id="totalQuantity"></td>
                                                    <td id="totalSale"></td>
                                                    <td id="totalCommission"></td>
                                                </tr>
                                                <tr class="alert-danger">
                                                    <td><b>Declined</b></td>
                                                    <td id="declinedQuantity"></td>
                                                    <td id="declinedSale"></td>
                                                    <td id="declinedCommission"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>



                </div>
            </div>

            <!-- END GRID PORTLET-->
        </div>
    @endsection
    @section('script')
        <script>
            var table = '';
            var successSound = new Audio("{{ asset('audio/success.mp3') }}");
            var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
            var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "100",
                    "hideDuration": "3000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
            });


            function format(d) {
                var detail = '';
                var clickRefs = '';
                if (d.clickRefs == null) {
                    clickRefs = 'Null';
                } else {
                    clickRefs = d.clickRefs.clickRef;
                }
                detail += "<tr class='well'>" +
                    " <td class='text-info'><b>Publisher</b></td><td>" + d.publisher + "</td> " +
                    "<td class='text-info'><b>Advertiser ID</b></td><td>" + d.advertiserId + "</td> " +
                    "<td class='text-info'><b>Compaign</b></td><td>" + d.campaign + "</td>" +
                    "<td class='text-info'><b>Site Name</b></td><td>" + d.siteName + "</td> " +
                    "<td class='text-info'><b>Commission Status</b></td><td>" + d.commissionStatus + "</td> " +

                    "<td class='text-info'><b>Commission Amount</b></td><td>" + d.commissionAmount.amount + "</td> " +


                    "</tr>";

                detail += "<tr class='well'>" +
                    " <td class='text-info'><b>Customer Country</b></td><td>" + d.customerCountry + "</td> " +
                    "<td class='text-info'><b>ClickRefs </b></td><td>" + clickRefs + "</td> " +
                    "<td class='text-info'><b>Date</b></td><td> Click : " + d.clickDate + "<br/>Trans :" + d.transactionDate +
                    "<br/>Valid :" + d.validationDate + "</td>" +
                    "<td class='text-info'><b>Site Name</b></td><td>" + d.siteName + "</td> " +
                    "<td class='text-info'><b>Type</b></td><td>" + d.type + "</td> " +

                    "<td class='text-info'><b>Sale Amount</b></td><td>" + d.saleAmount.amount + "</td> " +


                    "</tr>";


                return detail;
            }

            function saleAmountDetails(data) {
                var tag = '';
                if (data.commissionStatus == 'declined') {
                    tag = 'danger';

                }
                if (data.commissionStatus == 'approved') {
                    tag = 'success';

                }

                var detail = '';
                detail += "<table style='font-size:12px' class='table table-bordered'><tbody>";
                detail += "<thead><tr class='bg-light text-dark'>" +
                    "<th>Publisher</th>" +
                    "<th>Advertiser Id</th>" +
                    "<th>Date</th>" +
                    "<th>Amount (GBP)</th>" +
                    "<th>Commission (GBP)</th>" +
                    "</tr></thead><tbody>";
                detail += "<tr>" +
                    "<td>" + data.publisher + "</td>" +
                    "<td>" + data.advertiserId + "</td>" +
                    "<td> Click : " + data.clickDate + "<br/> Transaction : " + data.transactionDate + "<br/> Validation : " +
                    data.validationDate + "<br/>" + "</td>" +
                    "<td class='alert-" + tag + " text-dark'>" + data.transactionParts[0].amount + "</td>" +
                    "<td class='alert-" + tag + " text-dark'>" + data.transactionParts[0].commissionAmount + "</td>" +
                    "</tr>";


                detail += "</tbody></table>";
                detail += "<h1>Commission Groups</h1>";

                detail += "<table style='font-size:12px' class='table table-bordered'><tbody>";
                detail += "<thead><tr class='bg-light text-dark'>" +
                    "<th>Comm Group Code</th>" +
                    "<th>Comm Group Name</th>" +
                    "<th>Tracked Parts</th>" +
                    "<th>Commission Rate</th>" +
                    "<th>Amount (GBP)</th>" +
                    "<th>Commission (GBP)</th>" +
                    "</tr></thead><tbody>";
                detail += "<tr>" +
                    "<td>" + data.transactionParts[0].commissionGroupCode + "</td>" +
                    "<td>" + data.transactionParts[0].commissionGroupName + "</td>" +
                    "<td>" + data.transactionParts[0].trackedParts[0].code + "</td>" +
                    "<td>" + data.transactionParts[0].amount + "</td>" +
                    "<td>" + data.transactionParts[0].amount + "</td>" +
                    "<td>" + data.transactionParts[0].commissionAmount + "</td>" +
                    "</tr>";
                detail += "<tr>" +
                    "<td colspan='3'><b>Total</b></td>" +
                    "<td class='alert-" + tag + " text-dark'>" + data.transactionParts[0].amount + "</td>" +
                    "<td class='alert-" + tag + " text-dark'>" + data.transactionParts[0].commissionAmount + "</td>" +
                    "<td></td>" +
                    "</tr>";


                detail += "</tbody></table>";

                Swal.fire({
                    title: "Transaction Breakdown of  " + data.publisher,
                    html: detail,
                    position: 'top',
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
                    width: 900,
                    showConfirmButton: false,
                    showCloseButton: true
                })
                return detail;
            }


            function getTransactions() {
                table.ajax.reload();

            }

            function getFilteredTransactions() {
                id = $('input[name=id]').val();
                let status = $('select[name=status]').val();
                let timezone = $('select[name=timezone]').val();
                let dateType = $('select[name=dateType]').val();
                let startDate = $('input[name=startDate]').val();
                let endDate = $('input[name=endDate]').val();


                if (startDate == '' || endDate == '') {
                    errorSound.play();
                    Command: toastr["error"]('Please Input Date', "Validation Error")
                } else {



                    console.log('Start Date : ' + startDate);
                    console.log('End Date : ' + endDate);
                    $.ajax({
                        type: "POST",
                        url: "{{ url('AWIN/GetFilteredTransactions') }}",
                        data: {
                            id: id,
                            status: status,
                            timezone: timezone,
                            dateType: dateType,
                            startDate: startDate,
                            endDate: endDate,
                        },
                        _token: "{{ csrf_token() }}",
                    }).done(function(response) {
                        console.log("Response ", response);
                        let approvedSale = 0;
                        let approvedCommission = 0;
                        let approvedQuantity = 0;

                        let pendingSale = 0;
                        let pendingCommission = 0;
                        let pendingQuantity = 0;

                        let declinedSale = 0;
                        let declinedCommission = 0;
                        let declinedQuantity = 0;

                        let bonusSale = 0;
                        let bonusCommission = 0;
                        let bonusQuantity = 0;
                        for (let index = 0; index < response.length; index++) {
                            if (response[index].commissionStatus == 'approved') {
                                console.log(index, response[index].saleAmount.amount);
                                approvedSale += response[index].saleAmount.amount;
                                approvedCommission += response[index].commissionAmount.amount;
                                approvedQuantity++;
                            }
                            if (response[index].commissionStatus == 'pending') {
                                console.log(index, response[index].saleAmount.amount);
                                pendingSale += response[index].saleAmount.amount;
                                pendingCommission += response[index].commissionAmount.amount;
                                pendingQuantity++;
                            }
                            if (response[index].commissionStatus == 'bonus') {
                                console.log(index, response[index].saleAmount.amount);
                                approvedSale += response[index].saleAmount.amount;
                                approvedCommission += response[index].commissionAmount.amount;
                                approvedQuantity++;
                            }
                            if (response[index].commissionStatus == 'declined') {
                                console.log(index, response[index].saleAmount.amount);
                                declinedSale += response[index].saleAmount.amount;
                                declinedCommission += response[index].commissionAmount.amount;
                                declinedQuantity++;
                            }


                        }
                        $('#approvedQuantity').html(approvedQuantity);
                        $('#approvedSale').html(approvedSale.toFixed(2));
                        $('#approvedCommission').html(approvedCommission.toFixed(2));

                        $('#pendingQuantity').html(pendingQuantity);
                        $('#pendingSale').html(pendingSale.toFixed(2));
                        $('#pendingCommission').html(pendingCommission.toFixed(2));

                        $('#totalQuantity').html(approvedQuantity + pendingQuantity);
                        $('#totalSale').html((approvedSale + pendingSale).toFixed(2));
                        $('#totalCommission').html((pendingCommission + approvedCommission).toFixed(2));

                        $('#declinedQuantity').html(declinedQuantity);
                        $('#declinedSale').html(declinedSale.toFixed(2));
                        $('#declinedCommission').html(declinedCommission.toFixed(2));


                        if (response['Error']) {
                            errorSound.play();
                            Command: toastr["error"](response['Error'], "Awin Server Error")
                        }

                        table = $('#transactions')



                            .DataTable({
                                "lengthMenu": [
                                    [5, 10, 25, 50, -1],
                                    [5, 10, 25, 50, "All"]
                                ],
                                data: response,
                                "deferRender": true,
                                "stateSave": true,
                                "bDestroy": true,
                                "autoWidth": false,

                                columns: [{
                                        "class": "details",
                                        "_": "plain",
                                        data: null,
                                        render: function(data, type, row) {
                                            return "<i class='text-info icon-circle-arrow-down'></i>";
                                        }
                                    },

                                    {
                                        data: 'advertiserId',

                                    },
                                    {
                                        data: 'publisher',

                                    },
                                    {
                                        data: 'clickDate',

                                    },
                                    {
                                        data: 'transactionDate',

                                    },

                                    {
                                        data: 'validationDate',

                                    },
                                    {
                                        data: 'commissionStatus',

                                    },

                                    {
                                        data: 'transactionDevice',

                                    },
                                    {
                                        data: 'voucherCode',

                                    },
                                    {

                                        data: 'url',
                                        render: function(data, type, row) {

                                            return "<a href ='" + data + "' target='_blank'>" + data +
                                                "</a>";
                                        }

                                    },

                                    {
                                        "class": "details-sales",
                                        "_": "plain",
                                        data: null,
                                        render: function(data, type, row) {
                                            var tag = '';
                                            if (row.commissionStatus == 'declined') {
                                                tag = 'btn btn-danger';

                                            }
                                            if (row.commissionStatus == 'approved') {
                                                tag = 'btn btn-success';

                                            }
                                            return "<a href ='javascript:;' class='" + tag + " '><b>" + row
                                                .saleAmount.amount + "</b></a>";
                                        }
                                    },
                                    {
                                        "class": "details-commission",
                                        "_": "plain",
                                        data: null,
                                        render: function(data, type, row) {
                                            return row.commissionAmount.amount;
                                        }
                                    },

                                ],
                                "order": [
                                    [1, 'asc']
                                ],


                            });

                    })
                }

            }
            $('#transactions tbody').on('click', 'tr td.details-sales a', function() {
                console.log('Clicked');

                var tr = $(this).closest('tr');
                var row = table.row(tr);
                saleAmountDetails(row.data());

            });
            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#transactions tbody').on('click', 'tr td.details', function() {

                var tr = $(this).closest('tr');
                var i = $(this).closest('i.icon-circle-arrow-down');
                var row = table.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                if (row.child.isShown()) {
                    i.removeClass('icon-circle-arrow-up');
                    row.child.hide();
                    isShownChild = true;

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    i.addClass('icon-circle-arrow-down');
                    row.child(format(row.data())).show();
                    isShownChild = false;
                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            });
            table.on('draw', function() {
                $.each(detailRows, function(i, id) {
                    $('#' + id + ' td.details').trigger('click');
                });
            });
        </script>
    @endsection

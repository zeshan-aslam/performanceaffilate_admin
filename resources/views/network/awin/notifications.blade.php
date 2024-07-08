@extends('layouts.masterClone')

@section('title', 'Awin | Notifications')
@section('content')
<h1 class="page-title">Transaction Notifications of <span class="text-primary">{{AwinHelper::getPublisher($id)}}</span></h1>
    <div class='row-fluid'>
        <div class="span12">
            <!-- BEGIN GRID SAMPLE PORTLET-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> Notifications </h4>
                    <span class="tools">

                    </span>
                </div>
                <input type="hidden"  value="{{$id}}" name="id" >
                <div class="widget-body">

                    @if (session()->has('error'))
                        <div class="alert alert-danger"><strong> Error !</strong>
                            {{ session()->get('error') }} <button data-dismiss="alert" class="close"
                                type="button">×</button>
                        </div>
                    @else
                        <table id="notifications" class="table table-hover table-stripped">
                            <thead>
                                <th></th>
                                <th>Advertiser</th>
                                <th>ID</th>
                                <th>Transaction Date</th>
                                <th>Click Time</th>
                                <th>URL</th>
                                <th>Sale Amount</th>
                                <th>Commission</th>
                                <th>Comsn Groups</th>
                                <th>Products</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    @endif

                </div>
            </div>

            <!-- END GRID PORTLET-->
        </div>
    @endsection
    @section('script')
        <script>
            var isShownChild=false;
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });
                drawData();
            });

            function format(d) {
                var detail = '';
                detail += "<tr class='well'>" +
                    " <td class='text-success'><b>transactionId</b></td><td>" + d.transactionId +
                    "</td> <td class='text-success'><b>transactionDate</b></td><td>" + d.transactionDate +
                    "</td> <td class='text-success'><b>transactionCurrency</b></td><td>" + d.transactionCurrency + "</td>" +
                    " <td class='text-success'><b>transactionAmount</b></td><td>" + d.transactionAmount +


                    "</td></tr>";
                detail += "<tr class='well'>" +
                    " <td class='text-success'><b>affiliateId</b></td><td>" + d.affiliateId +
                    "</td> <td class='text-success'><b>merchantId</b></td><td>" + d.merchantId +
                    "</td> <td class='text-success'><b>groupId</b></td><td>" + d.groupId + "</td>" +
                    " <td class='text-success'><b>bannerId</b></td><td>" + d.bannerId +


                    "</td></tr>";
                detail += "<tr class='well'>" +
                    " <td class='text-success'><b>clickRef</b></td><td>" + d.clickRef +
                    "</td> <td class='text-success'><b>clickThroughTime</b></td><td>" + d.clickThroughTime +
                    "</td> <td class='text-success'><b>ip</b></td><td>" + d.ip + "</td>" +
                    " <td class='text-success'><b>commission</b></td><td>" + d.commission +


                    "</td></tr>";
                detail += "<tr class='well'>" +
                    " <td class='text-success'><b>clickTime</b></td><td>" + d.clickTime +
                    "</td> <td class='text-success'><b>url</b></td><td>" + d.url +
                    "</td> <td class='text-success'><b>phrase</b></td><td>" + d.phrase + "</td>" +
                    " <td class='text-success'><b>searchEngine</b></td><td>" + d.searchEngine +


                    "</td></tr>";

                return detail;
            }

            function product(data) {
                var detail = '';
                detail += "<table style='font-size:12px' class='table table-bordered table-hover'><tbody>";
                detail += "<thead><tr class='bg-blue text-white'>" +
                    "<th>Product Name</th>" +
                    "<th>Unit Price</th>" +
                    "<th>SKU Type</th>" +
                    "<th>SKU Code</th>" +
                    "<th>Quantity</th>" +
                    "<th>Catagory</th></tr></thead><tbody>";


                $.ajax({
                    type: "GET",
                    url: "{{ url('AWIN/GetProducts') }}/" + data.id,


                }).done(function(response) {
                    console.log("Products", response[0].productName);
                    for (let index = 0; index < response.length; index++) {
                        detail += "<tr>" +
                            "<td>" + response[index].productName +
                            "</td><td>" + response[index].unitPrice +
                            "</td><td>" + response[index].skuType + "</td>" +
                            "<td>" + response[index].skuCode +
                            "<td>" + response[index].quantity +
                            "</td><td>" + response[index].category +


                            "</td></tr>";

                    }
                    detail += "</tbody></table>"
                    Swal.fire({
                        title: "Products of Affiliate ID " + data.affiliateId,
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
                        width: 600,
                        showConfirmButton: false,
                        showCloseButton: true
                    })

                });
                console.log("Details", detail);






                return detail;
            }

            function commission(data) {
                var detail = '';
                detail += "<table style='font-size:12px' class='table table-bordered table-hover'><tbody>";
                detail += "<thead><tr class='bg-blue text-white'>" +
                    "<th>ID</th>" +
                    "<th>Name</th>" +
                    "<th>Description</th>" +
                    "<th>Code</th>" +
                    "</tr></thead><tbody>";


                $.ajax({
                    type: "GET",
                    url: "{{ url('AWIN/GetCommissionGroups') }}/" + data.id,


                }).done(function(response) {
                    console.log("Commission Groups", response[0].id);
                    for (let index = 0; index < response.length; index++) {
                        detail += "<tr>" +
                            "<td>" + response[index].id +
                            "</td><td>" + response[index].name +
                            "</td><td>" + response[index].description + "</td>" +
                            "<td>" + response[index].code +
                            "</td></tr>";

                    }
                    detail += "</tbody></table>"
                    Swal.fire({
                        title: "Commission Groups of Affiliate ID " + data.affiliateId,
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
                        width: 600,
                        showConfirmButton: false,
                        showCloseButton: true
                    })

                });
                console.log("Details", detail);






                return detail;
            }



            function drawData() {


                 var id=$('input[name=id]').val();
                table = $('table')
                    .on('init.dt', function() {

                        console.log('Table initialisation complete: ' + new Date().getTime());
                    })


                    .DataTable({
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        ajax: "{{ url('AWIN/GetNotifications') }}/"+id,
                        "deferRender": true,
                        "stateSave": true,
                        "bDestroy": false,
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
                                data: 'affiliateId',

                            },
                            {
                                data: 'affiliateId',

                            },
                            {
                                data: 'transactionDate',

                            },
                            {
                                data: 'clickTime',

                            },

                            {
                                data: 'url',

                            },
                            {
                                data: 'transactionAmount',

                            },
                            {
                                data: 'commission',

                            },
                            {
                                "class": "details-groups",
                                "_": "plain",
                                data: null,
                                render: function(data, type, row) {
                                    return "<a href ='javascript:;'>Commission Groups</a>";
                                }
                            },
                            {
                                "class": "details-products",
                                "_": "plain",
                                data: null,
                                render: function(data, type, row) {
                                    return "<a href ='javascript:;'>Products</a>";
                                }
                            },

                        ],
                        "order": [
                            [1, 'asc']
                        ],


                    });

                // Array to track the ids of the details displayed rows
                var detailRows = [];

                $('table tbody').on('click', 'tr td.details', function() {
                    
                    var tr = $(this).closest('tr');
                    var i = $(this).closest('i.icon-circle-arrow-down');
                    var row = table.row(tr);
                    var idx = $.inArray(tr.attr('id'), detailRows);

                    if (row.child.isShown()) {
                        i.removeClass('icon-circle-arrow-up');
                        row.child.hide();
                        isShownChild=true;

                        // Remove from the 'open' array
                        detailRows.splice(idx, 1);
                    } else {
                        i.addClass('icon-circle-arrow-down');
                        row.child(format(row.data())).show();
                        isShownChild=false;
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
                detailRows = [];

                $('table tbody').on('click', 'tr td.details-groups a', function() {
                    var tr = $(this).closest('tr');

                    var row = table.row(tr);

                    commission(row.data())

                });


                $('table tbody').on('click', 'tr td.details-products a', function() {
                    var tr = $(this).closest('tr');

                    var row = table.row(tr);

                    product(row.data());

                });



            }
            if(!isShownChild){
                setInterval(() => {
                table.ajax.reload();

            }, 10000);
            }
           
        </script>
    @endsection

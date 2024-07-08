@extends('layouts.masterClone')

@section('title', 'PGM Status')

@section('content')

<h3 class="page-title">
    PGM Status</h3>
<div class='row-fluid' id="pgmstatus">

    <!-- BEGIN EXAMPLE TABLE widget-->
    <div class="widget blue">
        <div class="widget-title">
            <h4><i class='fa fa-wrench faa-wrench animated fa-4x'></i> PGM Status</h4>

        </div>
        <div class="card p-3">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <i class="icon-ok"></i><a href='javascript:;' class="addschem nondon" onclick="javascript:searchCol('active');"> Approved Programs ({{ $pgmapprovel }})</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td><a href="{{ url('PGMStatus/rejectPgm') }}" class="addschem"> -- Reject All Approved
                                Programs </a></td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fa fa-spinner fa-spin"></i><a href='javascript:;' class="addschem nondon" onclick="javascript:searchCol('inactive');"> Waiting Programs({{ $pgmwaiting }})</a>
                        </td>
                        <td><a href="{{ url('PGMStatus/approvePgm') }}" class="addschem">-- Approve All Waiting
                                Programs </a></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-spinner fa-spin"></i><a href="#" class="addschem" onclick="showmer()">
                                Waiting
                                Merchants({{ $merwaiting }})</a> </td>
                        <td><a href="{{ url('PGMStatus/approveMerchants') }}" class="addschem"> -- Approve All
                                Waiting Merchants</a> ||<a href="{{ url('PGMStatus/rejectMerchants') }}" class="addschem"> Reject All Waiting
                                Merchants</a></td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-spinner fa-spin"></i><a href="#" class="addschem" onclick="showaff()">
                                Waiting Affiliates({{ $affwaiting }}) </a></td>
                        <td><a href="{{ url('PGMStatus/approveAffiliates') }}" class="addschem"> -- Approve All
                                Waiting Affiliates</a> || <a href="{{ url('PGMStatus/rejectAffiliates') }}" class="addschem">Reject All
                                Waiting
                                Affiliates</a></td>
                    </tr>
                    </thead>

            </table>
        </div>
        <div class="widget-body">
            <div>
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#">Print</a></li>
                            <li><a href="#">Save as PDF</a></li>
                            <li><a href="#">Export to Excel</a></li>
                        </ul>
                    </div>
                </div>
                <table id='PGMstatustable' class="table table-striped table-hover table-bordered" id="editable-sample">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Merchant</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Banner</th>
                            <th>Text&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Popup</th>
                            <th>Flash&nbsp;&nbsp;</th>
                            <th>Html&nbsp;&nbsp;</th>
                            <th>Template</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Program</th>
                            <th>Merchant</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Banner</th>
                            <th>Text</th>
                            <th>Popup</th>
                            <th>Flash</th>
                            <th>Html</th>
                            <th>Template</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class='row-fluid' id="waitmer">

    <!-- BEGIN EXAMPLE TABLE widget-->
    <div class="widget purple">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i> Merchants </h4>

        </div>
        <div class="widget-body">
            <div>
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#">Print</a></li>
                            <li><a href="#">Save as PDF</a></li>
                            <li><a href="#">Export to Excel</a></li>
                        </ul>
                    </div>
                </div>
                <table id='waitingtables' class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Merchant</th>
                            <th>Register</th>
                            <th>Action</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Merchant</th>
                            <th>Register</th>
                            <th>Action</th>
                            <th>Notes</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class='row-fluid' id="waitaff">

    <div class="widget purple">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i> Affiliate</h4>

        </div>
        <div class="widget-body">
            <div>
                <div class="clearfix">
                    <div class="btn-group pull-right">
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#">Print</a></li>
                            <li><a href="#">Save as PDF</a></li>
                            <li><a href="#">Export to Excel</a></li>
                        </ul>
                    </div>
                </div>
                <table id='waitingafftable' class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Affiliate</th>
                            <th>Register</th>
                            <th>Action</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Affiliate</th>
                            <th>Register</th>
                            <th>Action</th>
                            <th>Notes</th>
                        </tr>
                    </tfoot>
                </table>
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
    var ProgramURL = "{{ url('Program') }}"
    $(document).ready(function() {
        var table = '';
        var tablewait = '';
        var tablesaff = '';
        console.log('PGM Status ready');

        drawData();
        waitingMer();
        waitingAff();
        var merchantId = 0;
        var payMerchantId = 0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });


    });

    function drawData() {

        table = $('#PGMstatustable')
            .on('init.dt', function() {

                console.log('Table initialisation complete: ' + new Date().getTime());
            })
            .DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                ajax: "{{ url('PGMStatus/GetLinks') }}",

                "stateSave": true,

                columns: [{
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='icon-foursquare fa-2x fcolor'></i> <a href ='" + ProgramURL +
                                "/ProgramDetails/" + row.program_id + "'  class='addschems'>" + row
                                .program_url + "</a>";
                        }
                    },
                    {

                        data: 'merchant',

                    },
                    {

                        data: 'program_status',

                    },
                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/Product/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .prd_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/Product/" +
                                row.program_id + "/active'><span class='badge badge-info'>" + row.prd_a +
                                "</span></a>";
                        }
                    },
                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/Banner/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .banner_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/Banner/" +
                                row.program_id + "/active'><span class='badge badge-info'>" + row.banner_a +
                                "</span></a>";
                        }
                    },

                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/Text/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .text_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/Text/" + row
                                .program_id + "/active'><span class='badge badge-info'>" + row.text_a +
                                "</span></a>";
                        }
                    },

                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/Popup/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .popup_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/Popup/" +
                                row.program_id + "/active'><span class='badge badge-info'>" + row.popup_a +
                                "</span></a>";
                        }
                    },

                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/Flash/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .flash_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/Flash/" +
                                row.program_id + "/active'><span class='badge badge-info'>" + row.flash_a +
                                "</span></a>";
                        }
                    },
                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL + "/HTML/" +
                                row.program_id + "/inactive'><span class='badge badge-important'>" + row
                                .html_w + "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/HTML/" + row
                                .program_id + "/active'><span class='badge badge-info'>" + row.html_a +
                                "</span></a>";
                        }
                    },
                    {
                        "_": "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-cog fa-spin fa-2x'></i>&nbsp;&nbsp; <a href ='" +
                                ProgramURL +
                                "/TemplateText/" + row.program_id +
                                "/inactive'><span class='badge badge-important'>" + row.upload_w +
                                "</span></a>" +
                                "<br><i class='icon-ok fa-2x'></i>&nbsp; <a href ='" + ProgramURL +
                                "/TemplateText/" + row.program_id +
                                "/active'><span class='badge badge-info'>" + row.upload_a + "</span></a>";
                        }
                    },
                ],
                "order": [
                    [1, 'asc']
                ],

            });

        $('#affiliates tbody').on('click', 'tr td.affiliate-control,.affiliate-control', function() {
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
    /////////////////////////////////////////////////////////////////////////////
    function waitingMer() {

        tablewait = $("#waitingtables")
            .on("init.dt", function() {
                console.log(
                    "Table DataCountryIP complete: " + new Date().getTime()
                );
            })
            .DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"],
                ],
                ajax: "{{ url('PGMStatus/waitMerchants') }}",

                stateSave: true,
                autoWidth: false,

                columns: [{
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-spinner fa-spin fa-2x'></i>";
                        },
                    },
                    {
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return row.merchant_company;
                        },
                    },
                    {
                        _: "plain",
                        data: null,
                        render: function(row, data, type) {
                            return row.merchant_date;
                        },
                    },

                    {
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return (
                                "<a  href='javascript:;' class='btn btn-success btn-sm' onclick='javascript:approveMerchant(" +
                                row.merchant_id +
                                ")' ><i class='icon-login icon-white'></i> Approve</a> "
                            );
                        },
                    },
                    {

                        data: "merchant_id",
                        render: function(data, type) {

                            return "<a class='btn btn-primary' href='Merchant/Login/" + data +
                                "'>Login</a>";
                        },
                    },
                ],
                order: [
                    [1, "asc"]
                ],
            });
        $("#waitmer").hide();
        $("#waitaff").hide();
    }

    function showmer() {
        $("#waitmer").show();
        $("#pgmstatus").hide();
        $("#waitaff").hide();
    }
    ///////////////////////////////////////////////////

    function searchCol(value) {
        $('#PGMstatustable').DataTable().search(value, false, true)
            .draw();
    }

    function waitingAff() {

        tablesaff = $("#waitingafftable")
            .on("init.dt", function() {
                console.log(
                    "Table DataCountryIP complete: " + new Date().getTime()
                );
            })
            .DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"],
                ],
                ajax: "{{ url('PGMStatus/waitAffiliate') }}",

                stateSave: true,
                autoWidth: false,

                columns: [{
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return "<i class='fa fa-spinner fa-spin fa-2x'></i>";
                        },
                    },
                    {
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return row.affiliate_company;
                        },
                    },
                    {
                        _: "plain",
                        data: null,
                        render: function(row, data, type) {
                            return row.affiliate_date;
                        },
                    },

                    {
                        _: "plain",
                        data: null,
                        render: function(data, type, row) {
                            return (
                                "<a  href='javascript:;' class='editAdminuser btn btn-success btn-sm' onclick='javascript:approveAffiliate(" +
                                row.affiliate_id +
                                ")' ><i class='icon-login icon-white'></i> Approve</a> "
                            );
                        },
                    },
                    {
                        data: "affiliate_id",
                        render: function(data, type) {
                            return "<a class='btn btn-primary' href='Affiliate/Login/" + data +
                                "'>Login</a>";
                        },
                    },
                ],
                order: [
                    [1, "asc"]
                ],
            });
        $("#waitaff").hide();
        $("#waitmer").hide();
    }

    function showaff() {
        $("#waitaff").show();
        $("#pgmstatus").hide();
        $("#waitmer").hide();
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
                tablesaff.ajax.reload();

                successSound.play();
                Command: toastr["success"]("Successfully Affiliate Approved ",
                    "Success")

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error Approving Affiliate")

            }

        });

    }

    function approveMerchant(id) {
        console.log(id);
        let _token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ url('Merchant/ApproveMerchant') }}",
            data: {
                id: id,
            },
            _token: _token,

        }).done(function(data) {
            console.log(data);
            if (data == 1) {
                tablewait.ajax.reload();

                successSound.play();
                Command: toastr["success"]("Merchant Approved", "Success")

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error Approving Merchant")

            }

        });

    }
</script>




<style>
    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
        cursor: pointer;
    }

    .fcolor {
        color: grey;
    }

    .addschem {
        text-decoration: none;
        font-size: 16px;
        font-family: cambria;
        color: grey;
        font-weight: bold;
    }

    .addschems {
        text-decoration: none;
        font-size: 16px;
        font-family: cambria;
        color: grey;
        font-weight: bold;
    }
</style>
@endsection
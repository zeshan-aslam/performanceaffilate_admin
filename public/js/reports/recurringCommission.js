var RecurringTable;
var pendingTable;
var approvedTable;
$('select[name=RCType] , select[name=RCMerchant]').on('change', function() {
    var RCType = $('select[name=RCType]').val();
    var RCMerchant = $('select[name=RCMerchant]').val();


    console.log("Merchant = " + RCMerchant + " Type = " + RCType);
    console.log(RCType);
    if (RCType == 'Recurring') {
        $("#pending").hide();
        $('#approved').hide();
        $('#Recurring').show();
        let _token = $('#tokenRecurring').val();
        let _url = getUrl()+"/GetRecurringData";
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
                var len = 0;
                var tag = '';
                RecurringTable = $('#RecurringTable')
                    .on('init.dt', function() {

                        console.log(
                            'Recurring Table initialisation complete: ' +
                            new Date().getTime());
                    })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],



                    "stateSave": true,
                    "bDestroy": true,

                    data: response['Transaction'],
                    columns: [{
                            "class": "affiliate-control",
                            "_": "plain",
                            data: null,
                            render: function(row, data, type) {
                                return "<a href ='javascript:;' >" +
                                    row.affiliate_firstname + " " +
                                    row.affiliate_lastname + "</a>";
                            },
                        },
                        {
                            data: 'transaction_dateoftransaction',
                        },


                        {
                            data: 'transaction_amttobepaid',
                        },

                        {
                            data: 'transaction_orderid',

                        },
                        {
                            data: 'recur_status',
                            render: function(data, type) {
                                if (type === 'display') {
                                    if (data == 'lead')
                                        return "<span class='label label-info'>Lead</span>";
                                    else if (data == 'impression')
                                        return "<span class='label label-success'>Impression</span>";
                                    else if (data == 'sale')
                                        return "<span class='label label-warning'>Sale</span>";
                                    else if (data == 'click')
                                        return "<span class='label label-important'>Click</span>";



                                }

                                return data;
                            }
                        },
                        {
                            data: 'transaction_id',
                        },



                    ],
                    "order": [
                        [1, 'asc']
                    ]
                });




            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Recurring Commission Error : " + thrownError);

            },
        });

    }

    if (RCType == 'pending') {


        let _token = $('#tokenRecurring').val();
        let _url = getUrl()+"/GetRecurringData";
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

                pendingTable = $('#pendingTable')
                    .on('init.dt', function() {

                        console.log(
                            'Pending Table initialisation complete: ' +
                            new Date().getTime());
                    })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],



                    "stateSave": true,
                    "bDestroy": true,

                    data: response['pending'],
                    columns: [

                        {
                            "class": "affiliate-control",
                            "_": "plain",
                            data: null,
                            render: function(row, data, type) {
                                return "<a href ='javascript:;' >" +
                                    row.affiliate_firstname + " " +
                                    row.affiliate_lastname + "</a>";
                            },
                        },
                        {
                            data: 'recurpayments_date',
                        },


                        {
                            data: 'recurpayments_amount',
                        },

                        {
                            data: 'transaction_orderid',

                        },

                        {
                            "_": 'plain',
                            data: null,
                            render: function(row, data, type) {
                                return "<a href ='javascript:;' >View</a>";
                            },
                        },



                    ],
                    "order": [
                        [1, 'asc']
                    ]
                });






            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error in Pending Commission Table : " + thrownError);

            },
        });


        $("#pending").show();
        $('#approved').hide();
        $('#Recurring').hide();

    }
    if (RCType == 'approved') {



        let _token = $('#tokenRecurring').val();
        let _url = getUrl()+"/GetRecurringData";
        $.ajax({
            url: GetRecurringDataURL,
            data: {
                merchant: RCMerchant,
                rcType: RCType,
            },
            _token: _token,
            type: "POST",
            success: function(response) {
                console.log(response);

                approvedTable = $('#approvedTable')
                    .on('init.dt', function() {

                        console.log(
                            'approved Table initialisation complete: ' +
                            new Date().getTime());
                    })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],



                    "stateSave": true,
                    "bDestroy": true,

                    data: response['approved'],
                    columns: [

                        {
                            "class": "affiliate-control",
                            "_": "plain",
                            data: null,
                            render: function(data, type,row) {
                                return "<a href ='javascript:;' >" +
                                    row.affiliate_firstname + " " +
                                    row.affiliate_lastname + "</a>";
                            },
                        },
                        {
                            data: 'recurpayments_date',
                        },


                        {
                            data: 'recurpayments_amount',
                        },

                        {
                            data: 'transaction_orderid',

                        },

                        {
                            "_": 'plain',
                            data: null,
                            render: function(row, data, type) {
                                return "<a href ='javascript:;' >View</a>";
                            },
                        },



                    ],
                    "order": [
                        [1, 'asc']
                    ]
                });






            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error in Approved Commission Table = " + thrownError);

            },
        });



        $("#pending").hide();
        $('#approved').show();
        $('#Recurring').hide();
    }





});

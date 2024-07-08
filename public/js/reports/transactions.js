var transTable;


function getTransaction() {

    var click = lead = impression = sale = '';
    let From = $("input[name=From]").val();
    let To = $("input[name=To]").val();
    let Affiliate = $("select[name=Affiliate]").val();
    let Merchant = $("select[name=Merchant]").val();
    let _token = $('#token').val();
    if ($("input[name=Click]").is(":checked")) {
        click = $("input[name=Click]").val();
    } else {
        click = "";

    }
    if ($("input[name=Lead]").is(":checked")) {
        lead = $("input[name=Lead]").val();
    } else {
        lead = "";

    }
    if ($("input[name=Sale]").is(":checked")) {
        sale = $("input[name=Sale]").val();
    } else {
        sale = "";

    }
    if ($("input[name=Impression]").is(":checked")) {
        impression = $("input[name=Impression]").val();
    } else {
        impression = "";

    }
    let Click = click;
    let Lead = lead;
    let Impression = impression;
    let Sale = sale;
    let _url = getUrl()+"/GetTransactionData";
    $.ajax({
        url: GetTransactionDataURL,
        data: {
            From: From,
            To: To,
            Affiliate: Affiliate,
            Merchant: Merchant,
            Click: Click,
            Lead: Lead,
            Impression: Impression,
            Sale: Sale
        },
        _token: _token,
        type: "POST",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError);

        },
    }).done(function(response) {

        console.log(response);
        transTable = $('#transTable')
            .on('init.dt', function() {

                console.log('Transaction Table initialisation complete: ' + new Date().getTime());
            })


        .DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],



            "stateSave": true,
            "bDestroy": true,

            data: response,
            columns: [{
                    data: 'transaction_id',
                },
                {
                    data: 'transaction_type',
                    render: function(data, type) {
                        if (type === 'display') {
                            if (data == 'impression')
                                return "<span class='label label-success'>Impression</span>";
                            else if (data == 'sale')
                                return "<span class='label label-warning'>Sale</span>";
                            else if (data == 'click')
                                return "<span class='label label-important'>Click</span>";
                            else if (data == 'lead')
                                return "<span class='label label-info'>Lead</span>";


                        }

                        return data;
                    }
                },
                {
                    "class": "merchant-control",
                    "_": "plain",
                    data: null,
                    render: function(data, type,row) {
                        return "<a href ='javascript:;'>" + row.merchant_company + "</a>";
                    },
                },
                {
                    "class": "affiliate-control",
                    "_": "plain",
                    data: null,
                    render: function(data, type,row) {
                        return "<a href ='javascript:;' >" + row.affiliate_company + "</a>";
                    },
                },
                {
                    data: 'transaction_amttobepaid',
                },
                {
                    data: 'transaction_dateoftransaction',
                },
                {
                    data: 'transaction_referer',
                    render: function(data, type) {


                        return "<a href='" + data + "' target='_blank'>" + data + "</a>";
                    }
                },
                {
                    data: 'transaction_status',
                    render: function(data, type) {
                        if (type === 'display') {
                            if (data == 'reversed')
                                return "<span class='label label-inverse'>Reversed</span>";
                            else if (data == 'approved')
                                return "<span class='label label-success'>Approved</span>";
                            else if (data == 'reverserequest')
                                return "<span class='label label-warning'>Reverserequest</span>";
                            else if (data == 'pending')
                                return "<span class='label label-important'>Pending</span>";



                        }

                        return data;
                    }
                },



            ],
            "order": [
                [1, 'asc']
            ]
        });
    });

}
// Array to track the ids of the details displayed rows
var detailRows = [];

$('#transTable tbody ').on('click', 'tr td.merchant-control', function() {
    var tr = $(this).closest('tr');
    var row = transTable.row(tr);
    formatMerchant(row.data());
});
$('#transTable tbody ').on('click', 'tr td.affiliate-control', function() {
    var tr = $(this).closest('tr');
    var row = transTable.row(tr);
    formatAffiliate(row.data());

});

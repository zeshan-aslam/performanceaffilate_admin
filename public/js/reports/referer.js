var refererTable;

function getReferer() {


    var click = lead = impression = sale = '';
    let From = $("input[name=refererFrom]").val();
    let To = $("input[name=refererTo]").val();
    let Program = $("select[name=refererProgram]").val();
    let Merchant = $("select[name=refererMerchant]").val();
    let _token = $('#refererToken').val();
    if ($("input[name=refererClick]").is(":checked")) {
        click = $("input[name=refererClick]").val();
    } else {
        click = "";

    }
    if ($("input[name=refererLead]").is(":checked")) {
        lead = $("input[name=refererLead]").val();
    } else {
        lead = "";

    }
    if ($("input[name=refererSale]").is(":checked")) {
        sale = $("input[name=refererSale]").val();
    } else {
        sale = "";

    }
    if ($("input[name=refererImpression]").is(":checked")) {
        impression = $("input[name=refererImpression]").val();
    } else {
        impression = "";

    }
    let Click = click;
    let Lead = lead;
    let Impression = impression;
    let Sale = sale;

    console.log("Program = " + Program + " Merchant = " + Merchant + " Click = " + Click + " Lead = " + Lead +
        " Impression = " + Impression + " Sale = " + Sale);


    let _url = getUrl()+"/GetRefererData";
    $.ajax({
        url: GetRefererDataURL,
        data: {
            From: From,
            To: To,
            Program: Program,
            Merchant: Merchant,
            Click: Click,
            Lead: Lead,
            Impression: Impression,
            Sale: Sale
        },
        _token: _token,
        type: "POST",
        success: function(response) {
            console.log(response);



        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError);

        },
    }).done(function(response) {
        console.log(response);
        refererTable = $('#refererTable')
            .on('init.dt', function() {

                console.log('Referer Table initialisation complete: ' + new Date().getTime());
            })


        .DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],



            "stateSave": true,
            "bDestroy": true,

            data: response['data'],
            columns: [{
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
                    "class": "affiliate-control",
                    "_": "plain",
                    data: null,
                    render: function(row, data, type) {
                        return "<a href ='javascript:;'>" + row.affiliate_company + "</a>";
                    },
                },
                {
                    data: 'transaction_referer',
                    render: function(data, type) {


                        return "<a href='" + data + "' target='_blank'>" + data + "</a>";
                    }
                },
                {
                    data: 'transaction_ip',
                },
                {
                    data: 'transDate',
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

$('#refererTable tbody').on('click', 'tr td.affiliate-control', function() {
    var tr = $(this).closest('tr');
    var row = refererTable.row(tr);
    formatAffiliate(row.data());

});

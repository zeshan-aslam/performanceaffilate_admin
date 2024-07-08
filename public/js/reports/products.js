var productsTable;



function getProducts() {

    var click = lead = sale = '';
    let From = $("input[name=productsFrom]").val();
    let To = $("input[name=productsTo]").val();
    let Program = $("select[name=productsProgram]").val();
    let Merchant = $("select[name=productsMerchant]").val();
    let _token = $('#productsToken').val();
    if ($("input[name=productsClick]").is(":checked")) {
        click = $("input[name=productsClick]").val();
    } else {
        click = "";

    }
    if ($("input[name=productsLead]").is(":checked")) {
        lead = $("input[name=productsLead]").val();
    } else {
        lead = "";

    }
    if ($("input[name=productsSale]").is(":checked")) {
        sale = $("input[name=productsSale]").val();
    } else {
        sale = "";

    }

    let Click = click;
    let Lead = lead;
    let Sale = sale;
    let _url = getUrl()+"/GetProductsData";
    $.ajax({
        url: GetProductsDataURL,
        data: {
            From: From,
            To: To,
            Program: Program,
            Merchant: Merchant,
            Click: Click,
            Lead: Lead,
            Sale: Sale
        },
        _token: _token,
        type: "POST",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Products Error : ' + thrownError)

        },
    }).done(function(response) {
        console.log("Products Response ");
        console.log(response);

        productsTable = $('#productsTable')
            .on('init.dt', function() {

                console.log('products Table initialisation complete: ' + new Date().getTime());
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
                    data: 'prd_product',
                },

                {
                    "class": "affiliate-control",
                    "_": "plain",
                    data: null,
                    render: function(row, data, type) {
                        return "<a href ='javascript:;' >" + row.affiliate_company + "</a>";
                    },
                },
                {
                    data: 'transaction_admin_amount',
                },
                {
                    data: 'transaction_dateoftransaction',
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

$('#productsTable tbody ').on('click', 'tr td.merchant-control', function() {
    var tr = $(this).closest('tr');
    var row = transTable.row(tr);
    formatMerchant(row.data());


});
$('#productsTable tbody ,#refererTable tbody').on('click', 'tr td.affiliate-control', function() {
    var tr = $(this).closest('tr');
    var row = transTable.row(tr);
    formatAffiliate(row.data());

});

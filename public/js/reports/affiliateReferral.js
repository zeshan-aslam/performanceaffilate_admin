var affRefrralTable;


function getAffiliateReferral() {




    let _token = $('#tokenAfReferral').val();
    let _url =getUrl()+"/GetAffiliateReferralData";
    $.ajax({
        url: GetAffiliateReferralDataURL,
        data: {

        },
        _token: _token,
        type: "POST",
        success: function(data) {
            console.log("Affiliate Referral Response : ");
            console.log(data);
            affRefrralTable = $('#afReferralTable')
                .on('init.dt', function() {

                    console.log(
                        'Affiliate Referral Table initialisation complete: ' +
                        new Date().getTime());
                })


            .DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],



                "stateSave": true,
                "bDestroy": true,
                'autoWidth':false,



                data: data,
                columns: [{
                        "class": "affiliate-referral",
                        "_": "plain",
                        data: null,
                        render: function(row, data, type) {
                            return row.affiliate_firstname + " " +  row.affiliate_lastname ;
                        },
                    },
                    {
                        data: 'affiliate_date',
                    },


                    {
                        data: 'referralCount',
                        render: function(data, type,row) {
                            return "<span class='badge bg-info'>"+data+"</span>";
                        },
                    },
                    {
                        "class": "affiliate-parent",
                        "_": "plain",
                        data: null,
                        render: function(data, type,row) {
                            return row.pA_name +" "+ row.pL_name;
                        },
                    },





                ],
                "order": [
                    [1, 'asc']
                ]
            });





        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("Error in Affiliate Referrals : " + thrownError);


        },
    });
}



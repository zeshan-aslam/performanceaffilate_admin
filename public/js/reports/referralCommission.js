function getReferralCommission() {



    let From = $("input[name=referralFrom]").val();
    let To = $("input[name=referralTo]").val();

    let _token = $('#tokenRefCommission').val();


    let _url = getUrl()+"/GetReferralCommissionData";
    $.ajax({
        url: GetReferralCommissionDataURL,
        data: {
            From: From,
            To: To,

        },
        _token: _token,
        type: "POST",
        success: function(response) {
            console.log("Referral Commission = ");
            console.log(response);
            RefCommissionTable = $('#RefCommissionTable')
                .on('init.dt', function() {

                    console.log('Referral Commission Table initialisation complete: ' + new Date().getTime());
                })


            .DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],



                "stateSave": true,
                "bDestroy": true,
                'autoWidth':false,

                data: response,
                columns: [{
                       "_":'plain',
                        data: null,
                        render:function(data,type, row){
                            return "<a href='#affModelprofile" + row.affiliate_id +
                            "' role='button'data-toggle='modal'>" + row.affiliate_company + "</a>";
                        }
                    },
                    {
                        data: 'subsale_id_count',
                    },
                    {
                        data: 'subsale_amount_sum',
                    },

                    {
                        "_":'plain',
                         data: null,
                         render:function(data,type, row){
                             return "<a href='" +SaleURL+ "/"+row.affiliate_id +
                             "' class='btn btn-success'>View</a>";
                         }
                     },




                ],
                "order": [
                    [1, 'asc']
                ]
            });


                }

    });
}

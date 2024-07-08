var res = [];
function getLink() {
    let MerchantLink = $("select[name=MerchantLink]").val();
    let Program = $("select[name=ProgramLink]").val();
    let To = $("input[name=FromLink]").val();
    let From = $("input[name=ToLink]").val();

    console.log("Merchant = " + MerchantLink);
    console.log("Program = " + Program);
    console.log("From = " + From);
    console.log("To = " + To);

    let _token = $('#tokenLink').val();


    // let _url = getUrl()+"/GetLinkData";
    $.ajax({
        url: GetLinkDataURL,
        data: {

            program: Program,
            merchant: MerchantLink,
            to: To,
            from: From,
        },
        _token: _token,
        type: "POST",
        success: function(response) {
            console.log(response); 
            res=response;
            console.log(res);
             
            if (response) {
                $(".pagination ul").empty();
                $('#pendingLink').html(response['Banner'][0]['pendingamnt']);
                $('#reversedLink').html(response['Banner']['rejectedamnt']);
                $('#impressionLink').html(0);

                $('#nClickLink').html(response['Banner'][0]['nClick']);
                $('#nLeadLink').html(response['Banner'][0]['nLead']);
                $('#nSaleLink').html(response['Banner'][0]['nSale']);
                $('#nImpressionLink').html(response['Banner'][0]['nImpression']);
                $('#clickCommissionLink').html(response['Banner'][0]['clickCommission']);
                $('#leadCommissionLink').html(response['Banner'][0]['leadCommission']);
                $('#saleCommissionLink').html(response['Banner'][0]['saleCommission']);
                $('#impressionCommissionLink').html(response['Banner'][0][
                    'impressionCommission'
                ]);
                console.log(response['Banner'][0]);
                for( var $i=0; $i<response['Banner'].length;$i++)
                {      
                     console.log($i);
                    $(".custom_pagination ul").append(
                      '<li><a href="javascript:;" onclick="Count('+$i+')">'+($i+1)+'</a></li>'
                    );
                }

            } else {
                console.log(response);
                $('#pendingLink').html('NULL');
                $('#reversedLink').html('NULL');
                $('#impressionLink').html('NULL');

                $('#nClickLink').html('NULL');
                $('#nLeadLink').html('NULL');
                $('#nSaleLink').html('NULL');
                $('#nImpressionLink').html('NULL');
                $('#clickCommissionLink').html('NULL');
                $('#leadCommissionLink').html('NULL');
                $('#saleCommissionLink').html('NULL');
                $('#impressionCommissionLink').html('NULL');
            }


        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("No Data Found in Links");

        },



        //   Success end

    });

}
function Count(count){
    console.log(res);

    if(res['Banner'])
    {     let id = res['Banner'][count]['linkid'].slice(1,2);
        $('#banner').css('display','block');
        $('#banner').val(id);
    }
    if (res) {
        $('#pendingLink').html(res['Banner'][count]['pendingamnt']);
        $('#reversedLink').html(res['Banner'][count]['rejectedamnt']);
        $('#impressionLink').html(0);

        $('#nClickLink').html(res['Banner'][count]['nClick']);
        $('#nLeadLink').html(res['Banner'][count]['nLead']);
        $('#nSaleLink').html(res['Banner'][count]['nSale']);
        $('#nImpressionLink').html(res['Banner'][count]['nImpression']);
        $('#clickCommissionLink').html(res['Banner'][count]['clickCommission']);
        $('#leadCommissionLink').html(res['Banner'][count]['leadCommission']);
        $('#saleCommissionLink').html(res['Banner'][count]['saleCommission']);
        $('#impressionCommissionLink').html(res['Banner'][count][
            'impressionCommission'
        ]);
        console.log(res['Banner'][count]);

    } else {
        console.log(res);
        $('#pendingLink').html('NULL');
        $('#reversedLink').html('NULL');
        $('#impressionLink').html('NULL');

        $('#nClickLink').html('NULL');
        $('#nLeadLink').html('NULL');
        $('#nSaleLink').html('NULL');
        $('#nImpressionLink').html('NULL');
        $('#clickCommissionLink').html('NULL');
        $('#leadCommissionLink').html('NULL');
        $('#saleCommissionLink').html('NULL');
        $('#impressionCommissionLink').html('NULL');
    }

}
function ViewModal(){
   id =  $('#banner').val();
//    alert(id);
   $.ajax({
       url:"Report/BannerDisplay",
       type:"get",
       data:{id:id},
       dataType:'Json',  
       success: function(response) 
       {
        console.log(response);
        
        Swal.fire({
            title: '<strong style="font-family:cambria; color:orange">Banner Display </strong>',
            html: "<div class='form-horizontal'>" +
                "<div class='control-group text-center'>" +
                
                "  <img src='"+response.banner_name+"'/>" +
               
                "</div>" +
                "</div>",
            confirmButtonText: 'ok',
            focusConfirm: false,
            showCloseButton: true,
            
        });
       }
       
   });
}


function updateMerchantTerms()
{
   var merchantTerms=$('textarea[name=merchantTerms]').val();
   let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdateMerchantTerms';

   $.ajax({
       url: UpdateMerchantTermsURL,
       data: {
        merchantTerms:merchantTerms,

       },
       _token: _token,
       type: "POST",
   }).done(function(response) {
       console.log('Merchant Terms Rsponse = ', response);
       if (response == 1) {
           gateWaysTable.ajax.reload();
           successSound.play();
           Command: toastr["success"]("Merchant Terms Updated successfully", "Success");


       } else if (response == 0) {
           errorSound.play();
           Command: toastr["error"](" ", "Please Modify something");

       } else {
           errorSound.play();
           Command: toastr["error"](" ", "Error in Updating Merchant Terms");

       }


   }).fail(function(xhr, ajaxOptions, thrownError){
            console.log('Error in Updating Merchant Terms = ' + thrownError);
   });

}

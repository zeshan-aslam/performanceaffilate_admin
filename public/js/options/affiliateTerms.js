function updateAffiliateTerms()
{
   var affiliateTerms=$('textarea[name=affiliateTerms]').val();
   let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdateAffiliateTerms';

   $.ajax({
       url: UpdateAffiliateTermsURL,
       data: {
        affiliateTerms:affiliateTerms,

       },
       _token: _token,
       type: "POST",
   }).done(function(response) {
       console.log('Fraudsettings Rsponse = ', response);
       if (response == 1) {
           gateWaysTable.ajax.reload();
           successSound.play();
           Command: toastr["success"]("Affiliate Terms Updated successfully", "Success");


       } else if (response == 0) {
           errorSound.play();
           Command: toastr["error"](" ", "Please Modify something");

       } else {
           errorSound.play();
           Command: toastr["error"](" ", "Error in Updating Affiliate Terms");

       }


   }).fail(function(xhr, ajaxOptions, thrownError){
            console.log('Error in Updating Affiliate Terms = ' + thrownError);
   });

}

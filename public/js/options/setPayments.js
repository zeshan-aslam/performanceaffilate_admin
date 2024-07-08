

function validate(key){


}
function updatesiteNormalUser(key) {
    var value = '';
    var notify = '';
    var Error='';
    value = $('input[name=siteNormalUser]').val();

    notify = 'Normal User Amount ';
    if(value==''){
        Error='Please input Amount';
         $('span.siteNormalUserErr').html(Error);
    }
    else{
        update(key,value,notify)
    }

}
function updatesiteAdvancedUser(key) {
    var value = '';
    var notify = '';
    var Error='';
    notify = 'Advanced User Amount ';
    value = $('input[name=siteAdvancedUser]').val();
    if(value==''){
        Error='Please input Amount';
        $('span.siteAdvancedUserErr').html(Error);
    }
    else{
        update(key,value,notify)
    }



}
function updatesiteMinAmount(key) {
    var value = '';
    var notify = '';
    var Error='';
      value = $('input[name=siteMinAmount]').val();
    notify = 'Min Amount ';
        if(value==''){
            Error='Please input Amount';
          $('span.siteMinAmountErr').html(Error);
        }
        else{
            $('span.siteMinAmountErr').html('');
            update(key,value,notify)
        }

}

function updateProgram(key) {
    const valueArr = [];
    const keyArr = [];
    var notify = '';
    var Error='';

    if ($('input[name=siteProgramType]:checked').val() == 1) {

        keyArr[0] = 'siteProgramFee';
        keyArr[1] = 'siteProgramType';
        notify = 'Program Type ';
        valueArr[0] = $('input[name=siteProgramFee]').val();
        valueArr[1] = 1;
        if(valueArr[0]==''){
            Error='Please input Amount';
            $('span.siteProgramFeeErr').html(Error);
        }
        else{
            $('span.siteProgramFeeErr').html('');
            update(keyArr,valueArr,notify);
        }


    } else if ($('input[name=siteProgramType]:checked').val() == 2) {
        notify = 'Program Type with Value';
        keyArr[0] = 'siteProgramType';
        keyArr[1] = 'siteProgramFee';
        keyArr[2] = 'siteProgramValue';

        valueArr[0] = 2;
        valueArr[1] = $('input[name=siteProgramFee]').val();
        if(valueArr[1]==''){
            Error='Please input Amount';
           $('span.siteProgramFeeErr').html(Error);
        }
        else{
            $('span.siteProgramFeeErr').html('');
           
        }
        valueArr[2] = $('input[name=siteProgramValue]').val();
        if(valueArr[2]==''){
            Error='Please input Period';
           $('span.siteProgramValueErr').html(Error);
        }
        else{
            $('span.siteProgramValueErr').html('');
        }
        valueArr[2] = valueArr[2] + " " + $('select[name=siteProgramPeriod]').val();
        if (Error=='') {
              update(keyArr,valueArr,notify);
        }
        else{
            errorSound.play();
        }

    }

}
function updatesiteMembType(key) {
    const valueArr = [];
    const keyArr = [];
    var notify = '';
    var Error='';

    notify = 'Member Type ';
    if ($('input[name=siteMembType]:checked').val() == 1) {
        keyArr[0]='siteMembType';
        valueArr[0] =1;
        update(keyArr,valueArr,notify);

    } else if ($('input[name=siteMembType]:checked').val() == 2) {
        keyArr[0]='siteMembType';
        valueArr[0] =2;
        keyArr[1]='siteMembValue';
       
        valueArr[1] = $('input[name=siteMembValue] ').val();

        notify = 'Member Type with Value';
        if( valueArr[1]==''){
            Error='Please input Amount';
           $('span.siteMembValueErr').html(Error);
        }
        else{
            valueArr[1] = valueArr[1] + " " + $('select[name=siteMembPeriod]').val();
            update(keyArr,valueArr,notify);
        }

    
           }
}

function updatesiteAdminClickRate(key) {
    const valueArr = [];
    const keyArr = [];
    var value = '';
    var    notify = 'Admin Click Rate ';
    var Error='';
    keyArr[0] = 'siteAdminClickRate';
    keyArr[1] = 'siteAdminClickRateType';
    valueArr[0] = $('input[name=siteAdminClickRate]').val();
    valueArr[1] = $('input[name=siteAdminClickRateType]:checked').val();
   
    value=valueArr[0];
    if(value==''){
        Error='Please input Amount';
     $('span.siteAdminClickRateErr').html(Error);
    }
    else{

        $('span.siteAdminClickRateErr').html('');
        update(keyArr,valueArr,notify);
    }


}
function updatesiteAdminSaleRate(key) {
    const valueArr = [];
    const keyArr = [];
    var value = '';
    var   notify = 'Admin Sale Rate ';
    var Error='';
    keyArr[0] = 'siteAdminSaleRate';
    keyArr[1] = 'siteAdminSaleRateType';
    valueArr[0] = $('input[name=siteAdminSaleRate]').val();
    valueArr[1] = $('input[name=siteAdminSaleRateType]:checked').val();
    value=valueArr[0];
    if(value==''){
        Error='Please input Amount';
     $('span.siteAdminSaleRateErr').html(Error);
    }
    else{

        $('span.siteAdminSaleRateErr').html('');
        update(keyArr,valueArr,notify);
    }



}
function updatesiteAdminLeadRate(key) {
    const valueArr = [];
    const keyArr = [];
    var value = '';
    var notify = '';
    var Error='';
    keyArr[0] = 'siteAdminLeadRate';
    keyArr[1] = 'siteAdminLeadRateType';
    valueArr[0] = $('input[name=siteAdminLeadRate]').val();
    valueArr[1] = $('input[name=siteAdminLeadRateType]:checked').val();

    notify = 'Admin Lead Rate ';
    value=valueArr[0];
    if(value==''){
        Error='Please input Amount';
     $('span.siteAdminLeadRateErr').html(Error);
    }
    else{

        $('span.siteAdminLeadRateErr').html('');
        update(keyArr,valueArr,notify);
    }
}
function updatesiteImpRate(key) {
    var value = '';
    var notify = 'Admin Impression  Rate ';
    var Error='';
    value = $('input[name=siteImpRate]').val();
    if(value==''){
        Error='Please input Amount';
       $('span.siteImpRateErr').html(Error);
    }
    else{

        $('span.siteImpRateErr').html('');
        update(key,value,notify);
    }

}

function updatesiteMinWithdrawAmount(key) {
    var value = '';
    var notify = '';
    var Error='';
    notify = 'Min  Withdraw Amount ';
    value = $('input[name=siteMinWithdrawAmount]').val();
    if(value==''){
        Error='Please input Amount';
       $('span.siteMinWithdrawAmountErr').html(Error);
    }

    else{
        $('span.siteMinWithdrawAmountErr').html('');
        update(key,value,notify);
    }

}
function updatesiteMerchantMaxAmount(key) {
    var value = '';
    var  notify = 'Merchant Max Amount ';
    var Error='';
    value = $('input[name=siteMerchantMaxAmount]').val();
    if(value==''){
        Error='Please input Amount';
       $('span.siteMerchantMaxAmountErr').html(Error);
    }

    else{
        $('span.siteMerchantMaxAmountErr').html('');
        update(key,value,notify);
    }

}
function updatesiteAffiliateMaxAmount(key) {
    var value = '';
    var notify = '';
    var Error='';
    value = $('input[name=siteAffiliateMaxAmount]').val();
    notify = 'Affiliate Max Amount ';
    if(value==''){
        Error='Please input Amount';
       $('span.siteAffiliateMaxAmountErr').html(Error);
    }
    else{
        $('span.siteAffiliateMaxAmountErr').html('');
        update(key,value,notify);
    }

}


function updatesiteAdminMaxAmount(key) {
    var value = '';
    var Error='';
    notify = 'Admin Max Amount ';
    value = $('input[name=siteAdminMaxAmount]').val();
    if(value==''){
        Error='Please input Amount';
       $('span.siteAdminMaxAmountErr').html(Error);
    }

    else{
        $('span.siteAdminMaxAmountErr').html('');
        update(key,value,notify);
    }

}



function updateAmount(key) {


    var value = '';
    var notify = '';
    var Error='';
    const valueArr = [];
    const keyArr = [];
    if (key == 'siteNormalUser') {


    } else
    if (key == 'siteAdvancedUser') {

    } else if (key == 'siteMinAmount') {

    } else if (key == 'siteProgramFee') {

    } else if (key == 'siteAdminClickRate') {

    } else if (key == 'siteAdminSaleRate') {

    } else if (key == 'siteAdminLeadRate') {

    } else if (key == 'siteImpRate') {

    } else if (key == 'siteMinWithdrawAmount') {

    } else if (key == 'siteMerchantMaxAmount') {

    } else if (key == 'siteAffiliateMaxAmount') {

    } else if (key == 'siteAdminMaxAmount') {

    } else if (key == 'siteMembType') {


    } else if (key == 'siteProgramType') {



    }

    console.log('Values ', value);
    console.log('Keys ', key);

    if(!Error==''){

    }
    else{
        update(key,value.notify);
    }

}


function update(key ,value, notify){
    console.log('Keys',key);
    console.log('Values',value);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdatePayments';
    $.ajax({
        url: UpdatePaymentsURL,
        data: {
            key: key,
            value: value,

        },
        _token: _token,
        type: "POST",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert('Error in Updating Site Constants =' + thrownError);

        },
    }).done(function(response) {
        console.log('Constant Update Rsponse = ', response);
        if (response == 1) {

            successSound.play();
            Command: toastr["success"](notify + "Updated successfully", "Success")

        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Please Modify something in " + notify);

        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in Updating " + notify);

        }


    });
}

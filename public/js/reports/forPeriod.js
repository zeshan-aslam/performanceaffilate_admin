function getForPeriod() {
    //    alert(calander.getSelectedDate());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let Merchant = $("select[name=forPeriodMerchant]").val();
    let Affiliate = $("select[name=forPeriodAffiliate]").val();
    let From = $("input[name=forPeriodFrom]").val();
    let To = $("input[name=forPeriodTo]").val();

    console.log("Merchant = " + Merchant);
    console.log("Affiliate = " + Affiliate);

    let _token = $('#tokenForPeriod').val();


    let _url = getUrl()+"/GetForPeriodData";
    $.ajax({
        url: GetForPeriodDataURL,
        data: {
            from: From,
            to: To,
            affiliate: Affiliate,
            merchant: Merchant,


        },
        _token: _token,
        type: "POST",
        success: function(response) {
            if (response) {
                $('#forPeriodReversed').html(response['rejectedamnt']);
                $('#forPeriodPending').html(response['pendingamnt']);
                $('#forPeriodImpressions').html(response['rawImp']);
                $('#forPeriodnClick').html(response['nClick']);
                $('#forPeriodnLead').html(response['nLead']);
                $('#forPeriodnSale').html(response['nSale']);
                $('#forPeriodnImpression').html(response['nImpression']);
                $('#forPeriodclickCommission').html(response['clickCommission']);
                $('#forPeriodleadCommission').html(response['leadCommission']);
                $('#forPeriodsaleCommission').html(response['saleCommission']);
                $('#forPeriodimpressionCommission').html(response['impressionCommission']);
                console.log(response);

            } else {
                console.log(response);
                $('#forPeriodReversed').html('NULL');
                $('#forPeriodPending').html('NULL');
                $('#forPeriodImpressions').html('NULL');
                $('#forPeriodnClick').html('NULL');
                $('#forPeriodnLead').html('NULL');
                $('#forPeriodnSale').html('NULL');
                $('#forPeriodnImpression').html('NULL');
                $('#forPeriodclickCommission').html('NULL');
                $('#forPeriodleadCommission').html('NULL');
                $('#forPeriodsaleCommission').html('NULL');
                $('#forPeriodimpressionCommission').html('NULL');
            }


        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("No Data For Period");

        },



        //   Success end

    });
    /////////
}

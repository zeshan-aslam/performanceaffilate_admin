function getDaily() {
    //    alert(calander.getSelectedDate());

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const m = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    const dateArray = [
        "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12",
        "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24",
        "25", "26", "27", "28", "29", "30", "31",
    ];

    const d = calander.getSelectedDate();
    let date = dateArray[d.getDate() - 1];
    let month = m[d.getMonth()];
    let year = d.getFullYear();
    dateToPass = year + "-" + month + "-" + date;
    console.log("Date To Pass = " + dateToPass);

    let Merchant = $("select[name=MerchantDaily]").val();
    let Affiliate = $("select[name=AffiliateDaily]").val();
    dateDaily = dateToPass
    console.log("Merchant = " + Merchant);
    console.log("Affiliate = " + Affiliate);

    let _token = $('#tokenDaily').val();
    let _url = getUrl()+"/GetDailyData";
    $.ajax({
        url: GetDailyDataURL,
        data: {
            date: dateDaily,
            affiliate: Affiliate,
            merchant: Merchant,


        },
        _token: _token,
        type: "POST",
        success: function(response) {
            if (response) {
                $('#rawClicks').html(response['rawClick']);
                $('#rawImpressions').html(response['rawImp']);
                $('#nClick').html(response['nClick']);
                $('#nLead').html(response['nLead']);
                $('#nSale').html(response['nSale']);
                $('#nImpression').html(response['nImpression']);
                $('#clickCommission').html(response['clickCommission']);
                $('#leadCommission').html(response['leadCommission']);
                $('#saleCommission').html(response['saleCommission']);
                $('#impressionCommission').html(response['impressionCommission']);
                console.log(response);

            } else {
                console.log(response);
                $('#rawClicks').html('NULL');
                $('#rawImpressions').html('NULL');
                $('#nClick').html('NULL');
                $('#nLead').html('NULL');
                $('#nSale').html('NULL');
                $('#nImpression').html('NULL');
                $('#clickCommission').html('NULL');
                $('#leadCommission').html('NULL');
                $('#saleCommission').html('NULL');
                $('#impressionCommission').html('NULL');
            }


        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("No Data");

        },



        //   Success end

    });
    /////////
}

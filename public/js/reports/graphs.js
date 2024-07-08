// function getGraphData() {

//     let Merchant = $("select[name=MerchantGraphs]").val();
//     let Affiliate = $("select[name=AffiliateGraphs]").val();

//     let _token = $('#tokenGraphs').val();

//     console.log('Merchant Graphs = ' + Merchant + "Affiliate = " + Affiliate);
//     let _url = getUrl()+"/GetGraphsData'";
//     $.ajax({
//         url: GetGraphsDataURL,
//         data: {
//             Merchant: Merchant,
//             Affiliate: Affiliate,

//         },
//         _token: _token,
//         type: "POST",
//         success: function(response) {
//             console.log("Graphs Data = ");
//             console.log(response);



//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert("No Data Found in Graphs");

//         },
//     });


// }

$('select[name=MerchantGraphs]').on('change', function() {

    $('#AffiliateGraphsControlGroup').show();
    let Mechant = $('select[name=MerchantGraphs]').val();
   
    // if (Mechant == '0') {
    //     $('#AffiliateGraphsControlGroup').hide();
   
      
    // } else {
        fillGraphAffiliates();
    //     // getGraphData();
    //     $('#myChart').show();

    // }



});
// Fill Graph Affiliates
function fillGraphAffiliates() {
    $("#Chart").remove();
    $(".Chart_box").append("<canvas id='Chart'></canvas>"); 
    let Merchant = $("select[name=MerchantGraphs]").val();
    let Affiliate = 'All';
    let _token = $('#tokenGraphs').val();
    let _url = getUrl()+"/GetGraphsData";
    $.ajax({
        url: GetGraphsDataURL,
        data: {
            Merchant: Merchant,
            // Affiliate: Affiliate,
        },
        _token: _token,
        type: "POST",
        success: function(response) {
            console.log(response)
            var len = 0;
            var tag = '';
            $('select[name=AffiliateGraphs]').empty(); // Empty <tbody>
            $("select[name=AffiliateGraphs]").append(Option_str);
            if (response != null && response.length > 0) {
               
                len = response['Affiliates'].length;

            }
            if (len > 0) {
                var Option_str =
                "<option value='All'>All</option>";
                for (var i = 0; i < len; i++) {
                    var affiliate_id = response['Affiliates'][i].affiliate_id;
                    var affiliate_company = response['Affiliates'][i].affiliate_company;
                    var Option_str =
                        "<option value=" + affiliate_id + ">" + affiliate_company + "</option>";

                    $("select[name=AffiliateGraphs]").append(Option_str);
                }
            } else {

                var Option_str =
                    "<option value='All'>No Affiliate</option>";

                $("select[name=AffiliateGraphs]").append(Option_str);

            }
              const  sales = response['Sale'].length;
              const click = response['Click'].length;

            var chart = document.getElementById("Chart").getContext("2d");
           const  myChart = new Chart(chart, {
                type: 'pie',
                data: {
                    labels: ['Sales on the same day from click',
                     'Sales within 15 days from click',
                     'Sales within 1 Month from click',
                     'Sales within 2 months from click',
                     '	Sales after 2 months from click',
                    ],
                    datasets: [{
                        label: '# of Votes',
                        data: [sales, click,sales],
                        backgroundColor: [
                            'Red',
                            'Blue',
                            'Yellow',
                            'Green', 
                            'Purple',
                             'Orange',
                        //     'rgba(54, 162, 235, 0.2)',
                        //     'rgba(255, 206, 86, 0.2)',
                        //     'rgba(75, 192, 192, 0.2)',
                        //     'rgba(153, 102, 255, 0.2)',
                        //     'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
           

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("No Affiliates Found For This Merchants in Graphs");

        },
    });
  
}

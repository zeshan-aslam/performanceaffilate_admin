   var calander = new Calendar({
       id: '#color-calendar',

   });

   $('#color-calendar').click(function() {
       console.log("Current Date = " + calander.getSelectedDate());




   });


   $(document).ready(function() {


       var currentPage = "<?php echo $tabId; ?>";
       console.log(currentPage);

       $(currentPage).attr('class', 'tab-pane fade in active');
       $("a[href=" + currentPage + "]").parent().attr('class', 'active');

       $("#check").on('click', function() {


       });



       const myEvents = [{
           start: '2021-04-15T06:00:00',
           end: '2021-04-15T20:30:00',
           name: 'Event 1',
           url: 'https://www.cssscript.com',
           desc: 'Description 1',
           // more key value pairs here
       }, ];


       new Calendar({
           id: '#color-calendar',
           // small or large
           theme: 'glass',
           primaryColor: '#74B749',
           headerColor: 'white',
           headerBackgroundColor: '#74B749',
           calendarSize: 'small',
           eventsData: myEvents,
           dateChanged: (currentDate, DateEvents) => {
               const m = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
               const dateArray = [
                   "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12",
                   "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24",
                   "25", "26", "27", "28", "29", "30", "31",
               ];
               calander.setDate(currentDate);
               const d = currentDate;
               let date = dateArray[d.getDate() - 1];
               let month = m[d.getMonth()];
               let year = d.getFullYear();
               dateToPass = year + "-" + month + "-" + date;
               console.log("Date To Pass = " + dateToPass);

               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });


               let Merchant = $("select[name=MerchantDaily]").val();
               let Affiliate = $("select[name=AffiliateDaily]").val();
               console.log("Merchant = " + Merchant);
               console.log("Affiliate = " + Affiliate);

               let _token = $('#tokenDaily').val();
               dateToPass = year + "-" + month + "-" + date;

               let _url = "{{url('Report/GetDailyData')}}";
               $.ajax({
                   url: _url,
                   data: {
                       date: dateToPass,
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
                       alert("No Data Found");

                   },



                   //   Success end

               });
               /////////
           },
           monthChanged: (currentDate, DateEvents) => {
               // do something
           },

       });






       $("#search").on("keyup", function() {


           var value = $(this).val().toLowerCase();
           $("#transTable tr").filter(function() {
               var tr_str = "<tr>" +
                   "<th class='hidden-phone'> Sr# </th>" +
                   "<th class='hidden-phone'> Type </th>" +
                   "<th class='hidden-phone'> Merchant </th>" +
                   "<th class='hidden-phone'> Affiliate</th>" +
                   "<th class='hidden-phone'> Commission </th>" +
                   "<th class='hidden-phone'> Date </th>" +
                   "<th class='hidden-phone'> Referer </th>" +
                   "<th class='hidden-phone'> Status </th>" +
                   "</tr>";


               $("#transTable thead").html(tr_str);

               $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
           });
       });

   });



   function getTransaction() {
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       var click = lead = impression = sale = '';
       let From = $("input[name=From]").val();
       let To = $("input[name=To]").val();
       let Affiliate = $("select[name=Affiliate]").val();
       let Merchant = $("select[name=Merchant]").val();
       let _token = $('#token').val();
       if ($("input[name=Click]").is(":checked")) {
           click = $("input[name=Click]").val();
       } else {
           click = "";

       }
       if ($("input[name=Lead]").is(":checked")) {
           lead = $("input[name=Lead]").val();
       } else {
           lead = "";

       }
       if ($("input[name=Sale]").is(":checked")) {
           sale = $("input[name=Sale]").val();
       } else {
           sale = "";

       }
       if ($("input[name=Impression]").is(":checked")) {
           impression = $("input[name=Impression]").val();
       } else {
           impression = "";

       }
       let Click = click;
       let Lead = lead;
       let Impression = impression;
       let Sale = sale;





       let _url = "{{url('Report/GetTransactionData')}}";
       $.ajax({
           url: _url,
           data: {
               From: From,
               To: To,
               Affiliate: Affiliate,
               Merchant: Merchant,
               Click: Click,
               Lead: Lead,
               Impression: Impression,
               Sale: Sale
           },
           _token: _token,
           type: "POST",
           success: function(response) {
               var tr_str = "<tr>" +
                   "<th class='hidden-phone'> Sr# </th>" +
                   "<th class='hidden-phone'> Type </th>" +
                   "<th class='hidden-phone'> Merchant </th>" +
                   "<th class='hidden-phone'> Affiliate</th>" +
                   "<th class='hidden-phone'> Commission </th>" +
                   "<th class='hidden-phone'> Date </th>" +
                   "<th class='hidden-phone'> Referer </th>" +
                   "<th class='hidden-phone'> Status </th>" +
                   "</tr>";


               $("#transTable thead").html(tr_str);


               // console.log(response['joinId']);
               // console.log(response['data']);
               const joinId = response['joinId'];
               // console.log(joinId);



               var len = 0;
               var tag = '';
               $('#transTable tbody').empty(); // Empty <tbody>
               if (response['data'] != null) {
                   len = response['data'].length;
                   // console.log("Length = " + len);
               } else if (response['error'] != null) {
                   var tr_str = "<tr>" +
                       "<td align='center' colspan='4'>Error in Getting Data </td>" +
                       "</tr>";
                   $("#transTable tbody").append(tr_str);
                   len = 0;

               }
               if (len > 0 && response['error'] != true) {
                   for (var i = 0; i < len; i++) {
                       var transaction_type = response['data'][i].transaction_type;

                       if (transaction_type == 'sale') {
                           tag = 'warning'

                       }

                       if (transaction_type == 'lead') {
                           tag = 'info'
                       }

                       if (transaction_type == 'impression') {
                           tag = 'success'
                       }
                       if (transaction_type == 'click') {
                           tag = 'important'
                       }

                       var merchant_company = response['data'][i].merchant_company;
                       var affiliate_company = response['data'][i].affiliate_company;
                       var transaction_amttobepaid = response['data'][i].transaction_amttobepaid;
                       var transaction_dateoftransaction = response['data'][i].transaction_dateoftransaction;
                       var transaction_referer = response['data'][i].transaction_referer;
                       var transaction_status = response['data'][i].transaction_status;
                       var joinpgm_merchantid = response['data'][i].joinpgm_merchantid;
                       var joinpgm_affiliateid = response['data'][i].joinpgm_affiliateid;
                       var joinpgm_id = response['data'][i].joinpgm_id;



                       var tr_str = "<tr>" +
                           "<td align='center'>" + (i + 1) + "</td>" +
                           "<td align='center'><span class='label label-" + tag + " label-mini'>" + transaction_type + "</span></td>" +
                           "<td align='center'><a href='#showMerchant" + joinpgm_merchantid + "' role='button'data-toggle='modal'>" + merchant_company + "</a></td>" +
                           "<td align='center'><a href='#affModelprofile" + joinpgm_affiliateid + "' role='button'data-toggle='modal'>" + affiliate_company + "</a></td>" +
                           "<td align='center'>" + transaction_amttobepaid + "</td>" +
                           "<td align='center'>" + transaction_dateoftransaction + "</td>" +
                           "<td align='center'><a href='" + transaction_referer + "' target='_blank'>" + transaction_referer + "</a></td>" +
                           "<td align='center'><span class='label label-success label-mini'>" + transaction_status + "<span></td>" +
                           "</tr>";


                       $("#transTable tbody").append(tr_str);



                   }
               } else if (response['data'].length == 1 && response['error'] != true) {
                   var transaction_type = response['data'].transaction_type;
                   var merchant_company = response['data'].merchant_company;
                   var affiliate_company = response['data'].affiliate_company;
                   var transaction_amttobepaid = response['data'].transaction_amttobepaid;
                   var transaction_dateoftransaction = response['data'].transaction_dateoftransaction;
                   var transaction_referer = response['data'].transaction_referer;
                   var transaction_status = response['data'].transaction_status;
                   var tr_str = "<tr>" +
                       "<td align='center'>1</td>" +


                       "<td align='center'>" + transaction_type + "</td>" +
                       "<td align='center'>" + merchant_company + "</td>" +
                       "<td align='center'>" + affiliate_company + "</td>" +
                       "<td align='center'>" + transaction_amttobepaid + "</td>" +
                       "<td align='center'>" + transaction_dateoftransaction + "</td>" +
                       "<td align='center'>" + transaction_referer + "</td>" +
                       "<td align='center'>" + transaction_status + "</td>" +
                       "</tr>";

                   $("#transTable tbody").append(tr_str);


               } else {
                   var tr_str = "<tr>" +
                       "<td align='center' colspan='4'>No record found.</td>" +
                       "</tr>";
                   $("#transTable tbody").append(tr_str);
               }
           },
           error: function(xhr, ajaxOptions, thrownError) {
               var tr_str = "<tr>" +
                   "<th class='hidden-phone'> Sr# </th>" +
                   "<th class='hidden-phone'> Type </th>" +
                   "<th class='hidden-phone'> Merchant </th>" +
                   "<th class='hidden-phone'> Affiliate</th>" +
                   "<th class='hidden-phone'> Commission </th>" +
                   "<th class='hidden-phone'> Date </th>" +
                   "<th class='hidden-phone'> Referer </th>" +
                   "<th class='hidden-phone'> Status </th>" +
                   "</tr>";


               $("#transTable thead").html(tr_str);

               var tr_str = "<tr>" +
                   "<td align='center' colspan='4'>No record found.</td>" +
                   "</tr>";
               $("#transTable tbody").html(tr_str);
           },



           //   Success end

       });
   }



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


       let _url = "{{url('Report/GetDailyData')}}";
       $.ajax({
           url: _url,
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
               alert("No Data");

           },



           //   Success end

       });
       /////////
   }
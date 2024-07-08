
// var iTbl = $('#invoiceTable').DataTable();
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });


// function invoicedata() {

//     console.log('Transaction data below');

//     let from = $("input[name=invoiceFrom]").val();
//     let to = $("input[name=invoiceTo]").val();
//     let status = $("select[name=status]").val();
//     let _token = $("input[name=_token]").val();

//     $.ajax({
//         type: "POST",
//         url: getInvoiceDataURL,
//         data: {
//             From: from,
//             To: to,
//             Status: status,
//         },
//         token: _token,
//         success: function(response) {
//             console.log("peachty hutt", response);

//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(thrownError);

//         },

//     }).done(function(response) {

//         console.log("Agay aaaaa", response);
//         $('#invoiceTable').on('error.dt', function(e, settings, techNote, message) {
//             console.log('An error has been reported by DataTables: ', message);
//         }).DataTable({
//             "lengthMenu": [
//                 [5, 10, 25, 50, -1],
//                 [5, 10, 25, 50, "All"]
//             ],
//             "stateSave": true,
//             "bDestroy": true,
//             "autoWidth":false,


//             data: response['data'],
//             columns: [{
//                     "_": "plain",
//                     data: null,
//                     render: function(row, data, type) {
//                         return row.invoice_id;
//                     }
//                 },
//                 {
//                     data: 'invoice_monthyear',
//                 },
//                 {
//                     "_": "plain",
//                     data: null,
//                     render: function(row, data, type) {
//                         return "<a href='#invoiceModel' role='button' data-toggle='modal' >" +
//                             row.merchant_firstname+"  "+row.merchant_lastname+ "</a>";
//                     }
//                 },
//                 {

//                     data: 'invoice_amount',

//                 },
//                 {
//                     "_": "plain",
//                     data: null,
//                     render: function(row, data, type) {
//                         return "<a href='javascript:;' onclick='javascript:viewTransaction(" +
//                         row.invoice_id + ")'> View Transaction</a>";
//                     }

//                 },
//                 {
//                     "_": "plain",
//                     data: null,
//                     render: function(row, data, type) {
//                         if (row.invoice_paidstatus==0) {
//                             return    "<span class='label label-danger'>Unpaid</span>"
//                         } else {

//                             return   "<span class='label label-success'>Paid</span>"
//                         }
//                     }

//                 },


//             ],



//         });



//     });

// }

// function viewTransaction(id) {

//         $.ajax({
//                 type: "GET",
//                 url: getInvoiceDataURL ,
//                 data: {
//                     id: id,
//                 },

//             })
//             .done(function(data) {
//                 console.log(data);

//                 invoice_id = data.invoice_id;
//                 console.log(data);
//                 warningSound.play();
//                 Swal.fire({
//                     title: "Are you sure you want to Reject " + data.merchant_company + " ?",
//                     html: "<table class='table table-striped table-hover table-bordered' id='editable-sample1'>" +
//                         "<tbody>" +
//                         "<tr>" +
//                         "<td><b>ID </b></td>" +
//                         "<td>" + data.invoice_id + "</td>" +
//                         "</tr>" +
//                         "<tr>" +
//                         "<td><b>Company Name</b></td>" +
//                         "<td>" + data.invoice_amount+ "</td>" +
//                         "</tr>" +
//                         "<tr>" +
//                         "<td><b>First Name </b></td>" +
//                         "<td> " + data.invoice_paidstatus + "</td>" +
//                         "</tr>" +
//                         "<tr>" +
//                         "</tbody>" +
//                         "</table>",
//                     icon: "warning",
//                     showCancelButton: true,
//                     confirmButtonColor: "#3085d6",
//                     cancelButtonColor: "#d33",
//                     confirmButtonText: "Yes, Reject it"
//                 }).then((result) => {
//                     if (result.isConfirmed) {

//                         let _token = "{{ csrf_token() }}";
//                         $.ajax({
//                             type: "POST",
//                             url: "Affiliate/removeAffiliate",
//                             data: {
//                                 id: id,

//                             },
//                             _token: _token,
//                         }).done(function(data) {
//                             console.log("Deleteeeeed", data);
//                             table.ajax.reload();
//                             if (data == 1) {

//                                 Swal.fire(
//                                     "Rejected",
//                                     "Affiliate has been Reject Successfully",
//                                     "success"
//                                 )
//                                 successSound.play();
//                             }

//                         });
//                     }


//                 })
//             });
//     }

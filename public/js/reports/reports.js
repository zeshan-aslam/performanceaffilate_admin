
function formatAffiliate(d) {
    var detail = '';
    detail += "<table style='font-size:12px' class='table table-bordered table-hover'><tbody><tr class='well'>" +
        " <td class='text-success'><b>Name</b></td><td>" + d.affiliate_firstname + " " + d.affiliate_lastname +
        "</td> <td class='text-success'><b>Company</b></td><td>" + d.affiliate_company +
        "</td> <td class='text-success'><b>Address</b></td><td>" + d.affiliate_address + "</td>" +


        "</tr >";
    detail +=
        "<tr class='well'><td class='text-success'><b>City</b></td><td>" + d.affiliate_city +
        "</td> <td class='text-success'><b>Country</b></td><td>" + d.affiliate_country +
        "</td> <td class='text-success'><b>Phone</b></td><td>" + d.affiliate_phone + "</td>" +

        "</tr>";
    detail += "<tr class='well'>" +
        " <td class='text-success'><b>Catagory</b></td><td>" + d.affiliate_category +
        "</td> <td class='text-success'><b>Status</b></td><td>" + d.affiliate_status +
        "</td> <td class='text-success'><b>Fax</b></td><td>" + d.affiliate_fax + "</td>" +

        "</tr>";
    detail += "<tr class='well'>" +

        " <td class='text-success'><b>State</b></td><td>" + d.affiliate_state +
        "</td> <td class='text-success'><b>Currency</b></td><td>" + d.affiliate_currency +
        "</td> <td class='text-success'><b>Tax ID</b></td><td>" + d.affiliate_taxId + "</td>" +

        "</tr>";

    detail += "</tbody></table>";

    Swal.fire({
        title: "Affiliate : " + d.affiliate_company,
        html: detail,
        position: 'top',
        showClass: {
            popup: `
              animate__animated
              animate__bounceIn
              animate__faster
                 `
        },
        hideClass: {
            popup: `
             animate__animated
             animate__zoomOut
             animate__faster
                      `
        },
        grow: 'row',
        width: 600,
        showConfirmButton: false,
        showCloseButton: true
    })
}

function formatMerchant(d) {
    var detail = '';
    detail += "<table style='font-size:12px' class='table table-bordered table-hover'><tbody><tr class='well'>" +
        " <td class='text-success'><b>Name</b></td><td>" + d.merchant_firstname + " " + d.merchant_lastname +
        "</td> <td class='text-success'><b>Company</b></td><td>" + d.merchant_company +
        "</td> <td class='text-success'><b>Address</b></td><td>" + d.merchant_address + "</td>" +


        "</tr>";
    detail += "<tr class='well'>" +

        " <td class='text-success'><b>City</b></td><td>" + d.merchant_city +
        "</td> <td class='text-success'><b>Country</b></td><td>" + d.merchant_country +
        "</td> <td class='text-success'><b>Phone</b></td><td>" + d.merchant_phone + "</td>" +

        "</tr>";
    detail += "<tr class='well'>" +
        " <td class='text-success'><b>Catagory</b></td><td>" + d.merchant_category +
        "</td> <td class='text-success'><b>Status</b></td><td>" + d.merchant_status +
        "</td> <td class='text-success'><b>Fax</b></td><td>" + d.merchant_fax + "</td>" +

        "</tr>";
    detail += "<tr class='well'>" +

        " <td class='text-success'><b>Type</b></td><td>" + d.merchant_type +
        "</td> <td class='text-success'><b>Currency</b></td><td>" + d.merchant_currency +
        "</td> <td class='text-success'><b>PGM Approval</b></td><td>" + d.merchant_pgmapproval + "</td>" +

        "</tr>";
    detail += "<tr class='well'>" +
        " <td class='text-success'><b>State</b></td><td>" + d.merchant_state +
        "</td> <td class='text-success'><b>Zip</b></td><td>" + d.merchant_zip +
        "</td> <td class='text-success'><b>Tax Id</b></td><td>" + d.merchant_taxId + "</td>" +


        "</tr>";
    detail += "<tr class='well'>" +

        " <td class='text-success'><b>Order Id</b></td><td>" + d.merchant_orderId +
        "</td> <td class='text-success'><b>Sale Amount</b></td><td>" + d.merchant_saleAmt +
        "</td> <td class='text-success'><b>Invoice Status</b></td><td>" + d.merchant_invoiceStatus + "</td>" +

        "</tr></tbody></table>";
    Swal.fire({
        title: "Merchant : " + d.merchant_company,
        html: detail,
        position: 'top',
        showClass: {
            popup: `
              animate__animated
              animate__bounceIn
              animate__faster
                 `
        },
        hideClass: {
            popup: `
             animate__animated
             animate__zoomOut
             animate__faster
                      `
        },
        grow: 'row',
        width: 650,
        showConfirmButton: false,
        showCloseButton: true
    })
}

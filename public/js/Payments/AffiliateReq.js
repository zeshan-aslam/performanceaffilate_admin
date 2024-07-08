var Afftable;
var i = 0;
const checkboxId = [];
const checkboxName = [];

function AffRequest() {
    Afftable = $("#affReqpay")
        .on("init.dt", function () {
            var rowCount = $("#affReqpay tr").length;
            if (rowCount == 0) {
                $("#deletehide").hide();
            }
            console.log("Rooooow checked", rowCount);
        })
        .on("draw", function () {
            console.log("Redraw occurred at: " + new Date().getTime());
            Afftable.rows()
                .data()
                .map((row) => {
                    console.log(row.affiliate_company);
                });
        })
        .DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            ajax: affreqsURL,

            stateSave: true,
            autoWidth: false,

            columns: [
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            "<input type='checkbox' name='checkbox[]' class='checkbox' onchange='testing(" +
                            row.affiliate_id +
                            ")'>"
                        );
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.affiliate_company;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.request_amount;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.pay_amount;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.bankinfo_modeofpay;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.request_date;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            "<a  href='#' class='btn btn-danger btn-sm' onclick='javascript:DeclineaffReq(" +
                            row.affiliate_id +
                            ")' ><i class='icon-remove icon-white'></i> Decline</a>"
                        );
                    },
                },

                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            "<a  href='javascript:;' onclick='javascript:payAffiliate(" +
                            row.affiliate_id +
                            ")' class='btn btn-success btn-md'><i class='icon-refresh icon-white'></i> Completed</a> "
                        );
                    },
                },
            ],
            order: [[1, "asc"]],
        });
}
$("#affReqpay tbody").on("change", "td input[type=checkbox]", function () {
    var tr = $(this).closest("tr");
    var row = Afftable.row(tr);
    var data = row.data();
    if ($(this).is(":checked")) {
        fillArray(row.data());
    } else if (!$(this).is(":checked")) {
        const index = checkboxId.indexOf(data.affiliate_id);
        const Name= checkboxName.indexOf(data.affiliate_company);
        if (index > -1) {
            checkboxId.splice(index, 1);
            checkboxName.splice(Name, 1);
            i--;
        }

    }

    console.log(data.affiliate_company + " is changed");
});


function testing() {
    var rowCount = $("#affReqpay tr").length;

    console.log("Rooooow checked", rowCount);
}
function fillArray(data) {
    if (jQuery.inArray(data.affiliate_id, checkboxId) !== -1) {
    } else {
        checkboxId[i] = data.affiliate_id;
        checkboxName[i] = data.affiliate_company;
        i++;
    }
}
function DeleteaffReq() {
    var str = "<ul>";
    for (let index = 0; index < i; index++) {
        str += "<li>" + checkboxName[index] + "</li>";
    }
    str += "</ul>";
    if (i == 0) {
    } else {
        warningSound.play();
        Swal.fire({
            title: "Are you sure you want to Decline?",
            text: "You won't be able to revert this",
            html: str,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Decline it",
        }).then((result) => {
            if (result.isConfirmed) {
                let _token = $("input[name=_token]").val();
                $.ajax({
                    type: "POST",
                    url: affReqDeleteURL,
                    data: {
                        id: checkboxId,
                    },
                    _token: _token,
                }).done(function (data) {
                    console.log("Decline", data);
                    Afftable.ajax.reload();
                    if (data == 1) {
                        checkboxId.splice(0, checkboxId.length);
                        checkboxName.splice(0, checkboxName.length);
                        i = 0;
                        Swal.fire(
                            "Decline",
                            "Affiliate Request has been Decline Successfully",
                            "success"
                        );
                        successSound.play();
                    }
                });
            }
        });
    }
}

function payAffiliate(id) {
    $.ajax({
        type: "post",
        url: manualpayURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log("Check data ", data);
        Afftable.ajax.reload();

        let x = data.findIndex(check);
        function check(x) {
            Afftable.ajax.reload();
            if (x == 1) {
                Afftable.ajax.reload();
                successSound.play();
                Command: toastr["success"]("Payments successfully", "Success");
            }
            // else {
            //     errorSound.play();
            //     Command: toastr["error"](" ", "Error Payments Method")
            // }
        }
    });
}

// function payAffiliate(id) {
//     $.ajax({
//         type: "post",
//         url: showAffURL,
//         data: {
//             id: id,
//         },
//     }).done(function (data) {
//         console.log("Pay data",data);
//         affiliate_id = data.affiliate_id;
//         warningSound.play();
//         Swal.fire({
//             title:"Are you sure you want to  Affiliate Pay " +  data.affiliate_company +" ?",
//             text: "Payment Gateway used is "+ data.bankinfo_modeofpay  +". Before making payment through the sytem make sure that you have made the actual payment through "+ data.bankinfo_modeofpay  +" ",

//             showCancelButton: true,
//             confirmButtonColor: "#3085d6",
//             cancelButtonColor: "#d33",
//             confirmButtonText: "Yes, Proceed",
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 let _token = $("input[name=_token]").val();
//                 $.ajax({
//                     type: "POST",
//                     url: manualpayURL,
//                     data: {
//                         id: id,
//                     },
//                     _token: _token,
//                 }).done(function (data) {
//                     console.log("Completed", data);
//                     Afftable.ajax.reload();
//                     if (data == 1) {
//                         Swal.fire(
//                             "Completed",
//                             "Affiliate Request has been Completed Successfully",
//                             "success"
//                         );
//                         successSound.play();
//                     }
//                 });
//             }
//         });
//     });
// }

function DeclineaffReq(id) {
    $.ajax({
        type: "post",
        url: showAffURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log("Decline", data);
        affiliate_id = data.affiliate_id;
        warningSound.play();
        Swal.fire({
            title:
                "Are you sure you want to Decline? " +
                data.affiliate_company +
                " ?",
            text: "You won't be able to revert this",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Decline it",
        }).then((result) => {
            if (result.isConfirmed) {
                let _token = $("input[name=_token]").val();
                $.ajax({
                    type: "POST",
                    url: affReqDeclineURL,
                    data: {
                        id: id,
                    },
                    _token: _token,
                }).done(function (data) {
                    console.log("Decline", data);
                    Afftable.ajax.reload();
                    if (data == 1) {
                        Swal.fire(
                            "Decline",
                            "Affiliate Request has been Decline Successfully",
                            "success"
                        );
                        successSound.play();
                    }
                });
            }
        });
    });
}

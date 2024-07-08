var Mertable;
function MerRequest() {
    Mertable = $("#MerReqpay")
        .on("init.dt", function () {
            console.log("Table Merchant Req");
        })
        .DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            ajax: MerRequestURL,

            stateSave: true,
            autoWidth: false,

            columns: [
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.merchant_date;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.merchant_company;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return "£ " + row.addmoney_amount;
                    },
                },

                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        var cap;
                        if (row.addmoney_mode == "register")
                            cap = "Registration Fee";
                        else if (row.addmoney_mode == "upgrade")
                            cap = "Upgradation Amount";
                        else if (row.addmoney_mode == "addmoney") {
                            cap = "Deposited";
                        }

                        return cap;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return row.addmoney_paytype;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            "<a  href='javascript:;' onclick='javascript:payMerchant(" +
                            row.addmoney_id +
                            ")' class='btn btn-success btn-md'><i class='icon-ok icon-white'></i> Pay Now</a> " +
                            "<a  href='javascript:;' onclick='javascript:RejectMerReq(" +
                            row.addmoney_id +
                            ")' class='btn btn-danger btn-md'><i class='icon-remove icon-white'></i> Reject</a> "
                        );
                    },
                },
            ],
            order: [[1, "asc"]],
        });
}

function payMerchant(id) {
    $.ajax({
        type: "post",
        url: MerchantPayURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log("Check data ", data);
        Mertable.ajax.reload();

        let x=data.findIndex(check);
        function check(x)
        {

                if ( x == 1) {
                Mertable.ajax.reload();
                successSound.play();
                Command: toastr["success"]("Payments successfully", "Success")
                }
            // else {
            //     errorSound.play();
            //     Command: toastr["error"](" ", "Error Payments Method")
            // }
        }


                });
            }




function RejectMerReq(id) {
    $.ajax({
        type: "post",
        url: showMerURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log(data);
        merchant_id = data.merchant_id;
        warningSound.play();
        Swal.fire({
            title:
                "Are you sure you want to Reject? " +
                data.merchant_company +
                " ?",
            text: "You won't be able to revert this",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Reject it",
        }).then((result) => {
            if (result.isConfirmed) {
                let _token = $("input[name=_token]").val();
                $.ajax({
                    type: "POST",
                    url: rejectMerURL,
                    data: {
                        id: id,
                    },
                    _token: _token,
                }).done(function (data) {
                    console.log("Rejected", data);
                    Mertable.ajax.reload();
                    if (data == 1) {
                        Swal.fire(
                            "Reject",
                            "Merchant has been Reject Successfully",
                            "success"
                        );
                        successSound.play();
                    }
                });
            }
        });
    });
}

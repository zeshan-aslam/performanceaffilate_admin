

var reversetable;
function ReverseSaletable() {
    reversetable = $("#revertable")
        .on("init.dt", function () {
            console.log("Table Reverse Request");
        })
        .DataTable({

            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            ajax: ReverseSaleURL,

            stateSave: true,
            autoWidth: false,

            columns: [
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
                        return row.merchant_company;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        if (row.transaction_type == 'click')
                        return   "<span class='label label-success'>Click</span>"
                        else if(row.transaction_type == 'Impression')
                        return   "<span class='label label-success'>Impression</span>"
                        else if(row.transaction_type == 'lead')
                        return    "<span class='label label-danger'>Lead</span>"
                        else if(row.transaction_type == 'sale')
                        return   "<span class='label label-warning'>Sale</span>"
                        if (row.transaction_status == 'reversed')
                        return "<span class='label label-primary'>Reverse</span>"
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        if (row.transaction_flag == 1){
                        return  row.transaction_admin_amount - row.transaction_subsale;
                        }
                    else{
                        return  row.transaction_admin_amount;
                    }
                    },
                },
                {

                    _: "plain",
                    data: null,
                    render: function (data, type, row) {
                        return (
                            "<a  href='javascript:;' class='getDataid btn btn-success btn-md'><i class='icon-ok icon-white'></i> Pay Now</a>"
                        );
                    },
                },
            ],
            order: [[1, "asc"]],
        });
}

$("#revertable tbody").on("click", "td a", function () {
    var tr = $(this).closest("tr");
    var row = reversetable.row(tr);
    payReverse(row.data());
});

function getDataid(data) {
    $("input[name=id]").val(data.transaction_id);
    $("input[name=aid]").val(data.joinpgm_affiliateid);
    $("input[name=mid]").val(data.joinpgm_merchantid);
    $("input[name=tid]").val(data.transaction_id);
    $("input[name=amount]").val(data.transaction_admin_amount);

}

function payReverse(row) {

        let _token = $("input[name=_token]").val();

        let _url = payReverseURL;
        $.ajax({
            url: _url,
            data:
            {
                id:row.transaction_id,
                aid:row.joinpgm_affiliateid,
                mid:row.joinpgm_merchantid,
                tid:row.transaction_id,
                amount:row.transaction_admin_amount,
            },
            _token: _token,
            type: "POST",
        }).done(function (data) {
            console.log(data);
            reversetable.ajax.reload();

            let x=data.findIndex(check);
            function check(x)
            {
                if ( x == 1) {
                reversetable.ajax.reload();
                successSound.play();
                Command: toastr["success"]("Payments successfully", "Success")
                }
                // else {
                //     errorSound.play();
                //     Command: toastr["error"](" ", "Payment Failure.Admin has no money in his account!!!")
                // }
            }
        });

    }

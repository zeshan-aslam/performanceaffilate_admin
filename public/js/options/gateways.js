var gateWaysTable;

function getPaymentGateways() {
    gateWaysTable = $('#gateWaysTable')
        .on('init.dt', function() {

            console.log('gateWays Table initialisation complete: ' + new Date().getTime());
        })


    .DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        ajax: getPaymentGatewaysURL,
        "autoWidth": false,

        "stateSave": true,


        columns: [{
                data: 'pay_name',

            },
            {

                '_': 'plain',
                data: null,
                render: function(row, type) {
                    if (type === 'display') {
                        if (row.pay_status == 'Active')
                            return "<a href='javascript:;' onclick='javascript:deactivatePayment(" +
                                row.pay_id + ")' class='btn btn-inverse'>Suspend</a>";
                        else if (row.pay_status == 'Inactive')
                            return "<a  href='javascript:;'class='btn btn-success' onclick='javascript:activatePayment(" +
                                row.pay_id + ")'>Activate</a>";



                    }

                    return row;
                }

            },


        ],
        "order": [
            [1, 'asc']
        ],


    });


}

function activatePayment(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdateGateway';

    $.ajax({
        url: updateGatewayURL,
        data: {
            id: id,
            pay_status: 'Active',
        },
        _token: _token,
        type: "POST",
        success: function(response) {},
        error: function(xhr, ajaxOptions, thrownError) {
            alert('Error in Updating Gateway = ' + thrownError);

        },
    }).done(function(response) {
        console.log('Error  Update Rsponse = ', response);
        if (response == 1) {
            gateWaysTable.ajax.reload();
            successSound.play();
            Command: toastr["success"]("Gateway Activated successfully", "Success");


        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Please Modify something");

        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in Activating Gateway");

        }


    });
}

function deactivatePayment(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    let _url = '/Options/UpdateGateway';
    let _token = $('input[name=_token]').val();
    $.ajax({
        url: updateGatewayURL,
        data: {
            id: id,
            pay_status: 'Inactive',
        },
        _token: _token,
        type: "POST",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Updating Gateway = ' + thrownError);
        },
    }).done(function(response) {
        console.log('Error  Update Rsponse = ', response);
        if (response == 1) {
            gateWaysTable.ajax.reload();
            successSound.play();
            Command: toastr["success"]("Gateway deactivated successfully", "Success");


        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Please Modify something");
        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in deactivating Gateway");

        }


    });
}

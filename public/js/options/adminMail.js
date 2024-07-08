function getAdminMailOptions() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    let _url = '/Options/GetAdminMailOptions';

    $.ajax({
        url: GetAdminMailOptionsURL,

        type: "GET",
        success: function(response) {},
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in getting Admin Mail Options = ' + thrownError);

        },
    }).done(function(response) {
        console.log('Admin Get  Mail Rsponse = ', response);
        $('textarea[name=adminMailHeader]').val(response.admin_mailheader);
        $('textarea[name=adminMailFooter]').val(response.admin_mailfooter);
        $('input[name=adminAmount]').val(response.admin_mailamnt);


    });
}

function updateAdminMailOptions() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    let adminMailHeader = $('textarea[name=adminMailHeader]').val();
    let adminMailFooter = $('textarea[name=adminMailFooter]').val();
    if (adminMailFooter == "" || adminMailHeader == "") {
        Command: toastr["error"](" ", "Please input all Fields");

    }else if (adminMailFooter.length > 1000 || adminMailHeader.length >1000)  {
        Command: toastr["error"]("Length is greater than 1000", "Error");

    }
    else {
    let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdateAdminMailOptions';

    $.ajax({
        url: UpdateAdminMailOptionsURL,
        data: {
            adminMailHeader: adminMailHeader,
            adminMailFooter: adminMailFooter,

        },
        _token: _token,
        type: "POST",
        success: function(response) {},
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Updating Admin Mail Options = ' + thrownError);

        },
    }).done(function(response) {
        console.log('Admin Mail   Rsponse = ', response);
        if (response) {

            successSound.play();
            Command: toastr["success"]("Admin Mail Options Updated successfully", "Success");


        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Please Modify something");

        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in Updating Admin Mail Options");

        }


    });
  }
}

function updateAdminAmount() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    let adminAmount = $('input[name=adminAmount]').val();
    if (adminAmount == "") {
        Command: toastr["error"](" ", "Please input Amount");

    }else if (adminAmount> 50)  {
        Command: toastr["error"]("Amount is greater than 50", "Error");

    }
    else {
    let _token = $('input[name=_token]').val();
    let _url = '/Options/UpdateAdminAmount';

    $.ajax({
        url: UpdateAdminAmountURL,
        data: {
            adminAmount: adminAmount,

        },
        _token: _token,
        type: "POST",
        success: function(response) {},
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Updating Admin Amount = ' + thrownError);

        },
    }).done(function(response) {
        console.log('Admin Amount Rsponse = ', response);
        if (response) {

            successSound.play();
            Command: toastr["success"]("Admin Amount Updated successfully", "Success");


        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Please Modify something");

        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in Updating Admin Amount");

        }


    });
    }
}

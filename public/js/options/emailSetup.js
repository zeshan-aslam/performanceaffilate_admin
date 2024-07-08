function updateMailSetup() {
    let mailSetupEvent = $("select[name=mailSetupEvent]").val();
    if (mailSetupEvent == "0") {
        Command: toastr["error"]("Please Select Event", "Error");
    } else {
        let mailSetupTestTo = $("input[name=mailSetupTestTo]").val();
        let mailSetupStatus = $(
            "input[type=radio][name=mailSetupStatus]:checked"
        ).val();

        let mailSetupFrom = $("input[name=mailSetupFrom]").val();
        let mailSetupSubject = $("input[name=mailSetupSubject]").val();
        let mailSetupHeader = $("textarea[name=mailSetupHeader]").val();
        let mailSetupBody = $("textarea[name=mailSetupBody]").val();
        let mailSetupFooter = $("textarea[name=mailSetupFooter]").val();

        let _token = $("input[name=_token]").val();
        let _url = "/Options/UpdateMailSetup";
        $.ajax({
            url: UpdateMailSetupURL,
            data: {
                mailSetupTestTo: mailSetupTestTo,
                mailSetupStatus: mailSetupStatus,
                mailSetupEvent: mailSetupEvent,
                mailSetupFrom: mailSetupFrom,
                mailSetupSubject: mailSetupSubject,
                mailSetupHeader: mailSetupHeader,
                mailSetupBody: mailSetupBody,
                mailSetupFooter: mailSetupFooter,
            },
            _token: _token,
            type: "POST",
        })
            .done(function (response) {
                console.log("Test Email Setup  Response= ", response);
                if (response == 1) {
                    successSound.play();
                    Command: toastr["success"](
                        "Mail Template Updated successfully",
                        "Success"
                    );
                } else if (response == 0) {
                    errorSound.play();
                    Command: toastr["error"](
                        "Please Modify something",
                        "Error"
                    );
                } else {
                    errorSound.play();
                    Command: toastr["error"](
                        "Error in Updating Mail Template",
                        "Error"
                    );
                }
            })
            .fail(function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Updating Mail Template= " + thrownError);
            });
    }
}
function getMailSetup() {
    let mailSetupEvent = $("select[name=mailSetupEvent]").val();
    if (mailSetupEvent == "0") {
        Command: toastr["error"]("Please Select Event", "Error");
    } else {
        let _token = $("input[name=_token]").val();
        let _url = "/Options/GetMailSetup";
        $.ajax({
            url: GetMailSetupURL,
            data: {
                mailSetupEvent: mailSetupEvent,
            },
            _token: _token,
            type: "POST",
        })
            .done(function (response) {
                console.log("Test Email Setup  Response= ", response);
                if (response.event_status == "yes") {
                    $("input[name=mailSetupStatus][value=yes]").prop(
                        "checked",
                        true
                    );
                } else {
                    $("input[name=mailSetupStatus][value=no]").prop(
                        "checked",
                        true
                    );
                }

                $("input[name=mailSetupFrom]").val(response.adminmail_from);
                $("input[name=mailSetupSubject]").val(
                    response.adminmail_subject
                );
                $("textarea[name=mailSetupHeader]").val(
                    response.adminmail_header
                );
                $("textarea[name=mailSetupBody]").val(
                    response.adminmail_message
                );
                $("textarea[name=mailSetupFooter]").val(
                    response.adminmail_footer
                );
            })
            .fail(function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Sending Test Mail = " + thrownError);
            });
    }
}
function fillEventsMailSetup() {
    let _url = "/Options/FillEventsMailSetup";
    $.ajax({
        url: FillEventsMailSetupURL,
        type: "GET",
    })
        .done(function (response) {
            console.log("Fill Events Email Setup  Response= ", response);
            $("select[name=mailSetupEvent]").empty();
            var option = "";
            option +=
                "<option selected='selected' value='0'>Select Event</option>";
            for (var i = 0; i < response.length; i++) {
                var eventName = response[i].event_name;

                option +=
                    "<option value='" +
                    eventName +
                    "'>" +
                    eventName +
                    "</option>";
            }
            $("select[name=mailSetupEvent]").append(option);
        })
        .fail(function (xhr, ajaxOptions, thrownError) {
            console.log("Error in Getting Event List = " + thrownError);
        });
}
function sendSetupTestMail() {
    let mailSetupEvent = $("select[name=mailSetupEvent]").val();
    let mailSetupFrom = $("input[name=mailSetupFrom]").val();
    if (mailSetupEvent == "0") {
        Command: toastr["error"]("Please Select Event", "Error");
    } else if (mailSetupFrom == "") {
        Command: toastr["error"]("Please Input Email", "Error");
    } else {
        let mailSetupTestTo = $("input[name=mailSetupTestTo]").val();
        let mailSetupStatus = $(
            "input[type=radio][name=mailSetupStatus]:checked"
        ).val();

        let mailSetupSubject = $("input[name=mailSetupSubject]").val();
        let mailSetupHeader = $("textarea[name=mailSetupHeader]").val();
        let mailSetupBody = $("textarea[name=mailSetupBody]").val();
        let mailSetupFooter = $("textarea[name=mailSetupFooter]").val();

        let _token = $("input[name=_token]").val();
        let _url = "/Options/SendBulkMail";
        $.ajax({
            url: SendBulkMailURL,
            data: {
                mails: mailSetupTestTo,
                bulkFrom: mailSetupFrom,
                bulkHeader: mailSetupHeader,
                bulkSubject: mailSetupSubject,
                bulkFooter: mailSetupFooter,
                bulkBody: mailSetupBody,
            },
            _token: _token,
            type: "POST",
        })
            .done(function (response) {
                console.log("Test Mail Send  Response= ", response);
            })
            .fail(function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Sending Test Mail = " + thrownError);
            });
    }
}

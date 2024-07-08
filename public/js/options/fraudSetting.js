function updateFraudSetting() {
    var siteFraudSaleSeconds = $("input[name=siteFraudSaleSeconds]").val();
    var siteFraudSaleAction = $("select[name=siteFraudSaleAction]").val();
    var siteFraudClickSeconds = $("input[name=siteFraudClickSeconds]").val();
    var siteFraudClickAction = $("select[name=siteFraudClickAction]").val();
    var siteLoginRetry = $("input[name=siteLoginRetry]").val();
    var siteLoginDelay = $("input[name=siteLoginDelay]").val();

    if ($("input[name=siteFraudRecentClick]").is(":checked")) {
        var siteFraudRecentClick = 1;
    } else {
        var siteFraudRecentClick = 0;
    }

    if ($("input[name=siteFraudRecentSale]").is(":checked")) {
        var siteFraudRecentSale = 1;
    } else {
        var siteFraudRecentSale = 0;
    }

    if ($("input[name=siteFraudDeclineRecentSale]").is(":checked")) {
        var siteFraudDeclineRecentSale = 1;
    } else {
        var siteFraudDeclineRecentSale = 0;
    }
    if (siteFraudClickSeconds == "" || siteFraudSaleSeconds == ""|| siteLoginRetry == "" || siteLoginDelay == "") {
        errorSound.play();
        Command: toastr["error"](
            " ",
            "You have some input Errors"
        );
        if (siteFraudClickSeconds == "") {
            $(".siteFraudClickSecondsErr").html(
                "Please input something in Fraud Click Seconds"
            );
        } else {
            $(".siteFraudClickSecondsErr").html("");
        }

        if (siteFraudSaleSeconds == "") {
            $(".siteFraudSaleSecondsErr").html(
                "Please input something in Fraud Sale Seconds"
            );
        } else {
            $(".siteFraudSaleSecondsErr").html("");
        }
        if (siteLoginRetry == "") {
            $(".siteLoginRetryErr").html(
                "Please input something in Login Retry  Seconds"
            );
        } else {
            $(".siteLoginRetryErr").html("");
        }
        if (siteLoginDelay == "") {
            $(".siteLoginDelayErr").html(
                "Please input something in Login Delay Seconds"
            );
        } else {
            $(".siteLoginDelayErr").html("");
        }
    } else if (siteFraudSaleSeconds > 30) {
        $(".siteFraudSaleSecondsErr").html("Limit 30 Seconds");
    } else if (siteFraudClickSeconds > 30) {
        $(".siteFraudClickSecondsErr").html("Limit 30 Seconds");
    }
    else if (siteLoginRetry > 30) {
        $(".siteLoginRetryErr").html("Limit 30 Seconds");
    }
    else if (siteLoginDelay > 30) {
        $(".siteLoginDelayErr").html("Limit 30 Seconds");
    }  else {
        $(".siteLoginDelayErr").html("");
        $(".siteLoginRetryErr").html("");
        $(".siteFraudSaleSecondsErr").html("");
        $(".siteFraudClickSecondsErr").html("");

        let _token = $("input[name=_token]").val();
        let _url = "/Options/UpdateFraudSetting";

        $.ajax({
            url: UpdateFraudSettingURL,
            data: {
                siteFraudRecentClick: siteFraudRecentClick,
                siteFraudClickSeconds: siteFraudClickSeconds,
                siteFraudClickAction: siteFraudClickAction,
                siteFraudRecentSale: siteFraudRecentSale,
                siteFraudSaleSeconds: siteFraudSaleSeconds,
                siteFraudSaleAction: siteFraudSaleAction,
                siteFraudDeclineRecentSale: siteFraudDeclineRecentSale,
                siteLoginRetry: siteLoginRetry,
                siteLoginDelay: siteLoginDelay,
            },
            _token: _token,
            type: "POST",
        })
            .done(function (response) {
                console.log("Fraudsettings Rsponse = ", response);
                if (response == 1) {
                    gateWaysTable.ajax.reload();
                    successSound.play();
                    Command: toastr["success"](
                        "Fraudsettings Updated successfully",
                        "Success"
                    );
                } else if (response == 0) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Please Modify something");
                } else {
                    errorSound.play();
                    Command: toastr["error"](
                        " ",
                        "Error in Updating Fraudsettings"
                    );
                }
            })
            .fail(function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Updating Fraud Settings = " + thrownError);
            });
    }
}

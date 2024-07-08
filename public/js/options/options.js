

$(document).ready(function () {
    $('a[data-toggle=tab]').addClass('btn btn-primary ');
    $('a[data-toggle=tab]').css('text-align','left');
    $('li.active:first-child').addClass('btn bg-white text-dark');

    $('a[data-toggle=tab]').on('mouseover', function() {
        $(this).addClass('text-dark bg-white');
    });
    $('a[data-toggle=tab]').on('mouseout', function() {
        $(this).removeClass('text-dark bg-white');
    });
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $(".RecurringDiv").hide();


    getPaymentGateways();
    getcatagories();
    getMerchantEvents();
    getAdminMailOptions();
    getCurrencies();
    getMailList();
    fillEventsMailSetup();
    getMailSetup();
    dataAffiliategroup();
    Dataipcontry();
    DataAdmin();
    $("button[name=adminAddBtn]").show();
    $("button[name=adminUpdateBtn]").hide();
    $("button[name=adminCancelBtn]").hide();
    $("button[name=languagesUpdateBtn]").hide();
    $("button[name=languagesCancelBtn]").hide();
    getSiteLanguages();
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-bottom-right",
        preventDuplicates: true,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
});

function showDiv(Type) {
    console.log("Type ", Type.value);
    if (Type.value == 2 || Type.value == 0) {
        $(Type).prop('checked',true);
        $("." + Type.name).show();
    }
    if (Type.value == 1) {
        $(Type).prop('checked',true);
        $("." + Type.name).hide();
    }
}

function updateEmail() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let email = $("input[name=userEmail]").val();
    let _token = $("input[name=_token]").val();
    let _url = "/Options/UpdateUserEmail";

    if (email == "") {
        $(".userEmailErr").html("Email cannot be empty");
    } else if (email.length < 10) {
        $(".userEmailErr").html("Email Must be 10 Characters or more");
    } else {
        $(".userEmailErr").html("");
        $.ajax({
            url: updateEmailURL,
            data: {
                email: email,
            },
            _token: _token,
            type: "POST",
            success: function (response) {},
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Updating Email = " + thrownError);
            },
        }).done(function (response) {
            console.log("Email Update Rsponse = ", response);
            if (response == 1) {
                successSound.play();
                Command: toastr["success"](
                    "Email Updated successfully",
                    "Success"
                );
            } else if (response == 0) {
                errorSound.play();
                Command: toastr["error"](" ", "Email Already Exists");
            } else if (response == "inValid") {
                errorSound.play();
                Command: toastr["error"](" ", "InValid Email Address");
            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error in Updating Email");
            }
        });
    }
}

function updateUserName() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let userName = $("input[name=userName]").val();
    let _token = $("input[name=_token]").val();
    let _url = "/Options/UpdateUserName";
    if (userName == "") {
        $(".userNameErr").html("username cannot be empty");
    } else if (userName.length < 5) {
        $(".userNameErr").html("username Must be 5 Characters or more");
    } else {
        $(".userNameErr").html("");

        $.ajax({
            url: updateUserNameURL,
            data: {
                username: userName,
            },
            _token: _token,
            type: "POST",
            success: function (response) {},
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Updating Username = " + thrownError);
            },
        }).done(function (response) {
            console.log("Email Update Rsponse = ", response);
            if (response == 1) {
                $("span.username").html(userName);
                successSound.play();
                Command: toastr["success"](
                    "Username Updated successfully",
                    "Success"
                );
            } else if (response == 0) {
                errorSound.play();
                Command: toastr["error"](" ", "Username Already Exists");
            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error in Updating Username");
            }
        });
    }
    }
    $("input[name=userPassword] ,input[name=userConfirmPassword]").on(
        "keyup",
        function () {
            var pass = $("input[name=userPassword]").val();
            var cPass = $("input[name=userConfirmPassword]").val();

            if (pass == cPass && pass != "" && cPass != "") {
                $("#userConfirmPasswordError").html("Passwords Matched");
                $("#userConfirmPasswordError").addClass("text-success");
            } else if (pass != cPass) {
                $("#userConfirmPasswordError").html("Passwords do not Match");
                $("#userConfirmPasswordError").addClass("text-error");
            } else if (pass.length < 8) {
                $("#userConfirmPasswordError").html(
                    "Password Must be 8 Characters or more"
                );
                $("#userConfirmPasswordError").addClass("text-danger");
            } else {
                $("#userConfirmPasswordError").empty();
            }
        }
        );

    function updateUserPassword() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        let userCurrentPassword = $("input[name=userCurrentPassword]").val();
        let userPassword = $("input[name=userPassword]").val();
        var cPass = $("input[name=userConfirmPassword]").val();
        if (userCurrentPassword == "" || userPassword == "" || cPass == "") {
            if (userCurrentPassword == "") {
                $(".userCurrentPasswordErr").html(
                    "Current Password cannot be Empty"
                );
            } else {
                $(".userCurrentPasswordErr").html("");
            }
            if (userPassword == "") {
                $(".userPasswordErr").html("New Password cannot be Empty");
            } else {
                $(".userPasswordErr").html("");
            }
            if (cPass == "") {
                $(".userConfirmPasswordErr").html(
                    "Confirm Password cannot be Empty"
                );
            } else {
                $(".userConfirmPasswordErr").html("");
            }
        } else if (userPassword.length < 8) {
            $(".userPasswordErr").html("Password Must be 8 Characters or more");
        } else {
            $(".userCurrentPasswordErr").html("");
            $(".userPasswordErr").html("");
            $(".userConfirmPasswordErr").html("");

            let _token = $("input[name=_token]").val();
            let _url = "/Options/UpdateUserPassword";

            $.ajax({
                url: updateUserPasswordURL,
                data: {
                    currentPassword: userCurrentPassword,
                    Password: userPassword,
                },
                _token: _token,
                type: "POST",
                success: function (response) {},
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("Error in Updating Password = " + thrownError);
                },
            }).done(function (response) {
                console.log("Password Update Rsponse = ", response);
                if (response == 1) {
                    successSound.play();
                    Command: toastr["success"](
                        "Password Updated successfully",
                        "Success"
                    );
                } else if (response == 2) {
                    errorSound.play();
                    Command: toastr["error"](" ", "You Entered Wrong Password");
                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in Updating Password");
                }
            });
        }
    }

    function updateSiteInfo() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        let siteTitle = $("input[name=siteTitle]").val();
        let siteLines = $("input[name=siteLines]").val();
        let _token = $("input[name=_token]").val();
        let _url = "/Options/UpdateSiteInfo";
        if (siteTitle == "" || siteLines == "") {
            if (siteTitle == "") {
                $(".siteTitleErr").html("Site Title cannot be Empty");
            } else {
                $(".siteTitleErr").html("");
            }
            if (siteLines == "") {
                $(".siteLinesErr").html("site Lines cannot be Empty");
            } else {
                $(".siteLinesErr").html("");
            }
        } else if (siteTitle.length < 8) {
            $(".siteTitleErr").html("Site Title be 8 Characters or more");
        } else if (siteTitle.length > 25) {
            $(".siteTitleErr").html("Site Title Length is Too Long");
        } else if (siteLines > 25) {
            $(".siteLinesErr").html("Site Lines must be less than 25");
        } else {
            $(".siteLinesErr").html("");
            $(".siteTitleErr").html("");

            $.ajax({
                url: updateSiteInfoURL,
                data: {
                    siteTitle: siteTitle,
                    siteLines: siteLines,
                },
                _token: _token,
                type: "POST",
                success: function (response) {},
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("Error in Updating Password = " + thrownError);
                },
            }).done(function (response) {
                console.log("Password Update Rsponse = ", response);
                if (response == 1) {
                    successSound.play();
                    Command: toastr["success"](
                        "Site info Updated successfully",
                        "Success"
                    );
                } else if (response == 0) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Please Modify something");
                } else {
                    errorSound.play();
                    Command: toastr["error"](
                        " ",
                        "Error in Updating Site Info"
                    );
                }
            });
        }
    }

    function updateSiteError() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        let siteError = $("textarea[name=siteError]").val();

        let _token = $("input[name=_token]").val();
        let _url = "/Options/UpdateSiteError";
        if (siteError == "") {

                $(".siteErrorErr").html("Site Error cannot be Empty");

        }else if (siteError.length <  30) {

            $(".siteErrorErr").html("Site Error cannot be less than 30 Characters");

    } else {
            $(".siteErrorErr").html("");


        $.ajax({
            url: updateSiteErrorURL,
            data: {
                siteError: siteError,
            },
            _token: _token,
            type: "POST",
            success: function (response) {},
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Updating Site Error Page = " + thrownError);
            },
        }).done(function (response) {
            console.log("Error  Update Rsponse = ", response);
            if (response == 1) {
                successSound.play();
                Command: toastr["success"](
                    "Site Error  Updated successfully",
                    "Success"
                );
            } else if (response == 0) {
                errorSound.play();
                Command: toastr["error"](" ", "Please Modify something");
            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error in Updating Site Error");
            }
        });
    }

}
function backup(){
    $.ajax({
        url: BackupURL,
        type: "GET",
    }).done(function (response) {
        if(response==1){
            successSound.play();
            Command: toastr["success"](
                "Backed Up your Database Successfully",
                "Success"
            );
        
    } else {
        errorSound.play();
        Command: toastr["error"](" Error in Taking Backup of Database", "Error");
    }


    });
}

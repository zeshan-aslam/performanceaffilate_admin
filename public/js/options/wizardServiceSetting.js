function addNewAccount() {
  let wizardAccountType = $("select[name=wizardAccountType]").val();
  console.log("Account selected: ", wizardAccountType);
  console.log("URL here: ", ADDWizardAccountTypeURL);

  let _token = $("input[name=_token]").val();
  console.log("Token here: ", _token);

  let _url = "/Options/ADDWizardAccountType";
  $.ajax({
    url: ADDWizardAccountTypeURL, // or url: _url,
    data: {
      wizardAccountType: wizardAccountType,
      _token: _token,
    },
    type: "POST",
  })
    .done(function (response) {
      console.log("Add new Account Response: ", response);
      if (response == 1) {
        successSound.play();
        toastr["success"]("New Account is added successfully", "Success");
      } else if (response == 0) {
        errorSound.play();
        toastr["error"]("Account Type Already Exists!", "Error");
      } else {
        errorSound.play();
        toastr["error"]("Error in Adding New Account!", "Error");
      }
    })
    .fail(function (xhr, ajaxOptions, thrownError) {
      console.log("Error in Adding New Account: ", thrownError);
      console.log("Error response: ", xhr.responseText);
    });
}

function getAccountType() {
  let availableAccountType = $("select[name=availableAccountType]").val();
  if (availableAccountType == "0") {
    Command: toastr["error"]("Please Select Event", "Error");
  } else {
    let _token = $("input[name=_token]").val();
    let _url = "Options/GETWizardAccountType";
    $.ajax({
      url: GETWizardAccountTypeURL,
      data: {
        availableAccountType: availableAccountType,
      },
      _token: _token,
      type: "POST",
    })
      .done(function (response) {
        console.log("Get Wizard Account Response= ", response);

        if (response !== false) {
          successSound.play();
          Command: toastr["success"]("Content Found!", "Success");
          CKEDITOR.instances.wizardContentBody.setData(
            response[0].include_service_body
          );
        } else {
          errorSound.play();
          toastr["error"](
            "Content not found against this Account Type!",
            "Error"
          );
        }
      })
      .fail(function (xhr, ajaxOptions, thrownError) {
        console.log("Error in Sending Test Mail = " + thrownError);
      });
  }
}
function updateWizardServiceContent() {
  console.log("Updating Wizard Service Content");
  let availableAccountType = $("select[name=availableAccountType]").val();
  var bodyContent = CKEDITOR.instances.wizardContentBody.getData();

  if (availableAccountType == "0") {
    Command: toastr["error"]("Please Select An Account Type", "Error");
  } else {
    let _token = $("input[name=_token]").val();
    let _url = "Options/UpdateWizardServiceContent";
    $.ajax({
      url: UpdateWizardServiceContentURL,
      data: {
        availableAccountType: availableAccountType,
        bodyContent: bodyContent,
      },
      _token: _token,
      type: "POST",
    })
      .done(function (response) {
        console.log("Updated Wizard Content Account Response= ", response);
        // console.log(
        //   "Updated Wizard Content Response body = ",
        //   response[0].include_service_body
        // );

        if (response !== false) {
          successSound.play();
          Command: toastr["success"](
            "Content Updated Successfully!",
            "Success"
          );
          CKEDITOR.instances.wizardContentBody.setData(
            response[0].include_service_body
          );
        } else if (response == false) {
          errorSound.play();
          toastr["error"](
            "Content not Updated against this Account Type!",
            "Error"
          );
        }
      })
      .fail(function (xhr, ajaxOptions, thrownError) {
        console.log("Error in Sending Test Mail = " + thrownError);
      });
  }
}

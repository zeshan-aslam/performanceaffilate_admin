function getcatagories() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let _url = "/Options/Getcatagories";

    $.ajax({
        url: GetcatagoriesURL,
        type: "GET",
        success: function (response) {},
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("Error in Getting Cataory = " + thrownError);
        },
    }).done(function (response) {
        console.log("Catagory Response  = ", response);
        $("select[name=catName]").empty();
        var option = "";
        for (var i = 0; i < response.length; i++) {
            var catName = response[i].cat_name;
            var catId = response[i].cat_id;

            option += "<option value='" + catId + "'>" + catName + "</option>";
        }
        $("select[name=catName]").append(option);
    });
}

function insertCatagory() {
    var catName = $("input[name=catName]").val();
    let _token = $("input[name=_token]").val();
    let _url = "/Options/InsertCatagory";
    if (catName == "") {
        $(".catNameErr").html("Catagory cannot be Empty");
    } else if (catName.length > 40) {
        $(".catNameErr").html("Catagory cannot be more than 20 Characters");
    } else {
        $(".catNameErr").html("");
        $.ajax({
            url: InsertCatagoryURL,
            data: {
                catName: catName,
            },
            _token: _token,
            type: "POST",
            success: function (response) {},
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("Error in Adding Catagory = " + thrownError);
            },
        }).done(function (response) {
            console.log("Catagory Deleting Rsponse = ", response);
            if (response == 1) {
                $("input[name=catName]").val('');
                getcatagories();

                successSound.play();
                Command: toastr["success"](
                    catName + " Added successfully",
                    "Success"
                );
            } else if (response == 0) {
                errorSound.play();
                Command: toastr["error"](" ", "Catagory Already Exists");
            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error in Adding Catagory");
            }
        });
    }
}
function deleteCatagory() {
    var catId = $("select[name=catName]").val();
    let _token = $("input[name=_token]").val();
    let _url = "/Options/DeleteCatagory";

    $.ajax({
        url: DeleteCatagoryURL,
        data: {
            catId: catId,
        },
        _token: _token,
        type: "POST",
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("Error in Adding Catagory = " + thrownError);
        },
    }).done(function (response) {
        console.log("Catagory Adding Rsponse = ", response);
        if (response == 1) {
            getcatagories();
            $("input[name=catName]").val("");

            successSound.play();
            Command: toastr["success"](" Deleted successfully", "Success");
        } else if (response == 0) {
            errorSound.play();
            Command: toastr["error"](" ", "Catagory Already Deleted");
        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Error in Deleting Catagory");
        }
    });
}

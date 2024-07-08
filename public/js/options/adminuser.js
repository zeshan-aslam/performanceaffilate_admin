var successSound = new Audio("../../audio/success.mp3");
var errorSound = new Audio("../../audio/error.mp3");
var warningSound = new Audio("../../audio/warning.wav");
var table;

function insertadmin() {

    let _token = $("input[name=_token]").val();
    let id= $("input[name=id]").val();
    let username = $("input[name=username]").val();
    let password = $("input[name=password]").val();
    let email = $("input[name=email]").val();
    if(username=='' ||password=='' ||email==''){
        errorSound.play();
        Command: toastr["error"]("Please Input All Fields ", "Error");
    }
    else{

    let _url = insertAdminuserURL;

    $.ajax({
        url: _url,
        data: {
            id:id,
            username: username,
            password: password,
            email: email,
        },
        _token: _token,
        type: "POST",
    }).done(function (data) {
        console.log(data);
        table.ajax.reload();
        if (data == 1) {
            table.ajax.reload();
           $("input[name=username]").val('');
          $("input[name=password]").val('');
           $("input[name=email]").val('');
            successSound.play();
            Command: toastr["success"](
                "Admin User Added Successfully",
                "Success"
            );
        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Unknown error!.  Insertion Failed");
        }
    });
}
}


function DataAdmin() {
    table = $("#admintable")
        .on("init.dt", function () {
            console.log(
                "Table DataCountryIP complete: " + new Date().getTime()
            );
        })
        .DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            ajax: UserAdmintableURL,

            stateSave: true,
            autoWidth: false,

            columns: [
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.adminusers_login;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.adminusers_password;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.adminusers_email;
                    },
                },

                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return (
                            "<a  href='javascript:;' class=' editAdminuser btn btn-primary btn-sm'  ><i class='icon-pencil icon-white'></i> Edit</a> &nbsp;" +
                            "<a href='"+privilegesURL+"/"+
                            row.adminusers_id +
                            "' class='btn btn-warning btn-sm'><i class='icon-eye-open'></i> Privileges</a> &nbsp;" +
                            "<a  href='javascript:;' class='btn btn-danger btn-sm' onclick='javascript:deleteAdminuser(" +
                            row.adminusers_id +
                            ")' ><i class='icon-remove icon-white'></i> Delete</a> "
                        );
                    },
                },
            ],
            order: [[1, "asc"]],
        });
}

$("#admintable tbody").on("click", ".editAdminuser", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    editAdminuser(row.data());
});
function editAdminuser(row) {
    $("input[name=id]").val(row.adminusers_id);
    $("input[name=username]").val(row.adminusers_login);
    $("input[name=password]").val(row.adminusers_password);
    $("input[name=email]").val(row.adminusers_email);

    $("button[name=adminAddBtn]").hide();
    $("button[name=adminUpdateBtn]").show();
    $("button[name=adminCancelBtn]").show();
}

function updateAdmin() {
    let adminId = $("input[name=id]").val();
    let adminusername = $("input[name=username]").val();
    let adminpassword = $("input[name=password]").val();
    let adminemail = $("input[name=email]").val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "post",
        url: updateAdminURL,
        data: {
            id: adminId,
            adminusername: adminusername,
            adminpassword: adminpassword,
            adminemail: adminemail,
        },
        _token: _token,
    }).done(function (data) {
        console.log(data);
        table.ajax.reload();
        if (data == 1) {
            table.ajax.reload();
            successSound.play();
            Command: toastr["success"](
                "Admin User Update Successfully",
                "Success"
            );
        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Unknown error!.  Insertion Failed");
        }
    });
    $("button[name=adminAddBtn]").show();
    $("button[name=adminUpdateBtn]").hide();
    $("button[name=adminCancelBtn]").hide();
    $("input[name=username]").val("");
    $("input[name=password]").val("");
    $("input[name=email]").val("");
}

function cancelAdmin() {
    $("button[name=adminAddBtn]").show();
    $("button[name=adminUpdateBtn]").hide();
    $("button[name=adminCancelBtn]").hide();
    $("input[name=username]").val("");
    $("input[name=password]").val("");
    $("input[name=email]").val("");
}

function updatePriviliges(checkbox) {
    console.log(checkbox.id);
        var checkid=checkbox.id;
        var isCheck
    if (checkbox.checked) {
         isCheck=1;
    }
    else{
        isCheck=0;
    }

        let _token = $("input[name=_token]").val();
        let userId = $("input[name=userId]").val();

        $.ajax({
            method: "get",
            url: checkboxPrivilegesURL,
            data: {
                isCheck:isCheck,
                id: checkid,
                userid: userId,
            },
            _token: _token,
        }).done(function (data) {
            console.log(data);

            warningSound.play();

            if (data == 1) {
                successSound.play();
                Command: toastr["success"](" Successfully Link Privilege Updated ","Success");
            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Not Update Data Link Privilege");
            }
        });

}


function deleteAdminuser(id) {
    $.ajax({
        type: "post",
        url:ShowAdminURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log(data);

        adminusers_id = data.adminusers_id;
        console.log(data);
        warningSound.play();
        Swal.fire({
            title:
                "Are you sure you want to Delete? " +
                data.adminusers_login +
                " ?",
            text: "You won't be able to revert this",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it",
        }).then((result) => {
            if (result.isConfirmed) {
                let _token = $("input[name=_token]").val();
                $.ajax({
                    type: "POST",
                    url: DeleteAdminURL,
                    data: {
                        id: id,
                    },
                    _token: _token,
                }).done(function (data) {
                    console.log("Deleteeeeed", data);
                    table.ajax.reload();
                    if (data == 1) {
                        Swal.fire(
                            "Deleted",
                            "Admin Users has been Delete Successfully",
                            "success"
                        );
                        successSound.play();
                    }
                });
            }
        });
    });
}

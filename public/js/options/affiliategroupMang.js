
var affgrouptable;


function insertgroupMang() {

    console.log("AffiliateGroup Management");

    let _token = $("input[name=_token]").val();
    let grouptitle = $("input[name=grouptitle]").val();
    let categorylevel = $("select[name=categorylevel]").val();

       console.log(categorylevel);

    let _url = affiliategroupURL;
    console.log(_url);
    $.ajax({
        url: _url,
        data: {
            grouptitle: grouptitle,
            categorylevel: categorylevel,

        },
        _token: _token,
        type: "POST",
    }).done(function (data) {
        console.log(data);
        affgrouptable.ajax.reload();
        if (data == 1) {
            affgrouptable.ajax.reload();
            successSound.play();
            Command: toastr["success"](
                "Affiliate Group Management Added Successfully",
                "Success"
            );
        } else {
            errorSound.play();
            Command: toastr["error"](" ", "Unknown error!.  Insertion Failed");
        }
    });
}

function dataAffiliategroup() {
    affgrouptable = $("#affgrouptable")
        .on("init.dt", function () {
            console.log("Table Data AffiliateGroup" );
        })
        .DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            ajax: getAffgroupURL,

            stateSave: true,
            autoWidth: false,
            columns: [

                {
                    data: 'affiliategroup_title',
                },
                {
                    data: 'affiliategroup_levels',
                },

                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return (
                            "<a  href='javascript:;' class='editAffgroup btn btn-primary btn-sm'  ><i class='icon-pencil icon-white'></i> Edit</a> &nbsp;" +
                            "<a  href='javascript:;' class='btn btn-danger btn-sm' onclick='javascript:deleteAffgroupMang(" + row.affiliategroup_id + ")' ><i class='icon-remove icon-white'></i> Delete</a> &nbsp;" +
                            "<a  href='javascript:;' class='setcmn btn btn-warning btn-sm' onclick='javascript:SetCommission(" + row.affiliategroup_id + ")' ><i class='icon-money'></i> Set Commession</a> ");

                        },
                },
            ],
            order: [[1, "asc"]],
        });
}

$("#affgrouptable tbody").on("click", ".editAffgroup", function () {
    successSound.play();
    var tr = $(this).closest("tr");
    var row = affgrouptable.row(tr);
    editAffgroup(row.data());
});
$("#affgrouptable tbody").on("click", ".setcmn", function () {
    var tr = $(this).closest("tr");
    var row = affgrouptable.row(tr);
    SetCommission(row.data());

});

function editAffgroup(data) {
    $("input[name=id]").val(data.affiliategroup_id);
    $("input[name=grouptitle]").val(data.affiliategroup_title);
    $("select[name=categorylevel]").val(data.affiliategroup_levels);

    $("button[name=adminAddBtn]").hide();
    $("button[name=adminUpdateBtn]").show();
    $("button[name=adminCancelBtn]").show();
}

function cancelAdmin() {
    $("button[name=adminAddBtn]").show();
    $("button[name=adminUpdateBtn]").hide();
    $("button[name=adminCancelBtn]").hide();
    $("input[name=grouptitle]").val("");
    $("select[name=categorylevel]").val("");
}

function updateAffgroup() {

    let _token = $("input[name=_token]").val();
    let groupid = $("input[name=id]").val();
    let grouptitle = $("input[name=grouptitle]").val();
    let categorylevel = $("select[name=categorylevel]").val();

    let _url = updateAffgroupURL;
    $.ajax({
        url: _url,
        data: {
            groupid:groupid,
            grouptitle: grouptitle,
            categorylevel: categorylevel,
        },
        _token: _token,
        type: "POST",
    }).done(function (data) {
        console.log(data);
        affgrouptable.ajax.reload();
        if (data == 1) {
            affgrouptable.ajax.reload();
            successSound.play();
            Command: toastr["success"](
                "Affiliate Group Management Update Successfully",
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
    $("input[name=grouptitle]").val("");
    $("select[name=categorylevel]").val("");
}




function deleteAffgroupMang(id) {
    $.ajax({
        type: "post",
        url: ShowAffgroupURL,
        data: {
            id: id,
        },
    }).done(function (data) {
        console.log(data);

        affiliategroup_id = data.affiliategroup_id;
        console.log(data);
        warningSound.play();
        Swal.fire({
            title:
                "Are you sure you want to Delete? " +
                data.affiliategroup_title +
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
                    url: "Options/deleteAffgroup",
                    data: {
                        id: id,
                    },
                    _token: _token,
                }).done(function (data) {
                    console.log("Deleteeeeed", data);
                    affgrouptable.ajax.reload();
                    if (data == 1) {
                        Swal.fire(
                            "Deleted",
                            "Affiliate Group Management has been Delete Successfully",
                            "success"
                        );
                        successSound.play();
                    }
                });
            }
        });
    });
}


function SetCommission(groupid) {
    let _token = $("input[name=_token]").val();

    let _url = "Options/setCommission";
    console.log(groupid);
    $.ajax({
        url: _url,
        data: {
            groupid: groupid,
        },
        _token: _token,

    }).done(function (data) {
        console.log(data);
        let text = '';
        text += '<form>';
        text += '<table class="table">';
        for ($i = 1; $i <=data.affiliategroup_levels; $i++) {
            text += '<tr>';
            text += '<td><label class="text-center"><b>LEVEL_' + $i + '</b></label></td>';
            text += '</tr>';
            text += '<tr>';
            text += '<td style="display: inline-flex; align-items: baseline;">';
            text += '<label class="text-center"><b>Commission&nbsp;&nbsp;</b></label>';
            text += '<input type="text" name="txt_commission_' + $i + '" value=' + data.commission_amount + ' "maxlength="10" size="10" /> &nbsp;';
            if (data.commission_type == "percentage") {
                text += '<input type="radio" name="radio_type_' + $i + '"  value="flatrate"  maxlength="10" size="10"/>';
                text += ' &nbsp;<label><b>$</b></label> &nbsp;';
                text += '<input type="radio" name="radio_type_' + $i + '"  value="percentage"   checked="checked"  maxlength="10" size="10" />';
                text += ' &nbsp;<label><b>%</b></label>';
            }
            else {
                text += '<input type="radio" name="radio_type_' + $i + '"  value="flatrate" checked="checked"   maxlength="10" size="10"/>';
                text += ' &nbsp;<label><b>$</b></label> &nbsp;';
                text += '<input type="radio" name="radio_type_' + $i + '"  value="percentage"   maxlength="10" size="10" />';
                text += ' &nbsp;<label><b>%</b></label>';
            }
            text += '</td></tr>';
        }
        text += '</table>';
        text += '</form>';
        console.log("Set comession", data);
        warningSound.play();
        Swal.fire({
            title: 'Set Commission Group Of Affiliate, ' + data.affiliategroup_title,
            html: text,
            confirmButtonText: 'Set Commission',
            focusConfirm: false,
            showCloseButton: true,
            preConfirm: () => {
                let commission =[];
                let radio =[];
                for ($i = 1; $i <=data.affiliategroup_levels; $i++) {
                    commission[$i] = Swal.getPopup().querySelector('input[name=txt_commission_'+$i+']').value
                radio[$i] = Swal.getPopup().querySelector('input[name=radio_type_'+$i+']:checked').value
                }
                return {
                    commission: commission,
                    radio:radio,
                }
            }

        }).then((result) => {
            console.log(result);
            let _token = $("input[name=_token]").val();
            if(result.isConfirmed){
                $.ajax({
                    type: "post",
                    url: "Options/submitCommission",
                    data: {
                        id: data.affiliategroup_id,
                        commission:result.value.commission,
                        radio:result.value.radio,
                    },
                    _token: _token,
 
                }).done(function (data) {
                    console.log("assign comission", data);
                    if (data == 200) {
                        table.ajax.reload();
                        successSound.play();
                        Command: toastr["success"](
                            "Tier Commission Group Assigned to Affiliate", "Success")
    
                    }
                     else if(data==201) {
                        errorSound.play();
                        Command: toastr["error"](" ",
                        "Please enter a valid amount for commission")
                    } 
    
                });
            }          

        });

    });
}


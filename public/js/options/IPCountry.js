var iptable
function Dataipcontry() {

     iptable = $("#ipcountrytable")
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
            ajax: IPcountryURL,

            stateSave: true,
            "autoWidth": false,

            columns: [
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.ip_from;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.ip_to;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.country_code2;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.country_code3;
                    },
                },
                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return row.country_name;
                    },
                },

                {
                    _: "plain",
                    data: null,
                    render: function (row, data, type) {
                        return (
                            "<a  href='javascript:;' class='btn btn-primary btn-sm' onclick='javascript:UpdateIP(" +
                            row.ip_from + ")' ><i class='icon-pencil icon-white'></i> Edit</a> &nbsp;"+
                            "<a  href='javascript:;' class='btn btn-danger btn-sm' onclick='javascript:deleteAffiliateModel(" +
                            row.ip_from + ")' ><i class='icon-remove icon-white'></i> Delete</a> "
                        );
                    },
                },

            ],
            order: [[1, "asc"]],
        });

    $("#ipcountrytable tbody").on(
        "click",
        "tr td.affiliate-control,.affiliate-control",
        function () {
            var tr = $(this).closest("tr");
            var row = iptable.row(tr);
            formatAffiliate(row.data());
        }
    );

    // Array to track the ids of the details displayed rows
    var detailRows = [];

    $("#ipcountrytable tbody").on("click", "tr td.details-control", function () {
        var tr = $(this).closest("tr");
        var i = $(this).closest("i.icon-plus-sign");
        var row = iptable.row(tr);
        var idx = $.inArray(tr.attr("id"), detailRows);

        if (row.child.isShown()) {
            i.removeClass("icon-minus-sign");
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            i.addClass("icon-minus-sign");
            row.child(format(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr("id"));
            }
        }
    });
    iptable.on("draw", function () {
        $.each(detailRows, function (i, id) {
            $("#" + id + " td.details-control").trigger("click");
        });
    });
}


function UpdateIP(id) {
    let _token = $('input[name=_token]').val();
    $.ajax({
        type: "GET",
        url: EditIPgetURL+"/"+ id,

    }).done(function(data) {
        console.log(data);
        iptable.ajax.reload();
        warningSound.play();

        Swal.fire({
            title: '<strong style="font-family:cambria; color:orange">Update IP Country</strong>',
            html: "<div class='form-horizontal'>" +

                "<div class='control-group'>" +
                "<label class='control-label'>From</label>" +
                "<div class='controls'>" +
                "  <input name='ip_from' type='number'  value='" + data.ip_from +
                "'  class='input-large'/>" +

                "  </div>" +
                "</div>" +

                "<div class='control-group'>" +
                "<label class='control-label'>To</label>" +
                "<div class='controls'>" +
                "  <input name='ip_to' type='number'  value='" + data.ip_to +
                "'  class='input-large'/>" +

                "  </div>" +
                "</div>" +

                "<div class='control-group'>" +
                "<label class='control-label'>Country Code(2 digit)	</label>" +
                "<div class='controls'>" +
                "  <input name='country_code2' type='text'  value='" + data.country_code2 + "'  class='input-large'/>" +

                "  </div>" +
                "</div>" +

                "<div class='control-group'>" +
                "<label class='control-label'>Country Code(3 digit)	</label>" +
                "<div class='controls'>" +
                "  <input name='country_code3' type='text'  value='" + data.country_code3 + "'  class='input-large'/>" +

                "  </div>" +
                "</div>" +

                "<div class='control-group'>" +
                "<label class='control-label'>Country Name</label>" +
                "<div class='controls'>" +
                "  <input name='country_name' type='text' value='" + data.country_name + "' class='input-large' />" +
                "  </div>" +
                "</div>" +


                "</div>",

            confirmButtonText: 'Update',
            focusConfirm: false,
            showCloseButton: true,
            preConfirm: () => {
                const ip_from = Swal.getPopup().querySelector('input[name=ip_from]').value
                const ip_to = Swal.getPopup().querySelector('input[name=ip_to]').value
                const country_code2 = Swal.getPopup().querySelector('input[name=country_code2]').value
                const country_code3 = Swal.getPopup().querySelector('input[name=country_code3]').value
                const country_name = Swal.getPopup().querySelector('input[name=country_name]').value

                return {
                    ip_from: ip_from,
                    ip_to: ip_to,
                    country_code2: country_code2,
                    country_code3: country_code3,
                    country_name: country_name,
                }
            }

        }).then((result) => {
            console.log(result);

            let _token = $('input[name=_token]').val();
            $.ajax({
                type: "POST",
                url: EditIPURL,
                data: {
                       id: data.ip_from,
                       ip_from: result.value.ip_from,
                       ip_to: result.value.ip_to,
                       country_code2: result.value.country_code2,
                       country_code3: result.value.country_code3,
                       country_name: result.value.country_name,

                },
                _token: _token
            }).done(function(data) {
                console.log("checked update",data);
                if (data == 1) {
                    iptable.ajax.reload();
                    successSound.play();
                    Command: toastr["success"]("Update successfully IP Countries", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Not Update IP Data")

                }

            });


        });



    });
}


function importSql() {
    let _token = $('input[name=_token]').val();
        Swal.fire({
            title: '<strong style="font-family:cambria; color:orange">Update IP to Country Database</strong>',
            html: "<div class='form-horizontal'>" +
                "<div class='control-group'>" +
                "<label class='control-label'>Choose SQL File</label>" +
                "<div class='controls'>" +
                "  <input type='file' name='ip_from'  class='files'/>" +
                "  </div>" +
                "</div>" +
                "</div>",
            confirmButtonText: 'Update',
            focusConfirm: false,
            showCloseButton: true,
            
        }).then((result) => {
            console.log(result);
            let _token = $('input[name=_token]').val();
            if(result.isConfirmed){
                var formData = new FormData();
                var file = $('.files')[0].files[0];
                  formData.append("sqlfile", file);
                console.log(file); 
            $.ajax({
                type: "POST",
                url: "Options/uploadSql",
                data: formData,   
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                _token: _token,               
            })
            .done(function(data) {
                console.log("checked update",data);
                if (data == 1) {
                    iptable.ajax.reload();
                    successSound.play();
                    Command: toastr["success"]("Update successfully IP Countries", "Success")
                }
                if(data==2){
                    errorSound.play();
                    Command: toastr["error"]("", "Data Not Inserted Into Database Successfully!")
                }     
                 
                if(data== 3){
                    errorSound.play();
                    Command: toastr["error"]("", "Please Select Valid Sql File!")
                }                 
             if(data==404){
                        errorSound.play();
                        Command: toastr["error"](" ", "File Not Found!")
    
                }   
            });
        }
        });
    
}

function deleteAffiliateModel(ip_from) {

    $.ajax({
            type: "get",
            url:  EditIPgetURL+"/"+ ip_from,
         

        })
        .done(function(data) {
            console.log(data);

            ip_from = data.ip_from;
            console.log(data);
            warningSound.play();
            Swal.fire({
                title: "Are you sure you want to Delete this IP range? " + data.ip_from + " ?",
                text: "You won't be able to revert this",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it"
            }).then((result) => {
                if (result.isConfirmed) {
                    let _token = $('input[name=_token]').val();
                    $.ajax({
                        type: "POST",
                        url:DeleteIPURL,
                        data: {
                            ip_from: ip_from,

                        },
                        _token: _token,
                    }).done(function(data) {
                        console.log("Deleteeeeed", data);
                        iptable.ajax.reload();
                        if (data == 1) {

                            Swal.fire(
                                "Deleted",
                                "IP-Country has been Delete Successfully",
                                "success"
                            )
                            successSound.play();
                        }

                    });
                }


            })
        });
}

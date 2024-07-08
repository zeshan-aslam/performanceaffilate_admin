function getSiteLanguages() {


    let _url = '/Options/GetSiteLanguages';

    $.ajax({
        url: GetSiteLanguagesURL,
        type: "GET",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Getting Site Language = ' + thrownError);

        },
    }).done(function(response) {
        console.log('Languages Response  = ', response);
        var tr
        var option = '';
        $('#languagesTable tbody').empty();
        for (var i = 0; i < response.length; i++) {
            if (response[i].languages_status == 'inactive') {
                tag = 'muted'

            } else {
                tag = ''
            }
            console.log(i, response[i].languages_name);
            tr = tr + "<tr>" +
                "<td><b class='" + tag + "'>" + response[i].languages_name + "</b></td>" +
                "<td class='float-right'>" +
                "<a href='javascript:;' class='btn btn-primary btn-sm ' onclick='javascript:editLanguage(" +
                response[i].languages_id + ")'><i class='icon-edit'></i></a>" +
                "<a href='javascript:;' class='btn btn-danger btn-sm'  onclick='javascript:deleteLanguage(" +
                response[i].languages_id + ")'><i class='icon-trash'></i></a>" +
                "</td>" +
                " </tr>";

        }
        $('#languagesTable tbody').append(tr);





    });

}

function editLanguage(id) {

    let _url = '/Options/EditLanguage';
    let _token = $('input[name=_token]').val();
    $.ajax({
        url: EditLanguageURL,
        data: {
            languages_id: id,

        },
        _token: _token,
        type: "POST",
        success: function(response) {




        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Getting Site Language = ' + thrownError);

        },
    }).done(function(response) {

        console.log('Edit Language Response  = ', response);
        $('input[name=languages_id]').val(response.languages_id);
        $('input[name=languages_name]').val(response.languages_name);

        if (response.languages_status == "active") {
            $('input[name=languages_status][value=active]').prop('checked', true);

        } else {
            $('input[name=languages_status][value=inactive]').prop('checked', true);
        }
        $('button[name=languagesAddBtn]').hide();
        $('button[name=languagesUpdateBtn]').show();
        $('button[name=languagesCancelBtn]').show();



    });

}

function addLanguage() {

    let languages_name = $('input[name=languages_name]').val();
    let languages_status = $('input[name=languages_status]:checked').val();
    if (languages_name == "" || !$('input[name=languages_status]').is(':checked')) {
        $('#LanguageError').html("Please input all Fields ");

    } else {
        $('#LanguageError').html("");



        let _url = '/Options/AddLanguage';
        let _token = $('input[name=_token]').val();
        $.ajax({
            url: AddLanguageURL,
            data: {
                languages_name: languages_name,
                languages_status: languages_status,

            },
            _token: _token,
            type: "POST",
            success: function(response) {



            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log('Error in Getting Site Language = ' + thrownError);

            },
        }).done(function(response) {
            getSiteLanguages();
            console.log('Update Language Response  = ', response);
            $('input[name=languages_id]').val('');
            $('input[name=languages_name]').val('');
            $('input[name=languages_status]:checked').val('');


        });
    }

}

function cancelLanguage() {
    $('button[name=languagesAddBtn]').show();
    $('button[name=languagesUpdateBtn]').hide();
    $('button[name=languagesCancelBtn]').hide();
    $('input[name=languages_id]').val('');
    $('input[name=languages_name]').val('');
    $('input[name=languages_status]:checked').val('');

}

function updateLanguage() {


    let languages_id = $('input[name=languages_id]').val();
    let languages_name = $('input[name=languages_name]').val();
    let languages_status = $('input[name=languages_status]:checked').val();

    if (languages_name == "" || !$('input[name=languages_status]').is(':checked')) {
        $('#LanguageError').html("Please input all Fields ");

    } else {
        $('#LanguageError').html("");


        let _token = $('input[name=_token]').val();
        let _url = '/Options/UpdateLanguage';
        $.ajax({
            url: UpdateLanguageURL,
            data: {
                languages_id: languages_id,
                languages_name: languages_name,
                languages_status: languages_status,

            },
            _token: _token,
            type: "POST",
            error: function(xhr, ajaxOptions, thrownError) {
                console.log('Error in Update Site Language = ' + thrownError);

            },
        }).done(function(response) {
            console.log('Update Language Response  = ', response);
            $('input[name=languages_id]').val('');
            $('input[name=languages_name]').val('');
            $('input[name=languages_status]:checked').val('');
            $('button[name=languagesAddBtn]').show();
            $('button[name=languagesUpdateBtn]').hide();
            $('button[name=languagesCancelBtn]').hide();
            getSiteLanguages();

        });
    }

}

function deleteLanguage(id) {
    let _url = EditLanguageURL;
    let _token = $('input[name=_token]').val();
    $.ajax({
            url: EditLanguageURL,
            data: {
                languages_id: id,

            },
            _token: _token,
            type: "POST",

        })
        .done(function(data) {
            console.log(data);

            warningSound.play();
            Swal.fire({
                title: "Are you sure you want to delete " + data.languages_name + " ?",
                text: "You won't be able to revert this",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it"
            }).then((result) => {
                if (result.isConfirmed) {


                    let _url = '/Options/DeleteLanguage';
                    let _token = $('input[name=_token]').val();
                    $.ajax({
                        url: DeleteLanguageURL,
                        data: {
                            languages_id: id,

                        },
                        _token: _token,
                        type: "POST",
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert('Error in deleting Site Language = ' + thrownError);

                        },
                    }).done(function(response) {
                        getSiteLanguages();
                        cancelLanguage();
                        console.log('Delete Language Response  = ', response);

                    });
                }


            })



        });


}

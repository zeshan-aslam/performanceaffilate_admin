function getCurrencies() {




    let _url = '/Options/GetCurrencies';

    $.ajax({
        url: GetCurrenciesURL,
        type: "GET",
        success: function(response) {



        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log('Error in Getting Currencies = ' + thrownError);

        },
    }).done(function(data) {
        console.log('Currency Response  = ', response);
        var tr, option;
        $('#currencyTable tbody').empty();
        $('.selectCurrency').empty();
        var response = data['data'];
        for (var i = 0; i < response.length; i++) {

            console.log(i, response[i]);
            tr = tr + "<tr>" +
                "<td>" + (i + 1) + "</td>" +
                "<td><b>" + response[i].currency_caption + "</b></td>" +
                "<td>1" + data['currency'].currency_symbol + "=" + response[i].relation_value + response[i].currency_symbol + "</td>" +
                "<td class='float-right'>" +
                "<a href='javascript:;' class='btn btn-danger btn-sm'  onclick='javascript:deleteCurrency(" +
                response[i].currency_id + ")'><i class='icon-trash'></i></a>" +
                "</td>" +
                " </tr>";
            option = option + "<option value='" +
                response[i].relation_currency_code + "'>" + response[i].currency_caption + "</option>"


        }
        $('.selectCurrency').append(option);

        $('#currencyTable tbody').append(tr);
        $('#baseCurrency').html('<b>Base Currency : ' + data['currency'].currency_caption + "( " + data['currency'].currency_symbol + " ) " + data['currency'].currency_code + "</b>");
        $('#relCurrency').html(' <b> 1 (' + data['currency'].currency_symbol + ")</b> = ")







    });

}

function addCurrency() {

    let curCode = $('input[name=curCode]').val();
    let curCaption = $('input[name=curCaption]').val();
    let curSymbol = $('input[name=curSymbol]').val();
    let curRelation = $('input[name=curRelation]').val();

    if (curCode == "" || curCaption == "" || curSymbol == "" || curRelation == "") {
        Command: toastr["error"](" ", "Please input all Fields");

    }else if ( curRelation >1000) {
        Command: toastr["error"](" Currency Relation is greater than 1000", "Error");

    }
    else {
        $('#LanguageError').html("");



        let _url = '/Options/AddCurrency';
        let _token = $('input[name=_token]').val();
        $.ajax({
            url: AddCurrencyURL,
            data: {
                curCode: curCode,
                curCaption: curCaption,
                curSymbol: curSymbol,
                curRelation: curRelation,

            },
            _token: _token,
            type: "POST",
            success: function(response) {



            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log('Error in Getting Site Language = ' + thrownError);

            },
        }).done(function(response) {
            console.log('Add  Currency  Response  = ', response);
            if (response == 1) {
                $('input[name=curCode]').val('');
                $('input[name=curCaption]').val('');
                $('input[name=curSymbol]').val('');
                $('input[name=curRelation]').val('');

                getCurrencies();
                successSound.play();
                Command: toastr["success"]("Currency Value Updated successfully", "Success");


            } else if (response == 0) {
                errorSound.play();
                Command: toastr["error"](" ", "Please Modify something");

            } else {
                errorSound.play();
                Command: toastr["error"](" ", "Error in updatinf Currency Value");

            }





        });
    }

}

function resetCurrency() {
    $('input[name=relation_value]').val('');
}

function updateCurrencyValue() {
    let selectCurrency = $('select[name=selectCurrency]').val();
    warningSound.play();
    Swal.fire({
        title: "Are you sure you want to Update the Currency Value of " + selectCurrency+ " ?",
        text: "On changing the value of Currency the values of all the transactions will be replaced with the value of the Base Currency",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Change"
    }).then((result) => {
        if (result.isConfirmed) {


            let relation_value = $('input[name=relation_value]').val();
            let _token = $('input[name=_token]').val();
            // let _url = '/Options/UpdateCurrency';
            $.ajax({
                url: UpdateCurrencyURL,
                data: {
                    relation_value: relation_value,
                    relation_currency_code: selectCurrency,

                },
                _token: _token,
                type: "POST",
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log('Error in Update Site Currency = ' + thrownError);

                },
            }).done(function(response) {
                console.log('Update Currency Response  = ', response);
                if (response == 1) {
                    getCurrencies();
                    successSound.play();
                    Command: toastr["success"]("Currency Value Updated successfully", "Success");


                } else if (response == 0) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Please Modify something");

                }
                else if (response == 2) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Not found currency");

                }
                else if (response == 3) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Not All Database Updated with this Currency");

                }else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in changing Currency Value");

                }



            });

        }






    });


}

function deleteCurrency(id) {
    warningSound.play();
    Swal.fire({
        title: "Are you sure you want to delete this Currency ? ",
        text: "You won't be able to revert this",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete"
    }).then((result) => {
        if (result.isConfirmed) {





            let _token = $('input[name=_token]').val();
            let _url = '/Options/DeleteCurrency';
            $.ajax({
                url: DeleteCurrencyURL,
                data: {
                    currency_id: id,

                },
                _token: _token,
                type: "POST",
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log('Error in Deleting Currency = ' + thrownError);

                },
            }).done(function(response) {
                console.log('Update Currency Response  = ', response);
                if (response == 1) {
                    getCurrencies();
                    successSound.play();
                    Command: toastr["success"]("Currency Deleted successfully", "Success");


                } else if (response == 2) {
                    errorSound.play();
                    Command: toastr["error"](" Sorry This Currency is used by some merchant", "Cannot Delete !");
                } else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in Deleting Currency");

                }

            });



        };
    });



}
function changeCurrency() {


    let selectCurrency = $('select[name=selectCurrencyBase]').val();
    warningSound.play();
    Swal.fire({
        title: "Are you sure you want to change Currency  to " + selectCurrency+ " ?",
        text: "On changing the base currency the values of all the transactions will be replaced with the value of the Base Currency",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Change"
    }).then((result) => {
        if (result.isConfirmed) {
            let _token = $('input[name=_token]').val();
            let _url = '/Options/ChangeCurrency';
            $.ajax({
                url: ChangeCurrencyURL,
                data: {
                    curCode: selectCurrency,
                },
                _token: _token,
                type: "POST",
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log('Error in Changing Currency = ' + thrownError);

                },
            }).done(function(response) {
                console.log('Change Currency Response  = ', response);
                if (response == 1) {
                    getCurrencies();
                    successSound.play();
                    Command: toastr["success"]("Currency Value Updated successfully", "Success");


                } else if (response == 0) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Please Modify something");

                }
                else if (response == 2) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Not found currency");

                }
                else if (response == 3) {
                    errorSound.play();
                    Command: toastr["error"](" ", "Not All Database Updated with this Currency");

                }else {
                    errorSound.play();
                    Command: toastr["error"](" ", "Error in changing Currency Value");

                }



            });

        }


    });

}

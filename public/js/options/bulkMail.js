function getMailList(){
    var flag=$('select[name=toGetMail]').val();

    let _token = $('input[name=_token]').val();
    let _url = '/Options/GetMailList';
    $.ajax({
        url: GetMailListURL,
        data: {
            flag: flag,
        },
        _token: _token,
        type: "POST",
    }).done(function(response) {
        let option='';
        console.log('Mail List Rsponse = ', response);
        $('select[name=mailList]').empty();
        $('#numOfMails').html(response.length);
        if(response!=null){
            for (let index = 0; index < response.length; index++) {

                option+="<option value='"+response[index].login_email+"'>"+response[index].login_email+"</option>";
            }
            $('select[name=mailList]').append(option);

        }

    }).fail(function(xhr, ajaxOptions, thrownError){
        console.log('Error in Getting Mail List = ' + thrownError);
    });
}
function sendBulkMail(){
    console.log('Selected Mails',mails);
    var mails=$('select[name=mailList]').val();
    let bulkFrom = $('input[name=bulkFrom]').val();
    let bulkHeader = $('textarea[name=bulkHeader]').val();
    let bulkSubject = $('input[name=bulkSubject]').val();
    let bulkFooter = $('textarea[name=bulkFooter]').val();
    let bulkBody = $('textarea[name=bulkBody]').val();
    if (bulkFrom == "" || bulkHeader == "" || bulkSubject == "" || bulkBody == "") {
        Command: toastr["error"](" ", "Please input all Fields");

    }
    else {

    let _token = $('input[name=_token]').val();
    let _url = '/Options/SendBulkMail';
    $.ajax({
        url: SendBulkMailURL,
        data: {
            mails: mails,
            bulkFrom:bulkFrom,
            bulkHeader:bulkHeader,
            bulkSubject:bulkSubject,
            bulkFooter:bulkFooter,
            bulkBody:bulkBody,
        },
        _token: _token,
        type: "POST",
    }).done(function(response) {
        console.log('Bulk Mail Send  Response= ', response);

    }).fail(function(xhr, ajaxOptions, thrownError){
        console.log('Error in Sending Mail  = ' + thrownError);
    });
   }
}
function sendTestMail(){
    console.log('Selected Mails',to);

    var to=$('input[name=testMailTo]').val();
    let bulkFrom = $('input[name=bulkFrom]').val();
    let bulkHeader = $('textarea[name=bulkHeader]').val();
    let bulkSubject = $('input[name=bulkSubject]').val();
    let bulkFooter = $('textarea[name=bulkFooter]').val();
    let bulkBody = $('textarea[name=bulkBody]').val();
    if (bulkFrom == "" || bulkHeader == "" || bulkSubject == "" || bulkBody == "") {
        Command: toastr["error"](" ", "Please input all Fields");

    }
    else {
    let _token = $('input[name=_token]').val();
    let _url = '/Options/SendBulkMail';
    $.ajax({
        url: SendBulkMailURL,
        data: {
            mails: to,
            bulkFrom:bulkFrom,
            bulkHeader:bulkHeader,
            bulkSubject:bulkSubject,
            bulkFooter:bulkFooter,
            bulkBody:bulkBody,
        },
        _token: _token,
        type: "POST",
    }).done(function(response) {
        console.log('Test Mail Send  Response= ', response);

    }).fail(function(xhr, ajaxOptions, thrownError){
        console.log('Error in Sending Test Mail = ' + thrownError);
    });
}
}

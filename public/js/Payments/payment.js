var successSound = new Audio("../../audio/success.mp3");
var errorSound = new Audio("../../audio/error.mp3");
var warningSound = new Audio("../../audio/warning.wav");

$(document).ready(function() {
    console.log("Payments working ready");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    AffRequest();
    MerRequest();
    ReverseSaletable();
    ReverseRecureSaletable();
    // invoicedata();

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});

var merchantEventsTable;

function getMerchantEvents() {

    merchantEventsTable = $('#merchantEventsTable')
        .on('init.dt', function() {

            console.log('gateWays Table initialisation complete: ' + new Date().getTime());
        })


    .DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],



        "stateSave": true,
        "autoWidth": false,



    });


}

@extends('layouts.masterClone')

@section('title', 'SliderView')

@section('content')

    <div class='row-fluid'>
        <div class="span12">
            @if (Session::has('msg'))
            <div class="alert alert-success text-center">
                <button data-dismiss="alert" class="close" type="button">×</button>
                    <span>{{ Session::get('msg') }}</span>
            </div>
        @endif
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> SliderView</h4>
                    <span class="tools">
                    </span>
                </div>
                <div class="widget-body">
                    <div>
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{ route('searlco.slides')}}" class="btn btn-primary">Add Content</a>
                            </div>
                            <div class="btn-group pull-right">
                                <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i
                                        class="icon-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#">Print</a></li>
                                    <li><a href="#">Save as PDF</a></li>
                                    <li><a href="#">Export to Excel</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="space15"></div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <table id='sliderView' class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>First Button</th>
                                    <th>First Button Href</th>
                                    <th>Second Button</th>
                                    <th>Second Button Href</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>First Button</th>
                                    <th>First Button Href</th>
                                    <th>Second Button</th>
                                    <th>Second Button Href</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE widget-->


        <!-- END -->


    @endsection
    @section('script')

        <script>
            var successSound = new Audio("{{ asset('audio/success.mp3') }}");
            var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
            var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
            $(document).ready(function() {
                var table = '';
                console.log('Merchants ready');


                drawData();

                var merchantId = 0;
                var payMerchantId = 0;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });


                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

            });


            //         function format ( d ) {
            //             var detail='';
            //     detail+= "<tr class='well'>" +
            //            " <td class='text-success'><b>Name</b></td><td>"+d.merchant_firstname+" "+d.merchant_lastname+"</td> <td class='text-success'><b>Company</b></td><td>"+d.merchant_company+"</td> <td class='text-success'><b>Address</b></td><td>"+d.merchant_address+"</td>" +
            //            " <td class='text-success'><b>City</b></td><td>"+d.merchant_city+"</td> <td class='text-success'><b>Country</b></td><td>"+d.merchant_country+"</td> <td class='text-success'><b>Phone</b></td><td>"+d.merchant_phone+"</td>" +

            //            "</tr>";
            //            detail+= "<tr>" +
            //            " <td class='text-success'><b>Catagory</b></td><td>"+d.merchant_category+"</td> <td class='text-success'><b>Status</b></td><td>"+d.merchant_status+"</td> <td class='text-success'><b>Fax</b></td><td>"+d.merchant_fax+"</td>" +
            //            " <td class='text-success'><b>Type</b></td><td>"+d.merchant_type+"</td> <td class='text-success'><b>Currency</b></td><td>"+d.merchant_currency+"</td> <td class='text-success'><b>PGM Approval</b></td><td>"+d.merchant_pgmapproval+"</td>" +

            //            "</tr>";
            //            detail+= "<tr>" +
            //            " <td class='text-success'><b>State</b></td><td>"+d.merchant_state+"</td> <td class='text-success'><b>Zip</b></td><td>"+d.merchant_zip+"</td> <td class='text-success'><b>Tax Id</b></td><td>"+d.merchant_taxId+"</td>" +
            //            " <td class='text-success'><b>Order Id</b></td><td>"+d.merchant_orderId+"</td> <td class='text-success'><b>Sale Amount</b></td><td>"+d.merchant_saleAmt+"</td> <td class='text-success'><b>Invoice Status</b></td><td>"+d.merchant_invoiceStatus+"</td>" +

            //            "</tr>";
            // return detail ;
            // }


            function drawData() {



                table = $('#sliderView')
                    .on('init.dt', function() {

                        console.log('Table initialisation complete: ' + new Date().getTime());
                    })


                    .DataTable({
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        ajax: "{{ route('searlco.getSliderData') }}",

                        "stateSave": true,


                        columns: [
                            // {
                            //     "class": "details-control",
                            //     "orderable": false,
                            //     "data": null,
                            //     "defaultContent": "",
                            //     render: function(data, type) {
                            //         return "<i class='icon-plus-sign'></i>";
                            //     }
                            // },
                            {
                                data: 'id',

                            },
                            {
                                data: 'heading',

                            },
                            {
                                data: 'description',

                            },
                            {
                                data: 'button1',

                            },
                            {
                                data: 'href1',

                            },
                            {
                                data: 'button2',

                            },
                            {
                                data: 'href2',

                            },
                            {
                                data: null,
                                render: function(row, data, type) {
                                    var actions = "";
                                    actions += "<div class='btn-group'>" +
                                        "<button data-toggle='dropdown' class='btn btn-info btn-small dropdown-toggle'>Select Action <span class='caret'></span></button>" +
                                        "<ul class='dropdown-menu'>" +

                                        "<li><a  href='javascript:;' onclick='javascript:updateModel(" +
                                        row
                                        .id + ")'>Update</a></li>" +
                                        "<li><a  href='javascript:;' onclick='javascript:deleteModel(" +
                                        row.id +
                                        ")'  role='button' data-toggle='modal'>Remove</a></li>";

                                    // if (row.merchant_status == 'suspend') {
                                    //     actions +=
                                    //         "<li><a   href='javascript:;' onclick='javascript:approveMerchant(" +
                                    //         row.merchant_id +
                                    //         ")' >Approve</a></li>" +
                                    //         "<li><a  href='javascript:;' onclick='javascript:deleteModel(" +
                                    //         row.merchant_id +
                                    //         ")'  role='button' data-toggle='modal'>Remove</a></li>";
                                    // }

                                    actions += "</ul>" +
                                        "</div>";

                                    return actions;
                                }
                            },
      
                        ],
                        "order": [
                            [1, 'asc']
                        ],


                    });

              


            }

            function deleteModel(id) {

                $.ajax({
                        type: "GET",
                        url: "{{ route('searlco.deleteSliderData') }}",
                        data: {
                            id: id,

                        },

                    })
                    .done(function(data) {

                        id = data.id;
                        console.log(data);
                        warningSound.play();
                        Swal.fire({
                            title: "Are you sure you want to delete " + data.heading + " ?",
                            text: "You won't be able to revert this",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it"
                        }).then((result) => {
                            if (result.isConfirmed) {


                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('searlco.RemoveSliderData') }}",
                                    data: {
                                        id: id,

                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    table.ajax.reload();
                                    if (data == 1) {
                                        Command:toastr["success"]("Row Has Been Remove Successfully")
                                        successSound.play();
                                    }

                                });
                            }


                        })



                    });

            }


            function updateModel(id) {

                $.ajax({
                        type: "GET",
                        url: "{{ route('searlco.EditSliderData') }}",
                        data: {
                            id: id,

                        },

                    })
                    .done(function(data) {
                        id = data.id;
                        console.log(data);
                       
                        Swal.fire({
                            title: "Are you sure you want to Update?",
                            html: "<div class='form-horizontal'>" +

                                "<div class='control-group'>" +
                                "<label class='control-label'>Heading</label>" +
                                "<div class='controls'>" +
                                "  <input name='heading' type='text'  value='" + data.heading +
                                "' placeholder='Email' class='input-large'/>" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +


                                "<div class='control-group'>" +
                                "<label class='control-label'>Descripiton</label>" +
                                "<div class='controls'>" +
                                "  <textarea name='description' type='text' value='"+data.description+"' placeholder='' class='input-large'>"+data.description+"</textarea>" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +

                                "<div class='control-group'>" +
                                "<label class='control-label'>First Button</label>" +
                                "<div class='controls'>" +
                                "  <input name='button1' type='text'value='"+data.button1+"' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>First Button Href</label>" +
                                "<div class='controls'>" +
                                "  <input name='href1' type='text'value='"+data.href1+"' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +

                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Second Button</label>" +
                                "<div class='controls'>" +
                                "  <input name='button2' type='text'value='"+data.button2+"' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Second Button Href</label>" +
                                "<div class='controls'>" +
                                "  <input name='href2' type='text'value='"+data.href2+"' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "</div>",

                            confirmButtonText: 'Update Record',
                            focusConfirm: false,
                            showCloseButton: true,
                            preConfirm: () => {
                            const heading = Swal.getPopup().querySelector(
                                'input[name=heading]').value
                            const desc = Swal.getPopup().querySelector('textarea[name=description]').value
                            const btn1 = Swal.getPopup().querySelector('input[name=button1]').value
                            const btn2 = Swal.getPopup().querySelector('input[name=button2]').value
                            const  href1 = Swal.getPopup().querySelector('input[name=href1]').value
                            const  href2 = Swal.getPopup().querySelector('input[name=href2]').value

                            return {
                                heading: heading,
                                desc: desc,
                                btn1: btn1,
                                btn2:btn2,
                                href1:href1,
                                href2:href2,
                            }



                        }
                      }).then((result) => {
                          console.log(result)
                            if (result.isConfirmed) {


                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "get",
                                    url: "{{ route('searlco.editsSliderData') }}",
                                    data: {
                                        id:data.id,
                                        heading:result.value.heading,
                                        description:result.value.desc,
                                        button1:result.value.btn1,
                                        href1:result.value.href1,
                                        button2:result.value.btn2,
                                        href2:result.value.href2,


                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    console.log(data);
                                    table.ajax.reload();
                                    if (data == 0) {
                                        Command:toastr["error"]("Slider Content Not Updated Successfully")
                                        errorSound.play();
                                        
                                       
                                    }
                                    if(data==1)
                                    {
                                        Command:toastr["success"]("Slider Content Updated Successfully")
                                        successSound.play();
                                    }

                                });
                            }


                        })



                    });

            }


    




        </script>
    @endsection

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
                    <h4> Contact View</h4>
                    <span class="tools">
                    </span>
                </div>
                <div class="widget-body">
                    <div>
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{ route('searlco.contact') }}" class="btn btn-primary">Add Content</a>
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
                                    <th>Address Heading</th>
                                    <th>Address</th>
                                  
                                    <th>Email Heading</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
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
                                    <th>Address Heading</th>
                                    <th>Address</th>
                                   
                                    <th>Email Heading</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
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
                        ajax: "{{ route('searlco.getContactData') }}",

                        "stateSave": true,


                        columns: [
                           
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
                                data: 'address_heading',

                            },
                            {
                                data: 'address_desc',

                            },
                          /*  {
                                data: 'call_heading',

                            },
                            {
                                data: 'call_number',

                            },*/
                            {
                                data: 'email_heading',

                            },
                            {
                                data: 'email_address',

                            },
                            {
                                data: null,
                                render: function(row, data, type) {
                                    if (row.contact_status === 'active') {

                                        return "<label class='label label-success'>Active</label>";
                                    } else {
                                        return "<label class='label label-dark'>Suspend</label>";
                                    }

                                }
                            },
                            // {
                            //     data: 'contact_status',

                            // },

                            {
                                data: null,
                                render: function(row, data, type) {
                                    var actions = "";
                                    actions += "<div class='btn-group'>" +
                                        "<button data-toggle='dropdown' class='btn btn-info btn-small dropdown-toggle'>Select Action <span class='caret'></span></button>" +
                                        "<ul class='dropdown-menu'>" +
                                        "<li><a  href='javascript:;' onclick='javascript:statusModel(" + row.id +
                                        ")'>Change Status</a></li>" +
                                        "<li><a  href='javascript:;' onclick='javascript:updateModel(" +
                                        row.id + ")'>Update</a></li>" +
                                        "<li><a  href='javascript:;' onclick='javascript:deleteModel(" +
                                        row.id +
                                        ")'  role='button' data-toggle='modal'>Remove</a></li>";

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
                        url: "{{ route('searlco.deleteContactData') }}",
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
                                    url: "{{ route('searlco.RemoveContactData') }}",
                                    data: {
                                        id: id,

                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    table.ajax.reload();
                                    if (data == 0) {
                                        Command: toastr["error"](" ", "Contact Content Not Updated")
                                        errorSound.play();
                                    }
                                    if (data == 1) {
                                      
                                        successSound.play();
                                        Command: toastr["success"]("Row has been Removed Successfully")
                                    }

                                });
                            }


                        })



                    });

            }

            //................................................................................
            function statusModel(id) {

                $.ajax({
                        type: "GET",
                        url: "{{ route('searlco.changeContactStatus') }}",
                        data: {
                            id: id,

                        },

                    })
                    .done(function(data) {
                        id = data.id;

                        console.log(data);
                        warningSound.play();
                        Swal.fire({
                            title: "Are you sure you want to Active Status where Id " + data.id + "?",
                            confirmButtonText: 'Change Status',
                            focusConfirm: false,
                            showCloseButton: true,
                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {


                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "post",
                                    url: "{{ route('searlco.updateContactStatus') }}",
                                    data: {
                                        id: data.id,

                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    console.log(data);
                                    if (data == 0) {
                                        Command: toastr["error"](" ", "Status Already Active")
                                        errorSound.play();
                                    }
                                    table.ajax.reload();
                                    if (data == 1) {
                                       
                                        Command: toastr["success"]("Status Active Successfully")
                                        successSound.play();
                                    }

                                });
                            }


                        })



                    });

            }
            //................................................................................
            function updateModel(id) {

                $.ajax({
                        type: "GET",
                        url: "{{ route('searlco.EditContactData') }}",
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
                                "  <textarea name='description' type='text' value='" + data.description +
                                "' placeholder='' class='input-large'>" + data.description +"</textarea>" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Address Heading</label>" +
                                "<div class='controls'>" +
                                "  <input name='address_heading' type='text' value='" + data.address_heading +
                                "' placeholder='image' class='' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Address </label>" +
                                "<div class='controls'>" +
                                "  <textarea name='address' type='text'value='" + data.address_desc +
                                "' placeholder='' class='input-large'>" + data.address_desc +"</textarea>" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +

                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>call Heading</label>" +
                                "<div class='controls'>" +
                                "  <input name='call_h' type='text'value='" + data.call_heading +
                                "' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +

                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>call Number</label>" +
                                "<div class='controls'>" +
                                "  <input name='call_n' type='text'value='" + data.call_number +
                                "' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +

                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Email Heading</label>" +
                                "<div class='controls'>" +
                                "  <input name='email_h' type='text'value='" + data.email_heading +
                                "' placeholder='' class='input-large' />" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +

                                "</div>" +
                                "<div class='control-group'>" +
                                "<label class='control-label'>Email Address</label>" +
                                "<div class='controls'>" +
                                "  <input name='email_a' type='text'value='" + data.email_address +
                                "' placeholder='' class='input-large' />" +
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
                                const address_heading = Swal.getPopup().querySelector('input[name=address_heading]').value
                                const address = Swal.getPopup().querySelector('textarea[name=address]').value
                                const call_h = Swal.getPopup().querySelector('input[name=call_h]').value
                                const call_n = Swal.getPopup().querySelector('input[name=call_n]').value
                                const email_h = Swal.getPopup().querySelector('input[name=email_h]').value
                                const email_a = Swal.getPopup().querySelector('input[name=email_a]').value


                                return {
                                    heading:heading,
                                    desc:desc,
                                    address_heading:address_heading,
                                    address:address,
                                    call_h:call_h,
                                    call_n:call_n,
                                    email_h:email_h,
                                    email_a:email_a,
                                }
                            }
                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {


                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "post",
                                    url: "{{ route('searlco.editsContactData') }}",
                                    data: {
                                        id: data.id,
                                        heading: result.value.heading,
                                        description: result.value.desc,
                                        address_heading: result.value.address_heading,
                                        address: result.value.address,
                                        call_h: result.value.call_h,
                                        call_n: result.value.call_n,
                                        email_h: result.value.email_h,
                                        email_a: result.value.email_a,

                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    console.log(data);
                                    table.ajax.reload();
                                    if (data == 0) {
                                        Command: toastr["error"](" ", "Contact Content Not Updated")
                                        errorSound.play();
                                    }
                                    if (data == 1) {
                
                                        successSound.play();
                                        Command: toastr["success"]("Contact Content Updated Successfully")
                                    }

                                });
                            }


                        })



                    });

            }


      
        </script>
    @endsection

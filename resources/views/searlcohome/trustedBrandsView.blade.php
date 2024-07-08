@extends('layouts.masterClone')

@section('title', 'Trusted Brands View')

@section('content')

    <div class='row-fluid'>
        <div class="span12">
            @if (Session::has('msg'))
                <div class="alert alert-success text-center">
                    <span>
                        {{ Session::get('msg') }}
                    </span>
                </div>
            @endif
            <!-- BEGIN EXAMPLE TABLE widget-->
            <div class="widget blue">
                <div class="widget-title">
                    <h4> Trusted Brands View</h4>
                    <span class="tools">
                    </span>
                </div>
                <div class="widget-body">
                    <div>
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{ route('searlco.trustedBrands') }}" class="btn btn-primary">Add Content</a>
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

                        <table id='HeaderView' class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Heading</th>
                                    <th>Description</th>
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
        <div class='row-fluid'>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget blue">
                    <div class="widget-title">
                        <h4>Trusted Card View</h4>
                        <span class="tools">
                        </span>
                    </div>
                    <div class="widget-body">
                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <a href="{{ route('searlco.TrustedBrandsCard') }}" class="btn btn-primary">Add
                                        Content</a>
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

                            <table id='MenuView' class=" table table-striped table-hover table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Card_Icon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-dark">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Card_Icon</th>
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
                    newData();
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



                    headertable = $('#HeaderView')
                        .on('init.dt', function() {

                            console.log('Table initialisation complete: ' + new Date().getTime());
                        })


                        .DataTable({
                            "lengthMenu": [
                                [5, 10, 25, 50, -1],
                                [5, 10, 25, 50, "All"]
                            ],
                            ajax: "{{ route('searlco.getTrustedData') }}",

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
                                    data: null,
                                    render: function(row, data, type) {
                                        if (row.trusted_status === 'active') {

                                            return "<label class='label label-success'>Active</label>";
                                        } else {
                                            return "<label class='label label-dark'>Suspend</label>";
                                        }

                                    }
                                },
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
                // ...................

                function newData() {

                    table = $('#MenuView')
                        .on('init.dt', function() {

                            console.log('Table initialisation complete: ' + new Date().getTime());
                        })


                        .DataTable({
                            "lengthMenu": [
                                [5, 10, 25, 50, -1],
                                [5, 10, 25, 50, "All"]
                            ],
                            ajax: "{{ route('searlco.getTrustedCardData') }}",

                            "stateSave": true,


                            columns: [

                                {
                                    data: 'id',

                                },
                                {
                                    data: null,
                                    render: function(row, data, type) {
                                        if (row.card_icon == '') {
                                            return "<img src='{{ asset('testimg/dummy.png') }}' width='50px' height='50px'/>";
                                        } else {
                                            return "<img src='{{ asset('testimg') }}/" + row.card_icon +
                                                "' width='50px' height='50px'/ class='bg-dark'>";
                                        }

                                    }
                                },
                                {
                                    data: null,
                                    render: function(row, data, type) {
                                        var actions = "";
                                        actions += "<div class='btn-group'>" +
                                            "<button data-toggle='dropdown' class='btn btn-info btn-small dropdown-toggle'>Select Action <span class='caret'></span></button>" +
                                            "<ul class='dropdown-menu'>" +

                                            "<li><a  href='javascript:;' onclick='javascript:updatemenuModel(" +
                                            row
                                            .id + ")'>Update</a></li>" +
                                            "<li><a  href='javascript:;' onclick='javascript:deletemenuModel(" +
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

                // .........................................

                function deleteModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.deleteTrustedData') }}",
                            data: {
                                id: id,

                            },

                        })
                        .done(function(data) {

                            id = data.id;
                            console.log(data);
                            warningSound.play();
                            Swal.fire({
                                title: "Are you sure you want to delete this row where id is:" + data.id + " ?",
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
                                        url: "{{ route('searlco.RemoveTrustedData') }}",
                                        data: {
                                            id: id,

                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        headertable.ajax.reload();
                                        if (data == 1) {
                                
                                            Command: toastr["success"]("Row has been Removed Successfully") 
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
                            url: "{{ route('searlco.EditTrustedData') }}",
                            data: {
                                id: id,

                            },

                        })
                        .done(function(data) {
                            id = data.id;
                            console.log(data);
                            Swal.fire({
                                title: "Are you sure you want to Update This Data?",
                                html: "<form enctype='multipart/form-data'>" +
                                    "<div class='form-horizontal'>" +

                                    "<div class='control-group'>" +
                                    "<label class='control-label'>Heading</label>" +
                                    "<div class='controls'>" +
                                    "  <input name='heading' type='text'  value='" + data.heading +
                                    "' placeholder='' class='input-large'/>" +
                                    "<span class='help-inline'></span>" +
                                    "  </div>" +
                                    "</div>" +


                                    "<div class='control-group'>" +
                                    "<label class='control-label'>Description</label>" +
                                    "<div class='controls'>" +
                                    "  <textarea name='desc' type='text' value='" + data.description +
                                    "' placeholder='' class='input-large' >" + data.description +"</textarea>" +
                                    "<span class='help-inline'></span>" +
                                    "  </div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</form>",

                                confirmButtonText: 'Update Record',
                                focusConfirm: false,
                                showCloseButton: true,
                                preConfirm: () => {

                                    const heading = Swal.getPopup().querySelector(
                                        'input[name=heading]').value
                                    const desc = Swal.getPopup().querySelector('textarea[name=desc]').value


                                    return {
                                        heading: heading,
                                        desc: desc,
                                        // logo: image,

                                    }



                                }
                            }).then((result) => {
                                console.log(result)
                                if (result.isConfirmed) {
                                    let _token = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: "post",
                                        url: "{{ route('searlco.editsTrustedData') }}",
                                        data: {
                                            id: data.id,
                                            heading: result.value.heading,
                                            desc: result.value.desc,

                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        // console.log(data);
                                        headertable.ajax.reload();
                                        if(data==0)
                                        {
                                            Command: toastr["error"]("Trusted Brands Content Not Updated!")
                                            errorSound.play();
                                        }
                                        if (data == 1) {
        
                                            Command: toastr["success"]("Trusted Brands Content updated Successfully")
                                            successSound.play();
                                            
                                        }

                                    });
                                }


                            })



                        });

                }

                // ...................................

                function deletemenuModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.deleteTrustedCardData') }}",
                            data: {
                                id: id,

                            },

                        })
                        .done(function(data) {

                            id = data.id;
                            console.log(data);
                            warningSound.play();
                            Swal.fire({
                                title: "Are you sure you want to delete this row where id is:" + data.id + " ?",
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
                                        url: "{{ route('searlco.RemoveTrustedCardData') }}",
                                        data: {
                                            id: id,

                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        table.ajax.reload();
                                        if (data == 1) { 
                                            Command: toastr["success"]("Row has been Removed Successfully")
                                            successSound.play();
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
                            url: "{{ route('searlco.changeTrustedStatus') }}",
                            data: {
                                id: id,

                            },

                        })
                        .done(function(data) {
                            id = data.id;

                            console.log(data);
                            warningSound.play();
                            Swal.fire({
                                title: "Are you sure you want to Update Status where Id " + data.id + "?",
                                confirmButtonText: 'Change Status',
                                focusConfirm: false,
                                showCloseButton: true,
                            }).then((result) => {
                                console.log(result)
                                if (result.isConfirmed) {


                                    let _token = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: "post",
                                        url: "{{ route('searlco.updateTrustedStatus') }}",
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
                                        headertable.ajax.reload();
                                        if (data == 1) {
                                        
                                            Command: toastr["success"]("Status Active Successfully")
                                            successSound.play();
                                        }

                                    });
                                }


                            })



                        });

                }
                //.........................................................................



                function updatemenuModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.EditTrustedCardData') }}",
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
                                        "<label class='control-label'>Select Logo</label>" +
                                        "<div class='controls'>" +
                                        "<input name='file' type='file' class='files' accept='image/svg' />" +
                                        "<span class='help-inline'></span>" +
                                        "  </div>" +
                                        "</div>" +
                                    "</div>",          
                                confirmButtonText: 'Update Record',
                                focusConfirm: false,
                                showCloseButton: true,
                            }).then((result) => {
                                console.log(result);
                                let _token = $('input[name=_token]').val();
                                if (result.isConfirmed) {
                                    console.log(result);
                                    var formData = new FormData();
                                    var file = $('.files')[0].files[0];
                                    formData.append("file", file);
                                    formData.append('id', data.id);
                                    console.log(file);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('searlco.editsTrustedCardData') }}",
                                        dataType: 'JSON',
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        data: formData,
                                        _token: _token,
                                    }).done(function(res) {
                                        console.log(res);
                                        if (res == 1) {
                                            Command: toastr["success"](
                                                "Data Updated Without Image Successfully")
                                            successSound.play();
                                           
                                        }
                                        if (res == 2) {
                                            Command: toastr["success"](
                                                "Data Updated With Image Successfully")
                                            successSound.play();
                                           
                                        }
                                        table.ajax.reload(null,false);
                                    });


                                }
                            });

                          

                        });

                }
            













                // .........................

       



       
            </script>
        @endsection

@extends('layouts.masterClone')

@section('title', 'HeaderView')

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
                    <h4> HeaderView</h4>
                    <span class="tools">
                    </span>
                </div>
                <div class="widget-body">
                    <div>
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{ route('searlco.header') }}" class="btn btn-primary">Add Content</a>
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
                                    <th>Logo</th>
                                    <th>Login</th>
                                    <th>Signup</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Logo</th>
                                    <th>Login</th>
                                    <th>Signup</th>
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
                        <h4> MenuView</h4>
                        <span class="tools">
                        </span>
                    </div>
                    <div class="widget-body">
                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <a href="{{ route('searlco.Navbar') }}" class="btn btn-primary">Add Content</a>
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
                                        <th>Menu Name</th>
                                        <th>Menu link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Menu Name</th>
                                        <th>Menu link</th>
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
                            ajax: "{{ route('searlco.getheaderData') }}",
                            "stateSave": true,
                            columns: [

                                {
                                    data: 'id',

                                },
                                {
                                    data: null,
                                    render: function(row, data, type) {
                                        if (row.logo === '') {
                                            return "<img src='{{ asset('testimg/dummy.png') }}' width='50px' height='50px'/>";
                                        } else {
                                            return "<img src='{{ asset('testimg') }}/" + row.logo +
                                                "' width='50px' height='50px' class='bg-dark'/>";
                                        }

                                    }
                                },
                                {
                                    data: 'login',

                                },
                                {
                                    data: 'signup',

                                },
                                {
                                    data: null,
                                    render: function(row, data, type) {
                                        if (row.haeder_status === 'active') {

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
                            ajax: "{{ route('searlco.getMenuData') }}",

                            "stateSave": true,


                            columns: [

                                {
                                    data: 'id',

                                },
                                {
                                    data: 'menu_name',

                                },
                                {
                                    data: 'href',

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

                // ...............

                function deleteModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.deleteheaderData') }}",
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
                                        url: "{{ route('searlco.RemoveheaderData') }}",
                                        data: {
                                            id: id,
                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        headertable.ajax.reload();
                                        if (data == 1) {
                                         
                                            Command:toastr["success"]("Row has been Removed Successfully")
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
        url: "{{ route('searlco.EditheaderData') }}",
        data: {
            id: id,

        },

    })
    .done(function(data) {
        id = data.id;
        console.log(data);
        let text = '';
      
        Swal.fire({
            title: "Are you sure you want to Update?",
            html: "<div class='form-horizontal'>" +

                "<div class='control-group'>" +
                "<label class='control-label'>Login</label>" +
                "<div class='controls'>" +
                "  <input name='login' type='text'  value='" + data.login +
                "' placeholder='Email' class='input-large'/>" +
                "<span class='help-inline'></span>" +
                "  </div>" +
                "</div>" +
                "<div class='control-group'>" +
                "<label class='control-label'>Sign Up</label>" +
                "<div class='controls'>" +
                "  <input name='signup' type='text'  value='" + data.signup +
                "' placeholder='Email' class='input-large'/>" +
                "<span class='help-inline'></span>" +
                "  </div>" +
                "</div>" +
                "<div class='control-group'>" +
                    "<label class='control-label'>Select Logo</label>" +
                    "<div class='controls'>" +
                    "<input name='file' type='file' class='files' accept='image/*' />" +
                    "<span class='help-inline'></span>" +
                    "  </div>" +
                    "</div>" +
                "</div>",
               
                preConfirm: () => {

                   
                    const login = Swal.getPopup().querySelector('input[name=login]').value
                    const signup = Swal.getPopup().querySelector('input[name=signup]').value


                    return {
                        login: login,
                        signup: signup,

                    }



                },
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
                let login =result.value.login;
                let signup =result.value.signup;
                formData.append("file", file);
                formData.append("login", login);
                formData.append("signup", signup);
                formData.append('id', data.id);
                console.log(file);
                $.ajax({
                    type: "POST",
                    url: "{{ route('searlco.editsheaderData') }}",
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
                    headertable.ajax.reload(null,false);
                });


            }
        });

      

    });

}
               
                // ...................................

                function deletemenuModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.deleteMenuData') }}",
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
                                        url: "{{ route('searlco.RemoveMenuData') }}",
                                        data: {
                                            id: id,

                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        table.ajax.reload();
                                        if (data == 1) {

                                            
                                            Command:toastr["success"]("Row has been Removed Successfully")
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
                            url: "{{ route('searlco.changeHeaderStatus') }}",
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
                                        url: "{{ route('searlco.updateHeaderStatus') }}",
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
                //................................................................................

                function updatemenuModel(id) {

                    $.ajax({
                            type: "GET",
                            url: "{{ route('searlco.EditMenuData') }}",
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
                                    "<label class='control-label'>Menu Name</label>" +
                                    "<div class='controls'>" +
                                    "  <input name='menu' type='text'  value='" + data.menu_name +
                                    "' placeholder='Email' class='input-large'/>" +
                                    "<span class='help-inline'></span>" +
                                    "  </div>" +
                                    "</div>"+
                                    "<div class='control-group'>" +
                                    "<label class='control-label'> Menu Link</label>" +
                                    "<div class='controls'>" +
                                    "  <input name='link' type='text'  value='" + data.href +
                                    "' placeholder='Email' class='input-large'/>" +
                                    "<span class='help-inline'></span>" +
                                    "  </div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>",

                                confirmButtonText: 'Update Record',
                                focusConfirm: false,
                                showCloseButton: true,
                                preConfirm: () => {
                                    const menu = Swal.getPopup().querySelector(
                                        'input[name=menu]').value
                                    const link = Swal.getPopup().querySelector('input[name=link]').value
                                    // const btn1 = Swal.getPopup().querySelector('input[name=button1]').value
                                    // const btn2 = Swal.getPopup().querySelector('input[name=button2]').value

                                    return {
                                        menu_name: menu,
                                        link: link,
                                    }



                                }
                            }).then((result) => {
                                console.log(result)
                                if (result.isConfirmed) {


                                    let _token = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: "get",
                                        url: "{{ route('searlco.editsMenuData') }}",
                                        data: {
                                            id: data.id,
                                            menu_name: result.value.menu_name,
                                            link: result.value.link,

                                        },
                                        _token: _token,
                                    }).done(function(data) {
                                        console.log(data);
                                        table.ajax.reload();
                                        if (data == 0) {
                                           
                                           Command:toastr["error"]("Menu Content Not Updated Successfully")
                                           errorSound.play();
               
                                       }
                                        if (data == 1) {
                                           
                                            Command:toastr["success"]("Menu Content Updated Successfully")
                                            successSound.play();
                
                                        }

                                    });
                                }


                            })



                        });

                }
            </script>

        @endsection

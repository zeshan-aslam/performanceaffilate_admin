@extends('layouts.masterClone')

@section('title', 'TitleView')

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
                    <h4> Title View</h4>
                    <span class="tools">
                    </span>
                </div>
                <div class="widget-body">
                    <div>
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{ route('searlco.title') }}" class="btn btn-primary">Add Site Title</a>
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

                        <table id='TitleView' class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Site_Title</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Site_Title</th>
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
                console.log('Site Title Table Ready');


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
                table = $('#TitleView')
                    .on('init.dt', function() {
                        console.log('Table initialisation complete: ' + new Date().getTime());
                    })
                    .DataTable({
                        "lengthMenu": [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, "All"]
                        ],
                        ajax: "{{ route('searlco.getTitleData') }}",
                        "stateSave": true,
                        columns: [
                            {
                                data: 'id',

                            },
                            {
                                data: 'title',
                            },
                            {
                                data: null,
                                render: function(row, data, type) {
                                    if (row.status === 'active') {
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

                                        "<li><a  href='javascript:;' onclick='javascript:updateModel(" +
                                        row
                                        .id + ")'>Update</a></li>" +
                                        "<li><a  href='javascript:;' onclick='javascript:statusModel(" +
                                        row
                                        .id + ")'>Change Status</a></li>" +
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
                        url: "{{ route('searlco.deleteTitleData') }}",
                        data: {
                            id: id,
                        },

                    })
                    .done(function(data) {

                        id = data.id;
                        console.log(data);
                        warningSound.play();
                        Swal.fire({
                            title: "Are you sure you want to delete " + data.title + " ?",
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
                                    url: "{{ route('searlco.RemoveTitleData') }}",
                                    data: {
                                        id: id,

                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    table.ajax.reload();
                                    if (data == 1) {
                                        Command: toastr["success"](" ", "Site Title Deleted Successfully")
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
                        url: "{{ route('searlco.EditTitleData') }}",
                        data: {
                            id: id,
                        },
                    })
                    .done(function(data) {
                        id = data.id;
                        console.log(data);
                        warningSound.play();
                        Swal.fire({
                            title: "Are you sure you want to Update?",
                            html: "<div class='form-horizontal'>" +

                                "<div class='control-group'>" +
                                "<label class='control-label'>Site Title</label>" +
                                "<div class='controls'>" +
                                "  <textarea name='title' type='text'  value='" + data.title +
                                "' placeholder='' class='input-large'>" + data.title +"</textarea>" +
                                "<span class='help-inline'></span>" +
                                "  </div>" +
                                "</div>" +
                                "</div>",
                            confirmButtonText: 'Update Record',
                            focusConfirm: false,
                            showCloseButton: true,
                            preConfirm: () => {
                                const title = Swal.getPopup().querySelector(
                                    'textarea[name=title]').value
                                return {
                                    title: title,
                                }
                            }
                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {
                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "post",
                                    url: "{{ route('searlco.editsTitleData') }}",
                                    data: {
                                        id: data.id,
                                        title: result.value.title,
                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    console.log(data);
                                    table.ajax.reload();
                                    if (data == 1) {
                                        Command: toastr["success"](" ", "Site Title Updated Successfully")
                                        successSound.play();
                                    }
                                    if (data == 0) {
                                        Command: toastr["error"](" ", "Site Title Not Updated Successfully")
                                        errorSound.play();
                                    }

                                });
                            }


                        })

                    });

            }

            function statusModel(id) {
                $.ajax({
                        type: "GET",
                        url: "{{ route('searlco.changeTitleStatus') }}",
                        data: {
                            id: id,

                        },

                    })
                    .done(function(data) {
                        id = data.id;
                        console.log(data);
                        warningSound.play();
                        Swal.fire({
                            title: "Are you sure you want to active this site title:" + data.title + "?",
                            confirmButtonText: 'Change Status',
                            focusConfirm: false,
                            showCloseButton: true,
                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {

                                let _token = "{{ csrf_token() }}";
                                $.ajax({
                                    type: "post",
                                    url: "{{ route('searlco.updateTitleStatus') }}",
                                    data: {
                                        id: data.id,
                                    },
                                    _token: _token,
                                }).done(function(data) {
                                    console.log(data);
                                    if (data == 0) {
                                        Command: toastr["error"](" ", "Site Title Already Active!!")
                                        errorSound.play();
                                    }
                                   
                                    if (data == 1) {
                                        Command: toastr["success"]("Site Title Changed Successfully")
                                        successSound.play();
                                    }
                                table.ajax.reload();
                                });
                            }
                        })
                    });
            }
        </script>
    @endsection

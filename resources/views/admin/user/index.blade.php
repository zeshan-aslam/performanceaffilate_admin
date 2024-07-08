@extends('layouts.masterClone')

@section('title', 'Admin/Users')

@section('content')
    <div class='container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class='card'>
                    <div class='card-header bg-blue text-white'><b>Users</b></div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-12">
                                <div class="form-horizontal ">
                                    <div class="control-group idDiv">
                                        <label class="control-label">ID</label>
                                        <div class="controls">
                                            <input type="number" placeholder="User Id" class="input-large" name="id"
                                                readonly maxlength="5">
                                            <span class="help-inline idErr text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Username</label>
                                        <div class="controls">
                                            <input type="text" placeholder="username" class="input-large" name="username"
                                                maxlength="15">
                                            <span class="help-inline usernameErr text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Email</label>
                                        <div class="controls">
                                            <input type="email" placeholder="Email" class="input-large" name="email"
                                                maxlength="50">
                                            <span class="help-inline emailErr text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="control-group passwordDiv">
                                        <label class="control-label">Password</label>
                                        <div class="controls">
                                            <input type="password" placeholder="Password" class="input-large" name="password"
                                                 min="8">
                                            <span class="help-inline passwordErr text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Role</label>
                                        <div class="controls">
                                            <select class="input-large m-wrap" tabindex="1" name="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                                @endforeach


                                            </select>
                                            <span class="help-inline roleErr text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-actions">

                                        <button type="submit" class="btn btn-success" name='addUserBtn'
                                            onclick="javascript:addUser();"><i class="icon-ok"></i> Add</button>
                                        <button type="button" class="btn btn-info" name='updateUserBtn'
                                            onclick="updateUser()"><i class=" icon-edit"></i> Update</button>
                                        <button type="button" class="btn" name='cancelUserBtn'
                                            onclick="cancelUser()"><i class=" icon-remove"></i> Cancel</button>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <table id='users' class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered Date</th>
                                    <th>Actions</th>






                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered Date</th>
                                    <th>Actions</th>





                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var table = '';
        var successSound = new Audio("{{ asset('audio/success.mp3') }}");
        var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
        var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
        $(document).ready(function() {
            $('button[name=AddUserBtn]').show();
            $('button[name=updateUserBtn]').hide();
            $('button[name=cancelUserBtn]').hide();
            $('.idDiv').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            console.log('Merchants ready');


            drawData();
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
            };
        });

        function drawData() {



            table = $('table')
                .on('init.dt', function() {

                    console.log('Users Table initialisation complete: ' + new Date().getTime());
                })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    ajax: "{{ url('Admin/GetUsers') }}",

                    "stateSave": true,


                    columns: [{
                            data: 'id',

                        },
                        {

                            data: 'username',

                        },

                        {
                            data: 'email',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'created_at',
                        },
                        {
                            '_': 'plain',
                            data: null,
                            render: function(data, type, row) {
                                return "<a href='javascript:;'class='editUserBtn btn btn-info' onclick='javaecript:editUser()'><i class='icon-edit'></i></a> " +
                                    " <a href='javascript:;' class='deleteUserBtn btn btn-danger' onclick='javaecript:deleteUser()'><i class='icon-trash'></i></a>";

                            }
                        },


                    ],
                    "order": [
                        [1, 'asc']
                    ],


                });



        }
        $("table tbody").on("click", "td a.editUserBtn ", function() {
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            console.log("User Assigned = ", row.data());
            editUser(row.data());

        });
        $("table tbody").on("click", " td a.deleteUserBtn", function() {
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            console.log("User Assigned = ", row.data());

            deleteUser(row.data());
        });

        function cancelUser() {
            $('.idErr').html(" ");
            $('.roleErr').html(" ");
            $('.emailErr').html(" ");
            $('.usernameErr').html(" ");
            $('button[name=addUserBtn]').show();
            $('button[name=updateUserBtn]').hide();
            $('button[name=cancelUserBtn]').hide();
            $('.idDiv').hide();
            $('.passwordDiv').show();
            $('input[name=username]').val('');
            $('input[name=email]').val('');
            $('input[name=id]').val('');

        }

        function editUser(data) {
                $('.usernameErr').html(" ");
                $('.roleErr').html(" ");
                $('.emailErr').html(" ");
                $('.passwordErr').html(" ");
            console.log("User = ", data);
            $('button[name=addUserBtn]').hide();
            $('button[name=updateUserBtn]').show();
            $('button[name=cancelUserBtn]').show();
            $('.idDiv').show();
            $('.passwordDiv').hide();
            $('input[name=username]').val(data.username);
            $('input[name=email]').val(data.email);
            $('input[name=id]').val(data.id);
            $("select[name=role] option[value=" + data.RoleId + "]").prop('selected', true);

        }

        function addUser() {
            console.log('Add User Function Running');
            let username = $('input[name=username]').val();
            let email = $('input[name=email]').val();
            let password = $('input[name=password]').val();
            var role = $('select[name=role]').val();


            if (username =='' || email ==''|| role ==''|| password=='') {
                if (username == "") {
                    $('.usernameErr').html("Please input Username ");

                } else {
                    $('.usernameErr').html(" ");
                }
                if (email == "") {
                    $('.emailErr').html("Please input Email ");

                } else {
                    $('.emailErr').html(" ");
                }
                if (role == "") {
                    $('.roleErr').html("Please input Role ");

                } else {
                    $('.roleErr').html(" ");
                }
                if (password == "") {
                    $('.passwordErr').html("Please input password ");

                } else {
                    $('.passwordErr').html(" ");
                }


            } else {
                $('.usernameErr').html(" ");
                $('.roleErr').html(" ");
                $('.emailErr').html(" ");
                $('.passwordErr').html(" ");

                role = $('select[name=role]').val();



                let _url = "{{ url('Admin/AddUser') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url: _url,
                    data: {
                        username: username,
                        email: email,
                        password:password,
                        role: role,

                    },
                    _token: _token,
                    type: "POST",
                    success: function(response) {



                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert('Error in Getting Site Language = ' + thrownError);

                    },
                }).done(function(response) {
                    table.ajax.reload();
                    console.log('Added User Response  = ', response);
                    if (response==1) {
                        $('input[name=username]').val('');
                    $('input[name=email]').val('');
                    $('input[name=id]').val('');
                    }
                    else if (response=='exists'){
                        Command: toastr["error"]("Username Already Exists", "Error");

                    }




                });
            }
        }

        function updateUser() {


            let id = $('input[name=id]').val();
            let username = $('input[name=username]').val();
            let email = $('input[name=email]').val();
            var role = $('select[name=role]').val();
            console.log("Role ID = ", role);
            if (id == '' || username == '' || email == '' || role == '') {
                if (username == "") {
                    $('.usernameErr').html("Please input Username ");

                } else {
                    $('.usernameErr').html(" ");
                }
                if (email == "") {
                    $('.emailErr').html("Please input Email ");

                } else {
                    $('.emailErr').html(" ");
                }
                if (role == "") {
                    $('.roleErr').html("Please input Role ");

                } else {
                    $('.roleErr').html(" ");
                }
                if (id == "") {
                    $('.idErr').html("Please input Id ");

                } else {
                    $('.idErr').html(" ");
                }

            } else {
                $('.usernameErr').html(" ");
                $('.roleErr').html(" ");
                $('.emailErr').html(" ");
                $('.idErr').html(" ");
                role = $('select[name=role]').val();
                console.log("Role ID = ", role);


                let _url = "{{ url('Admin/UpdateUser') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url: _url,
                    data: {
                        id: id,
                        RoleId: role,
                        username: username,
                        email: email,

                    },
                    _token: _token,
                    type: "POST",
                }).done(function(response) {
                    console.log('Updated User Response  = ', response);
                    if (response == 1) {
                        table.ajax.reload();

                        $('input[name=username]').val('');
                        $('input[name=email]').val('');
                        $('input[name=id]').val('');
                        $('button[name=addUserBtn]').show();
                        $('button[name=updateUserBtn]').hide();
                        $('button[name=cancelUserBtn]').hide();
                        $('.idDiv').hide();
                        successSound.play();
                        Command: toastr["success"]("User Updated successfully", "Success")
                    } else if (response == 'username') {
                        Command: toastr["error"]("Username Already Exixts", "Error")
                    }
                    else if (response == 'email') {
                        Command: toastr["error"]("Email Already Exixts", "Error")
                    }


                });
            }
        }

        function deleteUser(row) {

            console.log(row);

            warningSound.play();
            Swal.fire({
                title: "Are you sure you want to delete " + row.username + " ?",
                text: "You won't be able to revert this",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it"
            }).then((result) => {
                if (result.isConfirmed) {


                    let _url = "{{ url('Admin/DeleteUser') }}";
                    let _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: _url,
                        data: {
                            id: row.id,

                        },
                        _token: _token,
                        type: "POST",
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert('Error in deleting User = ' + thrownError);

                        },
                    }).done(function(response) {
                        table.ajax.reload();
                        cancelUser();
                        console.log('Delete User Response  = ', response);

                    });
                }


            })




        }
    </script>
@endsection

@extends('layouts.masterClone')

@section('title', 'Admin/Powered Words')

@section('content')
    <div class='container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class='card'>
                    <div class='card-header bg-blue text-white'><b>Powered Words</b></div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-12">
                                <div class="form-horizontal ">
                                    <div class="control-group idDiv">
                                        <label class="control-label">ID</label>
                                        <div class="controls">
                                            <input type="number" placeholder="Keyword Id" class="input-large" name="id"
                                                readonly maxlength="5">
                                            <span class="help-inline idErr text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Keyword</label>
                                        <div class="controls">
                                            <input type="text" placeholder="keyword" class="input-large" name="keyword"
                                                maxlength="15">
                                            <span class="help-inline keywordErr text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Category</label>
                                        <div class="controls">
                                            <select class="input-large m-wrap" tabindex="1" name="category">
                                            <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->cat_id }}"> {{ $category->cat_name }} </option>
                                                @endforeach


                                            </select>
                                            <span class="help-inline categoryErr text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="form-actions">

                                        <button type="submit" class="btn btn-success" name='addItemBtn'
                                            onclick="javascript:addItem();"><i class="icon-ok"></i> Add</button>
                                        <button type="button" class="btn btn-info" name='updateItemBtn'
                                            onclick="updateItem()"><i class=" icon-edit"></i> Update</button>
                                        <button type="button" class="btn" name='cancelItemBtn'
                                            onclick="cancelItem()"><i class=" icon-remove"></i> Cancel</button>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <table id='keywords' class=" table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Keyword</th>
                                    <th>Category</th>
                                    <th>Create Date</th>
                                    <th>Update Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Keyword</th>
                                    <th>Category</th>
                                    <th>Create Date</th>
                                    <th>Update Date</th>
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
            $('button[name=addItemBtn]').show();
            $('button[name=updateItemBtn]').hide();
            $('button[name=cancelItemBtn]').hide();
            $('.idDiv').hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log('Keywords ready');

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

                    console.log('Keyword Table initialisation complete: ' + new Date().getTime());
                })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    ajax: "{{ url('PoweredWords/GetKeywords') }}",
                    "stateSave": true,
                    columns: [{
                            data: 'id',
                        },
                        {
                            data: 'keyword',
                        },
                        {
                            data: 'categoryname',
                        },
                        {
                            data: 'createdate',
                        },
                        {
                            data: 'updatedate',
                        },
                        {
                            '_': 'plain',
                            data: null,
                            render: function(data, type, row) {
                                return "<a href='javascript:;'class='editItemBtn btn btn-info' ><i class='icon-edit'></i></a> " +
                                    " <a href='javascript:;' class='deleteItemBtn btn btn-danger' ><i class='icon-trash'></i></a>";

                            }
                        },


                    ],
                    "order": [
                        [1, 'asc']
                    ],


                });



        }
        $("#keywords").on("click", ".editItemBtn", function() {
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            console.log("Item Assigned = ", row.data());
            editItem(row.data());

        });
        $("#keywords").on("click", ".deleteItemBtn", function() {
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            console.log("Item Assigned = ", row.data());

            deleteItem(row.data());
        });

        function cancelItem() {
            $('.keywordErr').html(" ");
            
            $('button[name=addItemBtn]').show();
            $('button[name=updateItemBtn]').hide();
            $('button[name=cancelItemBtn]').hide();
            $('.idDiv').hide();
            
            $('input[name=keyword]').val('');
            $('input[name=id]').val('');

        }

        function editItem(data) {
                $('.keywordErr').html(" ");
            console.log("Item = ", data);
            $('button[name=addItemBtn]').hide();
            $('button[name=updateItemBtn]').show();
            $('button[name=cancelItemBtn]').show();
            $('.idDiv').show();
            
            $('input[name=keyword]').val(data.keyword);
            $('input[name=id]').val(data.id);

            $('select[name=category]').val(data.categoryid);
        }

        function addItem() {
            console.log('Add Item Function Running');
            let keyword = $('input[name=keyword]').val();
            let category = $('select[name=category]').val();

            if (keyword == '' || category == "") {
                if (keyword == "") {
                    $('.keywordErr').html("Please input keyword ");

                } 

                if (category == "") {
                    $('.categoryErr').html("Please select category ");

                }


            } else {
                $('.keywordErr').html(" ");
                $('.categoryErr').html(" ");

                let _url = "{{ url('PoweredWords/AddKeyword') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url: _url,
                    data: {
                        keyword: keyword,
                        category: category
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
                    console.log('Added Keyword Response  = ', response);
                    if (response==1) {
                        $('input[name=keyword]').val('');
                        $('input[name=category]').val('');
                    $('input[name=id]').val('');
                    }
                    else if (response=='exists'){
                        Command: toastr["error"]("Keyword Already Exists", "Error");

                    }




                });
            }
        }

        function updateItem() {


            let id = $('input[name=id]').val();
            let keyword = $('input[name=keyword]').val();
            let category = $('select[name=category]').val();
            
            
            if (id == '' || keyword == '' || category == "") {
                if (keyword == "") {
                    $('.keywordErr').html("Please input keyword ");

                } else {
                    $('.keywordErr').html(" ");
                }

                if (category == "") {
                    $('.categoryErr').html("Please select category ");

                } else {
                    $('.categoryErr').html(" ");
                }

                if (id == "") {
                    $('.idErr').html("Please input Id ");

                } else {
                    $('.idErr').html(" ");
                }

            } else {
                $('.keywordErr').html(" ");
                $('.categoryErr').html(" ");
                $('.idErr').html(" ");

                let _url = "{{ url('PoweredWords/UpdateKeyword') }}";
                let _token = "{{ csrf_token() }}";
                $.ajax({
                    url: _url,
                    data: {
                        id: id,
                        keyword: keyword,
                        category: category
                    },
                    _token: _token,
                    type: "POST",
                }).done(function(response) {
                    console.log('Updated Keyword Response  = ', response);
                    if (response == 1) {
                        table.ajax.reload();

                        $('input[name=keyword]').val('');
                        $('input[name=category]').val('');
                        $('input[name=id]').val('');
                        $('button[name=addUserBtn]').show();
                        $('button[name=updateUserBtn]').hide();
                        $('button[name=cancelUserBtn]').hide();
                        $('.idDiv').hide();
                        successSound.play();
                        Command: toastr["success"]("Keyword Updated successfully", "Success")
                    } else if (response == 'keyword') {
                        Command: toastr["error"]("Keyword Already Exixts", "Error")
                    }


                });
            }
        }

        function deleteItem(row) {

            console.log(row);

            warningSound.play();
            Swal.fire({
                title: "Are you sure you want to delete " + row.keyword + " ?",
                text: "You won't be able to revert this",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it"
            }).then((result) => {
                if (result.isConfirmed) {


                    let _url = "{{ url('PoweredWords/DeleteKeyword') }}";
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

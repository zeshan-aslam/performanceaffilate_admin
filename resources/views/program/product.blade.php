@php
    $heading=DB::table('partners_program')
    ->where('program_id','=',$id)
    ->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Programs - Text Link')

@section('content')
<h1>Product Data of 
    @if($heading)
    <span class="text-dark">
    {{$heading->program_url}}
   </span>
   @else
   <span class="text-dark">
        Unknown Program
      </span>
   @endif
   </h1>
    <div class='row'>
        <input type="hidden" name='programId' value='{{ $id }}'>
        <input type="hidden" name='status' value='{{$status }}'>
        <div class='col-lg-8'>
            <div class='card'>
                <div class='card-header text-center text-dark'> Product Links</div>
                <div class='card-body'>

                    <table class='table table-stripped table-hover table-responsive'>
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>Type</th>
                                <th>URL</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>



                </div>
            </div>
        </div>

    </div>
@endsection
@section('style')
    <style>
        .show {

            cursor: pointer;
        }

    </style>
@endsection
@section('script')
    <script>
        var Table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            getTextLinks();
        });

        function getTextLinks() {
            var programId = $('input[name=programId]').val();
            var status = $('input[name=status]').val();

            let _url = "{{ url('Program/GetProductLinks') }}/" + programId+"/"+status;
            Table = $('table')
                .on('init.dt', function() {

                    console.log('Product Table initialisation complete: ' + new Date().getTime());
                })


                .DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],



                    "stateSave": true,
                    "bDestroy": true,

                    ajax: _url,
                    columns: [{
                            data: null,
                            render: function(data, type, row) {

                                return "<span class='label'>Product</span>";
                            }
                        },
                        {


                            data: 'product_url',
                            render: function(data, type, row) {

                                return "<a href='" + data + "' target='_blank'>" + data + "</a>";




                            }
                        },
                        {


                            data: 'prd_desc',

                        },
                        {

                            "className": 'show',
                            data: 'prd_image',
                            render: function(data, type, row) {

                                return "<img src='" + data + "' />";




                            }
                        },

                        {
                            data: 'product_status',
                            render: function(data, type, row) {

                                if (data == 'inactive')
                                    return "<a href='javascript:;' class='btn btn-success' onclick='javascript:approve(" +
                                        row.prd_id + ");'>Approve</a>";
                                else if (data == 'active') {
                                    return "<a href='javascript:;' class='btn btn-inverse' onclick='javascript:reject(" +
                                        row.prd_id + ");'>Reject</a>";
                                }


                            }

                        },



                    ],
                    "order": [
                        [1, 'asc']
                    ]
                });

        }

        function show(row) {
            console.log("Banner Row", row);

            let image = "<img src='" + row.banner_name + "' height='" + row.banner_height + "' width='" +
                row.banner_width + "'/>";

            Swal.fire({

                html: image,
                position: 'center',
                showClass: {
                    popup: `
              animate__animated
              animate__fadeInDown
              animate__faster
                 `
                },
                hideClass: {
                    popup: `
             animate__animated
             animate__zoomOut
             animate__faster
                      `
                },
                grow: 'row',
                width: row.banner_width,
                height: row.banner_height,
                showConfirmButton: false,
                showCloseButton: false
            })
        }
        $('table tbody ').on('click', 'tr td.show', function() {
            var tr = $(this).closest('tr');
            var row = Table.row(tr);
            show(row.data());

        });

        function approve(id) {

            $.ajax({
                url: "{{ url('Program/ApproveLink') }}",
                data: {
                    id: id,
                    Table: 'partners_product',
                },
                _token: "{{ csrf_token() }}",
                type: "POST",

            }).done(function(response) {
                console.log('Approve Popup Response', response);
                Table.ajax.reload();
            });

        }

        function reject(id) {

            $.ajax({
                url: "{{ url('Program/RejectLink') }}",
                data: {
                    id: id,
                    Table: 'partners_product',

                },
                _token: "{{ csrf_token() }}",
                type: "POST",

            }).done(function(response) {
                console.log('Approve Popup Response', response);
                Table.ajax.reload();
            });

        }
    </script>

@endsection

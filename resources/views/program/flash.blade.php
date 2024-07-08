@php
    $heading=DB::table('partners_program')
    ->where('program_id','=',$id)
    ->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Programs - Text Link')

@section('content')
<h1>Flash Data of 
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
                <div class='card-header bg-dark text-white text-center'> Flash Links</div>
                <div class='card-body'>

                    <table class='table table-stripped table-hover '>
                        <thead class="bg-light text-dark">
                            <tr>
                                <th>Type</th>
                                <th>URL</th>
                                <th>Description</th>
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
   .show{
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

            let _url = "{{ url('Program/GetFlashLinks') }}/" + programId+"/"+status;
            Table = $('table')
                .on('init.dt', function() {

                    console.log('Text Table initialisation complete: ' + new Date().getTime());
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

                                return "<span class='label bg-dark'>Flash</span>";
                            }
                        },
                        {


                            data: 'flash_url',
                            render: function(data, type, row) {

                                return "<a href='" + data + "' target='_blank'>" + data + "</a>";




                            }
                        },
                        {

                            "className": 'show',
                            data: 'flash_swf',
                            render: function(data, type, row) {

                                return "<video src='" + data + "' height='" + row.flash_height + "' width='" +
                                    row.flash_width + "' autoplay/>";




                            }
                        },

                        {
                            data: 'flash_status',
                            render: function(data, type, row) {

                                if (data == 'inactive')
                                    return "<a href='javascript:;' class='btn btn-success' onclick='javascript:approveTextLink(" +
                                        row.flash_id + ");'>Approve</a>";
                               else  if (data == 'active') {
                                return "<a href='javascript:;' class='btn btn-inverse' onclick='javascript:rejectTextLink(" +
                                row.flash_id + ");'>Reject</a>";
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
            console.log("Flash Row", row);

           let image= "<video src='" + row.flah_swf + "' height='" + row.flash_height + "' width='" +
                                    row.flash_width + "'/>";

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
        width: row.flash_width,
        height:row.flash_height,
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
                    Table:'partners_text_old',
                },
                _token: "{{ csrf_token() }}",
                type: "POST",

            }).done(function(response) {
                console.log('Approve Text Response', response);
                Table.ajax.reload();
            });

        }

        function reject(id) {

            $.ajax({
                url: "{{ url('Program/RejectLink') }}",
                data: {
                    id: id,
                    Table:'partners_text_old',

                },
                _token: "{{ csrf_token() }}",
                type: "POST",

            }).done(function(response) {
                console.log('Approve Text Response', response);
                Table.ajax.reload();
            });

        }
    </script>
@endsection

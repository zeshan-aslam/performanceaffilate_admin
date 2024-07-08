@extends('layouts.masterClone')

@section('title', 'Networks')


@section('content')
<h1 class="page-title">Networks</h1><hr/>
<div class='row-fluid'>
    <div class="span12">
        <!-- <div class="clearfix">
            <div class="btn-group pull-left">
                <button class="btn btn-success" onclick="javascript:addNetwork();">
                    Add New <i class="icon-plus"></i>
                </button>
            </div>

        </div> -->
       
        <div class="metro-nav mt-3">


            @foreach ($data as $row)
            <div class="metro-nav-block nav-block-yellow">
                <a data-original-title="" href="{{route('awin.publisher',$row->networkId)}}">
                    <img src="img/awin.svg" width="150" height="150" alt="AWIN"/>
                    <div class="info">

                    </div>
                    <div class="status">{{$row->name}}</div>
                </a>
            </div>
            @endforeach
        </div>



        <!-- END GRID PORTLET-->
    </div>
    @endsection
    @section('script')
    <script>
         var table = '';
            var successSound = new Audio("{{ asset('audio/success.mp3') }}");
            var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
            var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
            $(document).ready(function() {

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

        function addNetwork() {



            Swal.fire({
                title: 'Add Network',
                html: "<div class='form-horizontal'>" +


                    "<div class='control-group'>" +
                    "<label class='control-label'>Name</label>" +
                    "<div class='controls'>" +
                    "  <input name='name'  type='text'  placeholder='Network Name' class='input-large'/>" +

                    "  </div>" +
                    "</div>" +


                    "<div class='control-group'>" +
                    "<label class='control-label'>Network ID</label>" +
                    "<div class='controls'>" +
                    "  <input name='networkId' max='10000000' type='number' placeholder='Network ID' class='input-large' />" +

                    "  </div>" +
                    "</div>" +



                    "</div>",

                confirmButtonText: 'Add',
                focusConfirm: false,
                showCloseButton: true,
                preConfirm: () => {

                    const name = Swal.getPopup().querySelector('input[name=name]').value
                    const networkId = Swal.getPopup().querySelector('input[name=networkId]').value

                    if (name == '' || networkId == '') {
                        if (name == '') {
                            Swal.showValidationMessage(`Please enter Network Name`)
                        }
                        if (networkId == '') {
                            Swal.showValidationMessage(`Please Enter Network ID`)
                        }

                    } else if (parseInt(networkId) > 10000000) {
                        Swal.showValidationMessage(`Very Large ID`)
                    } else {
                        return {
                            name: name,
                            networkId: networkId,
                        }
                    }





                }
            }).then((result) => {
                console.log(result);

                let _token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "Networks",
                    data: {
                        name: result.value.name,
                        networkId: result.value.networkId

                    },
                    _token: _token,

                    error: function(xhr, ajaxOptions, thrownError) {
                        errorSound.play();
                        Command: toastr["error"](" ", thrownError)

                    },

                }).done(function(data) {
                    if (data) {

                        successSound.play();
                        Command: toastr["success"]("Money Adjusted successfully", "Success")

                    } else {
                        errorSound.play();
                        Command: toastr["error"]("Error Adding Network", "Error")

                    }




                });


            });




        }
    </script>

    @endsection
@extends('layouts.masterClone')
@section('style')
    <style>
        .container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            min-height: 50vh;
            background-color: white;
        }

        .loader {
            max-width: 15rem;
            width: 10%;
            height: auto;
            stroke-linecap: round;
        }

        circle {
            fill: none;
            stroke-width: 3.5;
            -webkit-animation-name: preloader;
            animation-name: preloader;
            -webkit-animation-duration: 3s;
            animation-duration: 3s;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            animation-timing-function: ease-in-out;
            -webkit-transform-origin: 170px 170px;
            transform-origin: 170px 170px;
            will-change: transform;
        }

        circle:nth-of-type(1) {
            stroke-dasharray: 550;
        }

        circle:nth-of-type(2) {
            stroke-dasharray: 500;
        }

        circle:nth-of-type(3) {
            stroke-dasharray: 450;
        }

        circle:nth-of-type(4) {
            stroke-dasharray: 300;
        }

        circle:nth-of-type(1) {
            -webkit-animation-delay: -0.15s;
            animation-delay: -0.15s;
        }

        circle:nth-of-type(2) {
            -webkit-animation-delay: -0.3s;
            animation-delay: -0.3s;
        }

        circle:nth-of-type(3) {
            -webkit-animation-delay: -0.45s;
            -moz-animation-delay: -0.45s;
            animation-delay: -0.45s;
        }

        circle:nth-of-type(4) {
            -webkit-animation-delay: -0.6s;
            -moz-animation-delay: -0.6s;
            animation-delay: -0.6s;
        }

        @-webkit-keyframes preloader {
            50% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes preloader {
            50% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class='row-fluid'>


        <div class="span12">
            <h2>Total Brands/Concerned Merchants : <span id="total_records"></span></h2>
            <hr />
            <div class="col-8">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Brand Name" />
                </div>
                <h1 class="text-warning"><strong>Brands (Concerned Merchant)</strong></h1>
                <div>
                    <table>
                        <tbody>
                            <div class="container" id="loader">

                                <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
                                    <circle cx="170" cy="170" r="160" stroke="#2587be" />
                                    <circle cx="170" cy="170" r="135" stroke="#404041" />
                                    <circle cx="170" cy="170" r="110" stroke="#2587be" />
                                    <circle cx="170" cy="170" r="85" stroke="#404041" />

                                </svg>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END EXAMPLE TABLE widget-->
@endsection


@section('script')
    <script>
        $(document).ready(function() {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ url('getTotalKeywords') }}",
                    method: 'GET',
                    data: {
                        query: query,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#loader').css('display', 'none');
                        if (!data) alert('No Data!');
                        console.log("its json data", data);
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function(e) {
                var query = $(this).val();
                if ($(this).val().length >= 1) {
                    if(e.which === 13)
                    {
                        fetch_customer_data(query);
                    }
                    
                } else if($(this).val().length == 0 && e.which != 13) {
                    $('tbody').html('');
                    $('#loader').css('display', '');
                    fetch_customer_data();
                }

            });
        });
    </script>
@endsection

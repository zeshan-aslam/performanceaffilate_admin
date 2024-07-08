@extends('layouts.masterClone')
@section('title', 'SubSales')
@section('content')
    <div class="card">
        <div class="card-header text-light bg-info">Subsales</div>
        <div class="card-body">
            <div class="row">

                <div class="col-2">
                    <div class="form-horizontal">
                        <input type="hidden" value="{{ $id }}" name="Id">
                        <div class="control-group">
                            <label class="control-label">From </label>

                            <input type="date" class="input-medium" name="refererFrom">

                        </div>
                        <div class="control-group">
                            <label class="control-label">To </label>

                            <input type="date" class="input-medium" name="refererTo">


                        </div>
                        <div class="control-group">


                            <a name="getReferralCommissionData" class="input-small btn btn-primary blue"
                                onclick="getReferralCommission(event.target)"> View <i
                                    class="icon-circle-arrow-down"></i></a>


                        </div>

                    </div>
                </div>
                <div class="col-9">
                    <table id="RefCommissionTable" class="table table-striped table-bordered table-hover">
                        <thead class="text-white bg-dark">
                            <tr>

                                <th class="hidden-phone"> Affiliate</th>
                                <th class="hidden-phone">Referrals </th>
                                <th class="hidden-phone"> Commission Earned </th>




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
@section('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var RefCommissionTable = $('#RefCommissionTable').DataTable();
            getReferralCommission();
        });

        function getReferralCommission() {
            let From = $("input[name=refererFrom]").val();
            let To = $("input[name=refererTo]").val();
            let id = $("input[name=Id]").val();

            let _token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ url('Report/GetSubReferralCommission') }}",
                data: {
                    From: From,
                    To: To,
                    id: id,

                },
                _token: _token,
                type: "POST",
            }).done(function(response) {
                console.log(response);
                var RefCommissionTable = $('#RefCommissionTable').DataTable({
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],



                    "stateSave": true,
                    "bDestroy": true,
                    'autoWidth': false,
                    data: response,
                    columns: [{
                     
                            data: 'affiliate_company',

                        },
                        {
                            data: 'subsale_id_count',
                        },
                        {
                            data: 'subsale_amount_sum',
                        },

                    ],
                });


            });






        }
    </script>
@endsection

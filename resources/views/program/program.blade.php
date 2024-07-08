@php
$symbol = DB::table('partners_currency')
    ->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
    ->select('currency_symbol')
    ->first();
   $merchant= DB::table('partners_merchant')->where('merchant_id','=', $programs->program_merchantid)->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Programs')

@section('content')


@if ($programs == null)
    <div class='alert alert-danger'>
        <strong>No Program Found</strong>
    </div>
@else


    <div class="row">
        <input value="{{$programs->program_id}}" name="programId" type="hidden">
        <div class="col-8 float-left">
            <h2><b class="text-danger">{{ $programs->program_url }}</b></h2>
            <p>By <b class="text-success">{{ $merchant->merchant_company}}</b></p>
            <p>{{ $programs->program_description }}</p>
        </div>
        <div class="col-3 float-right">
            <div class=" ">
                <a class="btn btn-primary" href="javascript:;" onclick="javascript:getAffiliates();">
                    Affiliates <span class="badge bg-white text-primary">{{ $totalAffiliates }}</span>

                </a>
                @if ($programs->program_status == 'inactive')
                    <a class="btn btn-medium btn-success" href="{{ route('Program.changeProgramStatus', $Pid) }}">Approve
                        <i class='icon-ok icon-white'></i></a>
                @else
                    <a class="btn btn-medium btn-danger" href="{{ route('Program.changeProgramStatus', $Pid) }}">Reject <i
                            class='icon-remove icon-white'></i></a>
                @endif
                <!-- <a class="btn btn-medium btn-secondary" href="#showMerchantprograms->program_merchantid"
                    role="button" data-toggle="modal">View</a> -->

            </div>
      
        </div>
    </div>
    <div class="row">
        <div class="col-8">

            <div class="card p-2">

                <h2 class='text-dark p-2 card-title'>Comissions</h2>

                <table class="table table-bordered">
                    <thead class="bg-blue text-white">
                        <tr>

                            <th class="hidden-phone">Type</th>
                            <th class="hidden-phone">Impression</th>
                            <th class="hidden-phone">Click</th>


                        </tr>
                    </thead>
                    <tbody>

                        <tr class="odd gradeX">
                            <td><b class="text-dark">Commission</b></td>
                            <td>{{ $programs->program_impressionrate }}</td>
                            <td>{{ $programs->program_clickrate }}</td>
                        </tr>
                        <tr class="odd gradeX">
                            <td><b class="text-dark">Approval</b></td>
                            <td>
                                @if ($programs->program_impressionapproval == 'manual')
                                <span class="label label-warning">{{ $programs->program_impressionapproval }}</span>
                            @else
                                <span class="label label-info">{{ $programs->program_impressionapproval }}</span>
                            @endif

                            </td>
                            <td>  @if ($programs->program_clickapproval == 'manual')
                                <span class="label label-warning">{{ $programs->program_clickapproval }}</span>
                            @else
                                <span class="label label-info">{{ $programs->program_clickapproval }}</span>
                            @endif</td>
                        </tr>
                        <tr class="odd gradeX">
                            <td><b class="text-dark">Email Setting</b></td>
                            <td>
                                   @if ($programs->program_impressionmail == 'manual')
                                <span class="label label-warning">{{ $programs->program_impressionmail }}</span>
                            @else
                                <span class="label label-info">{{ $programs->program_impressionmail }}</span>
                            @endif
                        </td>
                            <td>
                                  @if ($programs->program_clickmail == 'manual')
                                <span class="label label-warning">{{ $programs->program_clickmail }}</span>
                            @else
                                <span class="label label-info">{{ $programs->program_clickmail }}</span>
                            @endif
                        </td>
                        </tr>



                    </tbody>
                </table>

            </div>
            <div  class="card p-2 mt-2">
                <h2 class='text-dark p-2'>Commission Structure 1</h2>

                <table class="table table-bordered" id="sample_1">
                    <thead  class="bg-blue text-white">
                        <tr>

                            <th class="hidden-phone">Type</th>
                            <th class="hidden-phone">Lead</th>
                            <th class="hidden-phone">Sale</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b class="text-dark">From</b></td>
                            <td>{{ $comission->commission_lead_from }}</td>
                            <td>{{ $comission->commission_sale_from }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-dark">To</b></td>
                            <td>{{ $comission->commission_lead_to }}</td>
                            <td>{{ $comission->commission_sale_to }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-dark">Commission</b></td>
                            <td>{{ $comission->commission_leadrate }}</td>
                            <td>{{ $comission->commission_salerate }}</td>
                        </tr>
                        <tr>
                            <td><b class="text-dark">Approval</b></td>
                            <td>
                                   @if ($comission->commission_leadapproval == 'manual')
                                <span class="label label-warning">{{ $comission->commission_leadapproval }}</span>
                            @else
                                <span class="label label-info">{{ $comission->commission_leadapproval }}</span>
                            @endif
                              </td>
                            <td>
                                @if ($comission->commission_saleapproval == 'manual')
                                <span class="label label-warning">{{ $comission->commission_saleapproval }}</span>
                            @else
                                <span class="label label-info">{{ $comission->commission_saleapproval }}</span>
                            @endif

                            </td>
                        </tr>
                        <tr>
                            <td><b class="text-dark">Email Setting</b></td>
                            <td>
                                @if ($comission->commission_leadmail == 'manual')
                                <span class="label label-warning">{{ $comission->commission_leadmail }}</span>
                            @else
                                <span class="label label-info">{{ $comission->commission_leadmail }}</span>
                            @endif


                            </td>
                            <td>
                                @if ($comission->commission_salemail == 'manual')
                                <span class="label label-warning">{{ $comission->commission_salemail }}</span>
                            @else
                                <span class="label label-info">{{ $comission->commission_salemail }}</span>
                            @endif
                            </td>
                        </tr>


                    </tbody>
                </table>


            </div>
            <div  class="card p-2 mt-2">
                <div class="card-header bg-blue text-white m-2">
                    Program Fee
                </div>
                <div class="card-body">
<div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Program Fee</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on">
                                        @php
                                        echo $symbol->currency_symbol;
                                    @endphp </span><input name='programFee'
                                        class=" " type="number" value='{{ $programs->program_fee }}'
                                        required /><span class="add-on">.00</span>
                                </div>
                                <span class="help-inline programFeeErr text-danger"></span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Program Type</label>
                            <div class="controls">
                                <label class="radio">

                                    <input type="radio" onclick='showDiv(this)' name="programType"
                                        value="{{ $programs->program_type == 1 ? $programs->program_type : 1 }}"
                                        <?php echo $programs->program_type == 1 ? "checked='checked'" : ''; ?> />
                                    One Time
                                </label>
                                <label class="radio">
                                    <input type="radio" onclick='showDiv(this)' id='onRecurringSelected' name="programType"
                                        value='{{ $programs->program_type == 2 ? $programs->program_type : 0 }}'
                                        <?php echo $programs->program_type == 2 ? "checked='checked'" : ''; ?> />
                                    Recurring
                                </label>



                            </div>
                        </div>


                        <div id='RecurringSelected' class="control-group offset1">
                            <label class="control-label"></label>
                            <div class="controls">

                                <input type="number" name='programValue' placeholder="Value"
                                    value="{{ substr($programs->program_value, 0, strpos($programs->program_value, ' ')) }}"
                                    class="input-mini" required />

                                <select name='programPeriod' class="input-small m-wrap" tabindex="1">

                                    <option value="day" <?php echo substr($programs->program_value,strpos($programs->program_value, ' ')) == 'day' ? 'selected' : ''; ?>>Day(s)</option>
                                    <option value="month" <?php echo substr($programs->program_value,strpos($programs->program_value, ' ')) == 'month' ? 'selected' : ''; ?>>Month(s)</option>
                                    <option value="year" <?php echo substr($programs->program_value,strpos($programs->program_value, ' ')) == 'year' ? 'selected' : ''; ?>>Year(s)</option>

                                </select>
                                <span class="help-inline programValueErr text-danger"></span>

                            </div>
                        </div>




                        <div class="form-actions">
                            <button type="button" class="btn btn-success" onclick="javascript:updateProgramFee()"><i class="icon-edit"></i>
                                Update Program Fee</button>

                        </div>
                </div>


                </div>

            </div>
            <div  class="card p-2 mt-2">
                <div class="card-header bg-blue m-2 text-white">
                    Transaction Amounts
                </div>
                <div class="card-body">
                    <div class="form-horizontal">

                        @csrf
                        <div class="control-group">
                            <label class="control-label">Program Fee</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on">@php
                                        echo $symbol->currency_symbol;
                                    @endphp</span><input name='programAdminImpression'
                                        class=" input-medium" type="number" value='{{ $programs->program_admin_impr }}'
                                        required /><span class="add-on">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">


                            <div class='row-fluid'>

                                <div class='span6'>
                                    <label class="control-label">Click Rate</label>
                                    <div class="controls">
                                        <input name='programAdminClick' type="number" placeholder="Click Rate"
                                            class="input-medium" value='{{ $programs->program_admin_click }}' required />

                                    </div>
                                </div>
                                <div class='span6'>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="programAdminClickType" value="$" <?php echo $programs->program_admin_clicktype == '$' ? "checked='checked'" : ''; ?> />
                                            @php
                                                echo $symbol->currency_symbol;
                                            @endphp
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="programAdminClickType" value="%" <?php echo $programs->program_admin_clicktype == '%' ? "checked='checked'" : ''; ?> />
                                            %
                                        </label>
                                    </div>
                                </div>

                            </div>






                        </div>
                        <div class="control-group">


                            <div class='row-fluid'>

                                <div class='span6'>
                                    <label class="control-label">Lead Rate</label>
                                    <div class="controls">
                                        <input name='programAdminLead' type="number" placeholder="Lead Rate"
                                            class="input-medium" value='{{ $programs->program_admin_lead }}' required />

                                    </div>
                                </div>
                                <div class='span6'>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="programAdminLeadType" value="$" <?php echo $programs->program_admin_leadtype == '$' ? "checked='checked'" : ''; ?> />
                                            @php
                                                echo $symbol->currency_symbol;
                                            @endphp
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="programAdminLeadType" value="%" <?php echo $programs->program_admin_leadtype == '%' ? "checked='checked'" : ''; ?> />
                                            %
                                        </label>
                                    </div>
                                </div>

                            </div>






                        </div>

                        <div class="control-group">


                            <div class='row-fluid'>

                                <div class='span6'>
                                    <label class="control-label">Sale Rate</label>
                                    <div class="controls">
                                        <input name='programAdminSale' type="number" placeholder="Sale Rate"
                                            class="input-medium" value='{{ $programs->program_admin_sale }}' required />

                                    </div>
                                </div>
                                <div class='span6'>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="programAdminSaleType" value="$" <?php echo $programs->program_admin_saletype == '$' ? "checked='checked'" : ''; ?> />
                                            @php
                                                echo $symbol->currency_symbol;
                                            @endphp
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="programAdminSaleType" value="%" <?php echo $programs->program_admin_saletype == '%' ? "checked='checked'" : ''; ?> />
                                            %
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-success" onclick="javascript:updateAdminPayments();"><i class="icon-edit"></i>
                                Modify Transaction Rates</button>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-3">
            <table class="table table-bordered">

                <tbody>
                    <tr class="odd">
                        <td class="text-success"><b>Texts</b></td>

                        <td class="hidden-phone"><a href='{{ route('Program.text', [$Pid, 'all']) }}'><span
                                    class='badge bg-success'>{{ $advLinks['text_old'] }}</span></a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text-warning"><b>Template</b></td>
                        <td class="hidden-phone"><a href='{{ route('Program.templateText', [$Pid, 'all']) }}'><span
                                    class='badge bg-warning'> {{ $advLinks['text'] }}</span></a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text-info"><b>HTML</b></td>
                        <td class="hidden-phone"><a href='{{ route('Program.html', [$Pid, 'all']) }}'><span
                                    class='badge bg-info'>{{ $advLinks['html'] }}</a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text-danger"><b>Banner</b></td>

                        <td class="hidden-phone"><a href='{{ route('Program.banner', [$Pid, 'all']) }}'><span
                                    class='badge bg-danger'>{{ $advLinks['banner'] }}</span></a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text-primary"><b>Popup</b></td>
                        <td class="hidden-phone"><a href='{{ route('Program.popup', [$Pid, 'all']) }}'><span
                                    class='badge bg-primary'>{{ $advLinks['popup'] }}</span></a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text-dark"><b>Flash</b></td>

                        <td class="hidden-phone"><a href='{{ route('Program.flash', [$Pid, 'all']) }}'><span
                                    class='badge bg-dark'>{{ $advLinks['flash'] }}</span></a></td>
                    </tr>
                    <tr class="odd">
                        <td class="text"><b>Products</b></td>

                        <td class="hidden-phone"><a href='{{ route('Program.product', [$Pid, 'all']) }}'><span
                                    class='badge bg-blue text-light'>{{ count($products) }}</span></a></td>
                    </tr>


                </tbody>
            </table>
            <div>

                <table class="table table-bordered">

                    <tbody>
                        <tr class="odd">
                            <td class="text-dark"><b>Send email to affiliate when transaction appears</b></td>
                            <td> {{ $programs->program_mailaffiliate }}</td>
                        </tr>
                        <tr class="odd">
                            <td class="text-dark"><b>Send email to Me when transaction appears</b></td>
                            <td> {{ $programs->program_mailmerchant }}</td>
                        </tr>
                        <tr class="odd">
                            <td class="text-dark"><b>Affiliate Approval</b></td>
                            <td>  @if ($programs->program_affiliateapproval == 'manual')
                                <span class="label label-warning">{{ $programs->program_affiliateapproval }}</span>
                            @else
                                <span class="label label-info">{{ $programs->program_affiliateapproval }}</span>
                            @endif
                        </td>
                        </tr>
                    </tbody>
                </table>


            </div>
            <div>

                @if ($comission->commission_recur_sale==1)
                <div class="alert alert-success">
                    Recur Sale Commission by {{ $comission->commission_recur_percentage }} percentage.<br> Recur
                    Every recur_percent_month_head {{ $comission->commission_recur_period }} Month
                </div>
            @else
                <div class="alert alert-danger">
                    Sale Commission is not Recurring.
                </div>
            @endif
            </div>
        </div>



    </div>




    @endif

@endsection
@section('script')
    <script>
        var successSound = new Audio("{{ asset('audio/success.mp3') }}");
        var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
        var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
        var programId = $('input[name=programId]').val();
        $(document).ready(function() {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#RecurringSelected').hide();


            var id = $("#regAffiliates").data("id");
            $("#comissionBtn").click(function() {
                $("#regAffiliates" + id).modal("hide");
                var affiliateId = $("#comissionBtn").data("id");
                console.log("Affiliate id is " + affiliateId);
                $("#comissionAffiliateId").attr('value', affiliateId);

            });

            $("#regAffiliates" + id).on('hidden.bs.modal', function() {


                $("#comsiionStructure1").modal("show");

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

        function getAffiliates() {
            var _token = "{{ csrf_token() }}";



            $.ajax({
                    type: "POST",
                    url: "{{ url('Program/GetAffiliates') }}",
                    data: {
                        programId: programId
                    },
                    _token: "{{ csrf_token() }}"

                }).done(function(response) {
                    console.log('Data', response);
                    var table = '';
                    if (response.length == 0) {
                        table = "<p>No Affiliates Registered</p>";

                    } else {


                        table =
                            "<table class='table table-hover' style='font-size:12px'>  <thead><th>Affiliate</th><th>Action</th></thead><tbody>";
                        for (let index = 0; index < response.length; index++) {
                            table += "<tr>";
                            table += "<td>" + response[index].affiliate_company + "</td>";
                            if (response[index].joinpgm_commissionid == response[index].commission_id) {
                                table += "<td><button onclick='javascript:removeCommission(" + response[index]
                                    .affiliate_id + ");' class='btn btn-danger'>Remove</button></td>";
                            } else {
                                table += "<td><button onclick='javascript:makeDefaultCommission(" + response[index]
                                    .affiliate_id + ");' class='btn btn-success'>Make Default Commission</button></td>";

                            }


                            table += "</tr>";


                        }
                        table += "</tbody></table>";
                    }

                    Swal.fire({
                        title: "Affiliates Commission",
                        html: table,

                    });

                })
                .fail(function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);

                });



        }

        function makeDefaultCommission(affiliateId) {
            $.ajax({
                type: "POST",
                url: "{{ url('Program/UpdateComission') }}/" + programId,
                data: {
                    comissionAffiliateId: affiliateId,
                    comissionProgramId: programId,
                    mode: 'set',
                    commissionComissionId: programId,
                },
                _token: "{{ csrf_token() }}"

            }).done(function(response) {
                if (response) {
                    successSound.play();
                    Command: toastr["success"]("Assigned Commission successfully", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"]("Error in Assigning Commisison", "Error")

                }




            });

        }

        function removeCommission(affiliateId) {
            $.ajax({
                type: "POST",
                url: "{{ url('Program/UpdateComission') }}/" + programId,
                data: {
                    comissionAffiliateId: affiliateId,
                    comissionProgramId: programId,
                    mode: 'remove',
                },
                _token: "{{ csrf_token() }}"

            }).done(function(response) {
                if (response) {
                    successSound.play();
                    Command: toastr["success"]("Removed successfully", "Success")

                } else {
                    errorSound.play();
                    Command: toastr["error"]("Error in Removing Commisison", "Error")

                }




            });

        }

        function showDiv(programType) {
            if (programType.value == 2 || programType.value == 0) {
                $('#RecurringSelected').show();
                $('#onRecurringSelected').attr('value', '2');


            }
            if (programType.value == 1) {
                $('#RecurringSelected').hide();
                $('#onRecurringSelected').attr('value', '0');

            }



        }

        function updateProgramFee() {
            let programFee=$('input[name=programFee]').val();
            let programType=$('input[name=programType]:checked').val();
            let programPeriod=$('select[name=programPeriod]').val();
            let programValue=$('input[name=programValue]').val();
            let Err=0;
            if( programFee=='' ){
                $('.programFeeErr').html("Please Input Program Fee");
                Err=1;

            }else if(parseInt(programFee) < 0){
                $('.programFeeErr').html("Cannot Input Less than Zero Fee");
                Err=1;
            }
            else{
                $('.programFeeErr').html("");
                Err=0;
            }
            if(programType!='1' && programValue==''){

                $('.programValueErr').html("Please Input Program Period");
                Err=1;
            }
            else if(programType!='1' && parseInt(programValue) < 0){
                $('.programValueErr').html("Cannot Input Less than Zero Period");
                Err=1;
            }
            if(Err==0){
                Err=0;
                console.log('Else Con');
                $('.programValueErr').html("");



            $.ajax({
                type: "POST",
                url: "{{ url('Program/UpdateFee') }}/" + programId,
                data: {
                    programType:programType,
                    programValue: programValue,
                    programPeriod: programPeriod,
                    programFee: programFee,
                },
                _token: "{{ csrf_token() }}"

            }).done(function(response) {
                console.log(response);
                if (response==1) {
                    successSound.play();
                    Command: toastr["success"]("Updated successfully", "Success")

                }else if (response==0) {
                    errorSound.play();
                    Command: toastr["error"]("Update Something", "Error")

                }
                else {
                    errorSound.play();
                    Command: toastr["error"](response,'Error')

                }




            });
        }

    }

    function updateAdminPayments() {
             let programAdminClickType=$('input[name=programAdminClickType]:checked').val();
             let programAdminLeadType=$('input[name=programAdminLeadType]:checked').val();
             let programAdminSaleType=$('input[name=programAdminSaleType]:checked').val();
             let programAdminImpression=$('input[name=programAdminImpression]').val();

             let programAdminClick=$('input[name=programAdminClick]').val();
             let programAdminLead=$('input[name=programAdminLead]').val();
             let programAdminSale=$('input[name=programAdminSale]').val();

            let Err=0;
            if(parseInt(programAdminImpression) < 0 || parseInt(programAdminClick) < 0 || parseInt(programAdminLead) < 0 ||parseInt(programAdminSale) < 0){
                    errorSound.play();
                    Command: toastr["error"]("Cannot Input Negative Value", "Error")
                Err=1;

            }else if((programAdminImpression) =='' || (programAdminClick) =='' || (programAdminLead)  =='' ||(programAdminSale) ==''){

              errorSound.play();
                    Command: toastr["error"]("Nothing Can Be NULL", "Error")
                Err=1;
            }


            if(Err==0){
                Err=0;
                console.log('Else Con');
                $('.programValueErr').html("");



            $.ajax({
                type: "POST",
                url: "{{ url('Program/UpdateAdminPayments') }}/" + programId,
                data: {
                    programAdminClickType:programAdminClickType,
                    programAdminLeadType: programAdminLeadType,
                    programAdminSaleType: programAdminSaleType,
                    programAdminImpression: programAdminImpression,
                    programAdminClick: programAdminClick,
                    programAdminLead: programAdminLead,
                    programAdminSale: programAdminSale,

                },
                _token: "{{ csrf_token() }}"

            }).done(function(response) {
                console.log(response);
                if (response==1) {
                    successSound.play();
                    Command: toastr["success"]("Updated successfully", "Success")

                }else if (response==0) {
                    errorSound.play();
                    Command: toastr["error"]("Update Something", "Error")

                }
                else {
                    errorSound.play();
                    Command: toastr["error"](response,'Error')

                }




            });
        }

    }
    </script>
@endsection

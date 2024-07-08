@php
    $symbol=DB::table('partners_currency')
         ->where('currency_code','=',SiteHelper::getConstant('siteCurrencyCode'))
         ->select('currency_symbol')->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Programs')

@section('content')

    <div class="row-fluid">
        
        <div class="span12 ">
            <input value="{{$programs->program_id}}" name="programId" type="hidden">
      
                    @if ($programs == null)
                        <div class='alert alert-danger'>
                            <strong>No Program Found</strong>
                        </div>
                    @else
                        <div class="row-fluid">
                            <div class='span6'>

                            </div>

                        <div class='span6'>
                            <div class=" ">
                                @if ($programs->program_status == 'inactive')
                                    <a class="btn btn-medium btn-success"
                                        href="{{ route('Program.changeProgramStatus', $Pid) }}">Approve <i
                                            class='icon-ok icon-white'></i></a>
                                @else
                                    <a class="btn btn-medium btn-danger"
                                        href="{{ route('Program.changeProgramStatus', $Pid) }}">Reject <i
                                            class='icon-remove icon-white'></i></a>
                                @endif
                                <a class="btn btn-medium btn-info" href="#showMerchant{{ $programs->program_merchantid }}"
                                    role="button" data-toggle="modal">View Merchant Details</a>

                            </div>


                        </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">

                        <h2><b class="text-danger">{{ $programs->program_url }}</b></h2>


                        <p>{{ $programs->program_description }}</p>
                    </div>
                    <div class="col-lg-4 row-fluid">
                        <a class="icon-btn span2" href="javascript:;" onclick="javascript:getAffiliates();">
                        <i class="icon-th-large"></i>
                        <div>Registered Affiliates</div>
                        <span class="badge badge-important">{{ $totalAffiliates }}</span>
                    </a>


                    <a class="icon-btn span2" href="{{route('Program.product' , [$Pid,'all'] )}}" role="button" data-toggle="modal">
                        <i class="icon-shopping-cart"></i>
                        <div>Products</div>
                        <span class="badge badge-important">
                            <?php echo count($products); ?>
                        </span>
                    </a>
                    </div>

                </div>






                {{-- <div class='row-fluid'>

              </div> --}}




                <div class='row-fluid'>
                    <div class='span12'>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-success"><strong> Success !</strong>
                                {{ session()->get('success') }} <i class=" icon-ok"></i> <button data-dismiss="alert" class="close" type="button">×</button>
                            </div>
                        @endif
                        @if (session()->has('danger'))
                            <div class="alert alert-danger"><strong> Error !</strong>
                                {{ session()->get('danger') }} <i class=" icon-warning-sign"></i> <button data-dismiss="alert" class="close" type="button">×</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class='row-fluid'>
                    <div class='span12'>
                        <center>
                            <h2 class='text-info' style="font-family:Cambria; font-size:bold;">Comissions</h2>
                        </center>
                        <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                                <tr>

                                    <th class="hidden-phone">Type</th>
                                    <th class="hidden-phone">Comission</th>
                                    <th class="hidden-phone">Approvel</th>
                                    <th class="hidden-phone">Email Setting</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr class="odd gradeX">

                                    <td>Impression</td>
                                    <td class="hidden-phone">{{ $programs->program_impressionrate }}</td>

                                    <td class="hidden-phone">
                                        @if ($programs->program_impressionapproval == 'manual')
                                            <span
                                                class="label label-warning">{{ $programs->program_impressionapproval }}</span>
                                        @else
                                            <span
                                                class="label label-info">{{ $programs->program_impressionapproval }}</span>
                                        @endif
                                    </td>
                                    <td class="hidden-phone">
                                        @if ($programs->program_impressionmail == 'manual')
                                            <span
                                                class="label label-warning">{{ $programs->program_impressionmail }}</span>
                                        @else
                                            <span class="label label-info">{{ $programs->program_impressionmail }}</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr class="odd gradeX">

                                    <td>Click</td>
                                    <td class="hidden-phone">{{ $programs->program_clickrate }}</td>

                                    <td class="hidden-phone">
                                        @if ($programs->program_clickapproval == 'manual')
                                            <span
                                                class="label label-warning">{{ $programs->program_clickapproval }}</span>
                                        @else
                                            <span class="label label-info">{{ $programs->program_clickapproval }}</span>
                                        @endif
                                    </td>

                                    <td class="hidden-phone">
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
                </div>
                <div class='row-fluid'>
                    <div class='span12'>
                        <center>
                            <h2 class='text-info'>Commission Structure 1</h2>
                        </center>
                        <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                                <tr>

                                    <th class="hidden-phone">Type</th>
                                    <th class="hidden-phone">From</th>
                                    <th class="hidden-phone">To</th>
                                    <th class="hidden-phone">Comissins</th>
                                    <th class="hidden-phone">Approvel</th>
                                    <th class="hidden-phone">Email Setting</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX">

                                    <td>Lead</td>
                                    <td class="hidden-phone">{{ $comission->commission_lead_from }}</td>
                                    <td class="hidden-phone">{{ $comission->commission_lead_to }}</td>

                                    <td class="hidden-phone">{{ $comission->commission_leadrate }}</td>

                                    <td class="hidden-phone">
                                        @if ($comission->commission_leadapproval == 'manual')
                                            <span
                                                class="label label-warning">{{ $comission->commission_leadapproval }}</span>
                                        @else
                                            <span
                                                class="label label-info">{{ $comission->commission_leadapproval }}</span>
                                        @endif
                                    </td>


                                    <td class="hidden-phone">
                                        @if ($comission->commission_leadmail == 'manual')
                                            <span
                                                class="label label-warning">{{ $comission->commission_leadmail }}</span>
                                        @else
                                            <span class="label label-info">{{ $comission->commission_leadmail }}</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr class="odd gradeX">

                                    <td>Sale</td>
                                    <td class="hidden-phone">{{ $comission->commission_sale_from }}</td>
                                    <td class="hidden-phone">{{ $comission->commission_sale_to }}</td>

                                    <td class="hidden-phone">{{ $comission->commission_salerate }}</td>

                                    <td class="hidden-phone">
                                        @if ($comission->commission_saleapproval == 'manual')
                                            <span
                                                class="label label-warning">{{ $comission->commission_saleapproval }}</span>
                                        @else
                                            <span
                                                class="label label-info">{{ $comission->commission_saleapproval }}</span>
                                        @endif
                                    </td>


                                    <td class="hidden-phone">
                                        @if ($comission->commission_salemail == 'manual')
                                            <span
                                                class="label label-warning">{{ $comission->commission_salemail }}</span>
                                        @else
                                            <span class="label label-info">{{ $comission->commission_salemail }}</span>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class='row-fluid'>
                    <div class='span12'>
                        <center>
                            <h2 class='text-info'>Recurring Sale Commission</h2>
                        </center>
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

                <div class='row-fluid'>
                    <div class='span12'>


                        <div class="widget blue">
                            <div class="widget-title">
                                <h4> Program Fee</h4>
                                <span class="tools">

                                </span>
                            </div>
                            <div class="widget-body">
                                <form action="{{ route('Program.updateFee', $Pid) }}" class='form-horizontal'
                                    method='POST'>
                                    @csrf
                                    <div class="control-group">
                                        <label class="control-label">Program Fee</label>
                                        <div class="controls">
                                            <div class="input-prepend input-append">
                                                <span class="add-on">@php
                                            echo $symbol->currency_symbol
                                        @endphp </span><input name='programFee'
                                                    class=" " type="number"
                                                    value='{{ $programs->program_fee }}' required /><span
                                                    class="add-on">.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Program Type</label>
                                        <div class="controls">
                                            <label class="radio">

                                                <input type="radio" onclick='showDiv(this)' name="programType"
                                                    value="{{ $programs->program_type == 1 ? $programs->program_type : '1' }}"
                                                    <?php echo $programs->program_type == 1 ? "checked='checked'" : ''; ?> />
                                                One Time
                                            </label>
                                            <label class="radio">
                                                <input type="radio" onclick='showDiv(this)' id='onRecurringSelected'
                                                    name="programType"
                                                    value='{{ $programs->program_type == 2 ? $programs->program_type : 0 }}'
                                                    <?php echo $programs->program_type == 2 ? "checked='checked'" : ''; ?> />
                                                Recurring
                                            </label>



                                        </div>
                                    </div>


                                    <div id='RecurringSelected' class="control-group offset1">
                                        <label class="control-label"></label>
                                        <div class="controls">

                                            <input type="text" name='programValue' placeholder="Value"
                                                value="{{ substr($programs->program_value, 0,strpos($programs->program_value," ")) }}"
                                                class="input-mini" required />
                                            <select name='programPeriod' class="input-small m-wrap" tabindex="1">

                                                <option value="day" <?php echo substr($programs->program_value, 2) == 'day' ? 'selected' : ''; ?>>Day(s)</option>
                                                <option value="month" <?php echo substr($programs->program_value, 2) == 'month' ? 'selected' : ''; ?>>Month(s)</option>
                                                <option value="year" <?php echo substr($programs->program_value, 2) == 'year' ? 'selected' : ''; ?>>Year(s)</option>

                                            </select>
                                        </div>
                                    </div>




                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><i class="icon-edit"></i>
                                            Update Program Fee</button>

                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class='row-fluid'>
                    <div class='span12'>
                        <div class="widget blue">
                            <div class="widget-title">
                                <h4> Email and Program Settings</h4>
                                <span class="tools">

                                </span>
                            </div>
                            <div class="widget-body">

                                <div class='row-fluid'>
                                    <div class='span4'>
                                        <p> <b>Send email to affiliate when transaction appears : </b></p>
                                    </div>
                                    <div class='span2'>
                                        {{ $programs->program_mailaffiliate }}
                                    </div>
                                </div>

                                <div class='row-fluid'>
                                    <div class='span4'>
                                        <p><b>Send email to me when transaction appears : </b></p>
                                    </div>
                                    <div class='span2'>
                                        {{ $programs->program_mailmerchant }}
                                    </div>
                                </div>

                                <div class='row-fluid'>
                                    <div class='span4'>
                                        <p> <b>Affiliate Approval :</b> </p>
                                    </div>
                                    <div class='span2'>
                                        @if ($programs->program_affiliateapproval == 'manual')
                                            <span
                                                class="label label-warning">{{ $programs->program_affiliateapproval }}</span>
                                        @else
                                            <span
                                                class="label label-info">{{ $programs->program_affiliateapproval }}</span>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <div class='row-fluid'>
                    <div class='span12'>
                        <div class="widget blue">
                            <div class="widget-title">
                                <h4> Change Transaction Amounts</h4>
                                <span class="tools">

                                </span>
                            </div>
                            <div class="widget-body">
                                @if (count($errors) > 0)
                                    <div class="error alert alert-danger">
                                        <h3><strong>Errors</strong> </h3>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('Program.updateAdminPayments', $Pid) }}" class="form-horizontal"
                                    method="POST">

                                    @csrf
                                    <div class="control-group">
                                        <label class="control-label">Program Fee</label>
                                        <div class="controls">
                                            <div class="input-prepend input-append">
                                                <span class="add-on">@php
                                                    echo $symbol->currency_symbol
                                                @endphp</span><input name='programAdminImpression'
                                                    class=" input-medium" type="number"
                                                    value='{{ $programs->program_admin_impr }}' required /><span
                                                    class="add-on">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">


                                        <div class='row-fluid'>

                                            <div class='span3'>
                                                <label class="control-label">Click Rate</label>
                                                <div class="controls">
                                                    <input name='programAdminClick' type="number"
                                                        placeholder="Click Rate" class="input-medium"
                                                        value='{{ $programs->program_admin_click }}' required />

                                                </div>
                                            </div>
                                            <div class='span4'>
                                                <div class="controls">
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminClickType" value="$"
                                                            <?php echo $programs->program_admin_clicktype == '$' ? "checked='checked'" : ''; ?> />
                                                            @php
                                                            echo $symbol->currency_symbol
                                                        @endphp
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminClickType" value="%"
                                                            <?php echo $programs->program_admin_clicktype == '%' ? "checked='checked'" : ''; ?> />
                                                        %
                                                    </label>
                                                </div>
                                            </div>

                                        </div>






                                    </div>
                                    <div class="control-group">


                                        <div class='row-fluid'>

                                            <div class='span3'>
                                                <label class="control-label">Lead Rate</label>
                                                <div class="controls">
                                                    <input name='programAdminLead' type="number" placeholder="Lead Rate"
                                                        class="input-medium"
                                                        value='{{ $programs->program_admin_lead }}' required />

                                                </div>
                                            </div>
                                            <div class='span4'>
                                                <div class="controls">
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminLeadType" value="$"
                                                            <?php echo $programs->program_admin_leadtype == '$' ? "checked='checked'" : ''; ?> />
                                                            @php
                                                            echo $symbol->currency_symbol
                                                        @endphp
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminLeadType" value="%"
                                                            <?php echo $programs->program_admin_leadtype == '%' ? "checked='checked'" : ''; ?> />
                                                        %
                                                    </label>
                                                </div>
                                            </div>

                                        </div>






                                    </div>

                                    <div class="control-group">


                                        <div class='row-fluid'>

                                            <div class='span3'>
                                                <label class="control-label">Sale Rate</label>
                                                <div class="controls">
                                                    <input name='programAdminSale' type="number" placeholder="Sale Rate"
                                                        class="input-medium"
                                                        value='{{ $programs->program_admin_sale }}' required />

                                                </div>
                                            </div>
                                            <div class='span4'>
                                                <div class="controls">
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminSaleType" value="$"
                                                            <?php echo $programs->program_admin_saletype == '$' ? "checked='checked'" : ''; ?> />
                                                            @php
                                                            echo $symbol->currency_symbol
                                                        @endphp
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="programAdminSaleType" value="%"
                                                            <?php echo $programs->program_admin_saletype == '%' ? "checked='checked'" : ''; ?> />
                                                        %
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"><i class="icon-edit"></i>
                                            Modify Transaction Rates</button>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>



                <div class='row-fluid'>
                    <div class='span12'>
                        <center>
                            <h2 class='text-info'>Advertising Links</h2>
                        </center>
                        <table class="table table-striped table-bordered table-hover table-advance" id="sample_1">
                            <thead>
                                <tr>

                                    <th class="hidden-phone">Text</th>
                                    <th class="hidden-phone">Template Text</th>
                                    <th class="hidden-phone">HTML</th>
                                    <th class="hidden-phone">Banner</th>
                                    <th class="hidden-phone">Popup</th>
                                    <th class="hidden-phone">Flash</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX">

                                    <td class="hidden-phone"><a href='{{ route('Program.text', [$Pid,'all']) }}'><span
                                                class='badge bg-success'>{{ $advLinks['text_old'] }}</span></a></td>
                                    <td class="hidden-phone"><a href='{{ route('Program.templateText',  [$Pid,'all']) }}'><span
                                                class='badge bg-warning'> {{ $advLinks['text'] }}</span></a></td>
                                    <td class="hidden-phone"><a href='{{ route('Program.html',  [$Pid,'all']) }}'><span
                                                class='badge bg-info'>{{ $advLinks['html'] }}</a></td>

                                    <td class="hidden-phone"><a href='{{ route('Program.banner',  [$Pid,'all']) }}'><span
                                                class='badge bg-danger'>{{ $advLinks['banner'] }}</span></a></td>
                                    <td class="hidden-phone"><a href='{{ route('Program.popup',  [$Pid,'all']) }}'><span
                                                class='badge bg-primary'>{{ $advLinks['popup'] }}</span></a></td>

                                    <td class="hidden-phone"><a href='{{ route('Program.flash',  [$Pid,'all']) }}'><span
                                                class='badge bg-dark'>{{ $advLinks['flash'] }}</span></a></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
                
                
                @include('merchant.show')
                @include('program.products')
                @endif
            

       
    </div>
    </div>



@endsection

@section('script')
    <script>
         var successSound = new Audio("{{ asset('audio/success.mp3') }}");
            var errorSound = new Audio("{{ asset('audio/error.mp3') }}");
            var warningSound = new Audio("{{ asset('audio/warning.wav') }}");
         var programId= $('input[name=programId]').val();
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

        function getAffiliates(){
            var  _token = "{{ csrf_token() }}";



            $.ajax({
                type :"POST",
                url:"{{url('Program/GetAffiliates')}}",
                data:{
                    programId:programId
                },
                _token:"{{ csrf_token() }}"

            }).done(function(response){
                console.log('Data',response);
                var table='';
                if(response.length==0){
                    table="<p>No Affiliates Registered</p>";

                }
                else{

               
                table="<table class='table table-hover' style='font-size:12px'>  <thead><th>Affiliate</th><th>Action</th></thead><tbody>";
                for (let index = 0; index < response.length; index++) {
                    table+="<tr>";
                        table+="<td>"+response[index].affiliate_company+"</td>";
                        if(response[index].joinpgm_commissionid==response[index].commission_id){
                            table+="<td><button onclick='javascript:removeCommission("+response[index].affiliate_id+");' class='btn btn-danger'>Remove</button></td>";
                        }
                        else {
                            table+="<td><button onclick='javascript:makeDefaultCommission("+response[index].affiliate_id+");' class='btn btn-success'>Make Default Commiccion</button></td>";

                        }


                    table+="</tr>";


                }
                table+="</tbody></table>";
                          }

                Swal.fire({
                title: "Affiliates Commission",
                html:table,

            });

            })
            .fail(function(xhr, ajaxOptions, thrownError){
                console.log(thrownError);

            });



        }
        function makeDefaultCommission(affiliateId){
            $.ajax({
                type :"POST",
                url:"{{url('Program/UpdateComission')}}/"+programId,
                data:{
                    comissionAffiliateId:affiliateId,
                    comissionProgramId:programId,
                    mode:'set',
                    commissionComissionId:programId,
                },
                _token:"{{ csrf_token() }}"

            }).done(function(response){
                if(response){
                    successSound.play();
                     Command: toastr["success"]("Assigned Commission successfully", "Success")

                }
                else{
                    errorSound.play();
                     Command: toastr["error"]("Error in Assigning Commisison", "Error")

                }




            });

        }
        function removeCommission(affiliateId){
            $.ajax({
                type :"POST",
                url:"{{url('Program/UpdateComission')}}/"+programId,
                data:{
                    comissionAffiliateId:affiliateId,
                    comissionProgramId:programId,
                    mode:'remove',
                },
                _token:"{{ csrf_token() }}"

            }).done(function(response){
                if(response){
                    successSound.play();
                     Command: toastr["success"]("Removed successfully", "Success")

                }
                else{
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
    </script>
@endsection

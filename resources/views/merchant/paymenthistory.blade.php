@php
    $symbol=DB::table('partners_currency')
         ->where('currency_code','=',SiteHelper::getConstant('siteCurrencyCode'))
         ->select('currency_symbol')->first();
         $merchantData=DB::table('partners_merchant')
         ->where('merchant_id','=',$id)->first();

@endphp
@extends('layouts.masterClone')

@section('title', 'Merchant Payment History')

@section('content')
 <h1>Payment History of 
     @if($merchantData)
     <span class="text-info">
     {{$merchantData->merchant_company}}
    </span>
    @else
    <span class="text-info">
         Unknown Merchant
       </span>
    @endif
    </h1>
 <hr>
<div class='row-fluid'>
          <div class="span12">
                  
                             <div>
                                 <div class="clearfix">

                                 <form action="{{route('Merchant.paymentHistoryByDate',$id)}}" method="POST" class="form-horizontal">
                                  @csrf

                                 <div class="control-group">
                                    <label class="control-label">From Date</label>
                                    <div class="controls">
                                        <input type="date" name='From' placeholder="From" class="input-medium" required/>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">To Date</label>
                                    <div class="controls">
                                        <input type="date" name='To' placeholder="To" class="input-medium" required/>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <button type='submit' class="btn btn-success" >View</button>
                                        <a href="{{route('Merchant.paymentHistoryForm',$id)}}" type='submit' class="btn btn-secondary" >Reset</a>

                                    </div>
                                </div>

                                   </form>
                                 </div>



                             </div>
                        
</div>
            </div>

            <div class='row-fluid'>
          <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE widget-->
                     <div class="widget blue">
                         <div class="widget-title">
                             <h4> Account Details ( Related To Transaction )</h4>
                     
                         </div>
                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">
                                <table class='table table-hover table-striped'>
                                   <thead>

                                       <th>Affiliate</th>
                                       <th>Date of Payment</th>
                                       <th>Transaction</th>
                                       <th>Amount</th>


                                   </thead>
                                   <tbody>
                                   @if(session()->has('message'))
                                   <tr>
                                         <td>   <div class="alert alert-danger">
                                             {{ session()->get('message') }} No data
                                             </div></td>

                                  </tr>

                                     @else
                                       @foreach($data as $datas)
                                       <tr>

                                           <td>{{$datas->affiliate_firstname}} {{$datas->affiliate_lastname}}</td></td>
                                           <td>	{{$datas->transaction_dateofpayment}}</td>
                                           <td>{{$datas->transaction_type}}</td>
                                           <td>@php
                                            echo $symbol->currency_symbol
                                        @endphp {{$datas->transaction_amttobepaid + $datas->transaction_admin_amount }}</td>
                                       </tr>
                                       @endforeach


                                 @endif

                                   </tbody>
                                   <tfoot>

                                       <th>Affiliate</th>
                                       <th>Date of Payment</th>
                                       <th>Transaction</th>
                                       <th>Amount</th>
                                   </tfoot>
                                </table>

                                 </div>

                             </div>
                         </div>
                     </div>
         </div>
            </div>
            <div class='row-fluid'>
          <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE widget-->
                     <div class="widget blue">
                         <div class="widget-title">
                             <h4> Account Details ( Withdrawn / Deposited )</h4>
                           
                         </div>
                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">
                                <table class='table table-hover table-striped'>
                                   <thead>
                                       <th>Merchant</th>

                                       <th>Date of Payment</th>
                                       <th>Transaction</th>
                                       <th>Amount</th>
                                   </thead>
                                   <tbody>
                                   @if(session()->has('message'))
                                     <tr>
                                         <td>   <div class="alert alert-danger">
                                             {{ session()->get('message') }} No data
                                             </div></td>

                                        </tr>

                                     @else
                                   @foreach($merchants as $merchant)
                                       <tr>

                                           <td>{{$merchant->merchant_firstname}} {{$merchant->merchant_lastname}}</td></td>
                                           <td>	{{$merchant->adjust_date}}</td>
                                           <td>{{$merchant->adjust_action}}</td>
                                           <td>@php
                                               echo $symbol->currency_symbol
                                           @endphp {{$merchant->adjust_amount }}</td>
                                       </tr>
                                       @endforeach
                                      @endif
                                   </tbody>
                                   <tfoot>
                                       <th>Merchant</th>

                                       <th>Date of Payment</th>
                                       <th>Transaction</th>
                                       <th>Amount</th>
                                   </tfoot>
                                </table>

                                 </div>

                             </div>
                         </div>
                     </div>

         </div>
            </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
       $('table').DataTable();
    });
</script>
@endsection

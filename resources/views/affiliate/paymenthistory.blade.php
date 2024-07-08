
@php
$symbol=DB::table('partners_currency')
     ->where('currency_code','=',SiteHelper::getConstant('siteCurrencyCode'))
     ->select('currency_symbol')->first();
     $affiliateData=DB::table('partners_affiliate')
     ->where('affiliate_id','=',$id)->first();

@endphp
@extends('layouts.masterClone')

@section('title', 'Affiliate Payment History')

@section('content')
<h1>Payment History of 
    @if($affiliateData)
    <span class="text-info">
    {{$affiliateData->affiliate_company}}
   </span>
   @else
   <span class="text-info">
        Unknown Merchant
      </span>
   @endif
   </h1>
<hr>
                                    @if(session()->has('message'))
                                      <div class="alert alert-danger">
                                             {{ session()->get('message') }} No data
                                             </div>
                                             @endif
<div class='row-fluid'>
    
          <div class="span12" >
                     <!-- BEGIN EXAMPLE TABLE widget-->
                     <div class="">
                         

                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">
        
                                 <form action="{{route('Affiliate.paymentHistoryByDate',1)}}" method="POST" class="form-horizontal">
                                  @csrf

                                 <div class="control-group">
                                    <label class="control-label">From Date</label>
                                    <div class="controls">
                                        <input type="date" name='From' placeholder="From" class="input-medium" />
                                      
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">To Date</label>
                                    <div class="controls">
                                        <input type="date" name='To' placeholder="To" class="input-medium" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"></label>
                                     <div class="controls">
                                        <button type='submit' class="btn btn-success" >View</button>
                                        <a href="{{route('Affiliate.paymentHistoryForm',$id)}}" type='submit' class="btn btn-secondary" >Reset</a>

                                    </div>
                                </div>

                                   </form>
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
                             <h4> Account Details ( Related To Transaction )</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
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

                                           <td>{{$datas->affiliate_firstname}} {{$datas->affiliate_lastname}}</td>
                                           <td>	{{$datas->transaction_dateofpayment}}</td>
                                           <td>
                                           @if ($datas->transaction_type == 'click')
                                           <span class="label label-info">Click</span>
                                            @elseif($datas->transaction_type == 'Impression')
                                                <span class="label label-success">Impression</span>
                                            @elseif($datas->transaction_type == 'lead')
                                                <span class="label label-danger">Lead</span>
                                            @elseif($datas->transaction_type == 'sale')
                                                <span class="label label-warning">Sale</span>
                                            @endif
                                          </td>
                                           <td>£ {{$datas->transaction_amttobepaid + $datas->transaction_admin_amount }}</td>
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
                     <div class="widget red">
                         <div class="widget-title">
                             <h4><i class="icon-reorder"></i> Account Details ( Withdrawn / Deposited )</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <a href="javascript:;" class="icon-remove"></a>
                            </span>
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
                                           <td>	{{$merchant->merchant_date}}</td>
                                           <td>@if($merchant->adjust_action=="deposit")
                                            <span class="label label-warning">Deposit</span>
                                        @endif
                                        </td>
                                           <td>£ {{$merchant->adjust_amount }}</td>
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
        $(document).ready(function() {
            $('table').DataTable();
        });
    </script>
@endsection
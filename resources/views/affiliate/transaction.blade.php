@php
$symbol = DB::table('partners_currency')
    ->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
    ->select('currency_symbol')
    ->first();
    $affiliateData=DB::table('partners_affiliate')
         ->where('affiliate_id','=',$id)->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Affiliate Transactions')

@section('content')
<h1>Transaction History of 
    @if($affiliateData)
    <span class="text-info">
    {{$affiliateData->affiliate_company}}
   </span>
   @else
   <span class="text-info">
        Unknown Affiliate
      </span>
   @endif
   </h1>
<div class='row-fluid'>
          <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE widget-->
                     <div class="card">
                         <div class="widget-body">
                             <div>
                                 <div class="clearfix">

                                 <table class='table table-hover table-striped'>
                                   <thead>

                                       <th>Type</th>
                                       <th>Merchant</th></th>
                                       <th>Affiliate</th>
                                       <th>Commission</th>
                                       <th>Date</th>
                                       <th>Status</th>

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
                                           <td><a href="#">{{$datas->merchant_firstname}}{{$datas->merchant_lastname}}</a></td>
                                           <td><a href="#">{{$datas->affiliate_firstname}}{{$datas->affiliate_lastname}}</a></td>
                                           <td>£ {{$datas->transaction_amttobepaid}}</td>
                                           <td>{{ $datas->transaction_dateofpayment}}</td>
                                           <td>
                                            @if ($datas->transaction_status== 'reversed')
                                            <span class="label label-warning">Reversed</span>
                                            @elseif($datas->transaction_status == 'approved')
                                            <span class="label label-success">Approved</span>
                                            @endif
                                        </td>
                                       </tr>
                                       @endforeach
                                       @endif
                                   </tbody>
                                   <tfoot>

                                        <th>Type</th>
                                       <th>Affiliate</th></th>
                                       <th>Affiliate</th>
                                       <th>Commission</th>
                                       <th>Date</th>
                                       <th>Status</th>
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
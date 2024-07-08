@php
$symbol = DB::table('partners_currency')
    ->where('currency_code', '=', SiteHelper::getConstant('siteCurrencyCode'))
    ->select('currency_symbol')
    ->first();
    $merchantData=DB::table('partners_merchant')
         ->where('merchant_id','=',$id)->first();
@endphp
@extends('layouts.masterClone')

@section('title', 'Merchant Payment History')

@section('content')
<h1>Transaction History of 
     @if($merchantData)
     <span class="text-info">
     {{$merchantData->merchant_firstname}} {{$merchantData->merchant_lastname}}
    </span>
    @else
    <span class="text-info">
         Unknown Merchant
       </span>
    @endif
    </h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card">
          
                <div class="card-body">
                    <table class='table table-hover table-striped'>
                        <thead>

                            <th>Type</th>
                            <th>Merchant</th>
                    
                            <th>Affiliate</th>
                            <th>Comission</th>
                            <th>Date</th>
                            <th>Status</th>

                        </thead>
                        <tbody>
                            @foreach ($data as $datas)
                                <tr>

                                    <td>{{ $datas->transaction_type }}</td>
                                    <td>{{ $datas->merchant_company }}</td>
                                    <td>{{ $datas->affiliate_company }}</td>
                                    <td>
                                        @php
                                            echo $symbol->currency_symbol;
                                        @endphp {{ $datas->transaction_amttobepaid }}</td>
                                    <td>{{ $datas->transaction_dateofpayment }}</td>
                                    <td>{{ $datas->transaction_status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                            <th>Type</th>
                            <th>Merchant</th>

                            <th>Affiliate</th>
                            <th>Comission</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tfoot>
                    </table>
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

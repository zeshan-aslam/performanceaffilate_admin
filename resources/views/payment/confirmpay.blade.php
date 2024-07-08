@foreach($affreqs as $affreq)

<div id="ConfirmAffiliate{{$affreq->affiliate_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3">Confirm Pay</h3>
           </div>
           <div class="modal-body">
               <strong>{{$affreq->affiliate_firstname}}  {{$affreq->affiliate_lastname}} and {{$affreq->affiliate_company}} </strong>
               <p>Are you sure to proceed <strong>{{$affreq->request_amount}} USD</strong> Transaction via <strong>{{$affreq->bankinfo_modeofpay}}</strong></p>
               <p id='deleteTitle'>Payment Gateway used is {{$affreq->bankinfo_modeofpay}}. Before making payment through the sytem make sure that you have made the actual payment through <strong>{{$affreq->bankinfo_modeofpay}}</strong>.</p>
               <!-- <p style="text-align:center;">Copyright 2022 © AlstraSoft Affiliate Network Pro. All Rights Reserved.</p> -->
            </div>
           <div class="modal-footer">
         @if($affreq->bankinfo_modeofpay=='Paypal')
            <form  action="{{url('paypal',$affreq->request_amount)}}"  Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='WireTransfer' || $affreq->bankinfo_modeofpay=='CheckByMail')
            <form  action="{{url('https://searlco.net/index.php?Act=affiliate',$affreq->request_amount)}}" id="affilate" Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='2checkout')
            <form  action="{{url('https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c',$affreq->request_amount)}}" id="affilate" Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='Stormpay')
            <form  action="{{url('https://www.stormpay.com/stormpay/handle_gen.php',$affreq->request_amount)}}" id="affilate" Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='E-Gold')
            <form  action="{{url('https://www.e-gold.com/sci_asp/payments.asp',$affreq->request_amount)}}" id="affilate" Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='NETeller')
            
                <form  action="{{url('https://www.neteller.com/en/features/new?gclid=Cj0KCQjw_4-SBhCgARIsAAlegrVmpbz-Yt1gf26bWYsbTTA9gWdl6vKV-Rwq-5T8_rV5esQPnm0XDt4aAmd5EALw_wcB&gclsrc=aw.ds',$affreq->request_amount)}}" id="affilate" Method="POST">
            
                @elseif($affreq->bankinfo_modeofpay=='Autherize.net')
            <form  action="{{url('payment',$affreq->request_amount)}}" id="affilate" Method="POST">
        @endif 
               @csrf
                <input type='hidden' name='merchant_id' >
               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button type='submit'  class="btn btn-danger">Proceed</button>
            </form>

                       </div>
   </div>
  
@endforeach


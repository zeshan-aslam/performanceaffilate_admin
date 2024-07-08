
@foreach ($affiliates as $affModel)

<div id="DeleteAffiliate{{$affModel->affiliate_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3">Delete</h3>
           </div>
           <div class="modal-body">
               <p id='deleteTitle'>Do You Want To Remove the <strong>{{$affModel->affiliate_firstname}} {{$affModel->affiliate_lastname}} </strong> of <strong>{{$affModel->affiliate_company}} </strong> Permanently ?</p>
               <!-- <p style="text-align:center;">Copyright 2022 © AlstraSoft Affiliate Network Pro. All Rights Reserved.</p> -->
            </div>
           <div class="modal-footer">
           <form id="deleteForm" action="{{route('Affiliate.destroy',$affModel->affiliate_id)}}" Method="POST">
               @method("DELETE")
              
               @csrf
                <input type='hidden' name='merchant_id' >
               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
               <button type='submit'  class="btn btn-danger">Delete</button>
            </form>
                       </div>
   </div>
@endforeach







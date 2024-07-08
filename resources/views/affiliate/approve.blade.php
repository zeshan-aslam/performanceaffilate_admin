
    <!-- Modal-Approve -->
@foreach ($affiliates as $affModel)

<div id="affModel{{$affModel->affiliate_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel3" style="color:red">Approve and Set Commission Group for Affiliate, Searlco Com</h3>
         Do you wants to perform this action for {{$affModel->affiliate_firstname}} ? 
    </div>
    
    <div class="modal-body">
    <form method="POST" action="{{route('Affiliate.approveIt')}}" >
        <div class="control-group form-horizontal">
        <label class="control-label">Commession Group</label>
        <div class="controls">
        @csrf
       
        <select class="input-medium" name="group" >
        <option value="0">No Tier Commession</option>
        <!-- <option value="Tier Of Commession">Tier of Commession</option> -->
        </select>
        <input value="{{$affModel->affiliate_id}}"  type="hidden" name="consAff"> 
        </div> 
        </div>
    </div>
    
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Approve</button>
        </form>
    </div>
    
</div>
@endforeach

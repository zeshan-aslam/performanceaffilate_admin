
<!-- Set of commession Modal -->
@foreach ($affiliates as $affModelset)
<!-- Modal -->
<div id="affModelset{{$affModelset->affiliate_id}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel3" style="color:red">Set Commission Group for Affiliate, Searlco Com</h3>
         Do you wants to perform this action for {{$affModelset->affiliate_firstname}} ?
    </div>

    <div class="modal-body">
    <form method="POST" action="{{route('Affiliate.setcommission',$affModelset->affiliate_id)}}" >
    @csrf
        <div class="control-group form-horizontal">
        <label class="control-label">Commession Group</label>
        <div class="controls">

        <select class="input-medium" name="groupId"  >
           <option value="0">No Tier Commession</option>
           @foreach($affiliateGroups as $affiliateGroup)
           <option value="{{$affiliateGroup->affiliategroup_id}}">{{$affiliateGroup->affiliategroup_title}}</option>
           @endforeach

        </select>
        <input value="{{$affModelset->affiliate_id}}"  type="hidden" name="id">
        </div>
        </div>



    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary">Set</button>
        </form>
    </div>

</div>
@endforeach
<!--End Modal  -->

 <!-- Modal-Approve -->
 @foreach ($affreqs as $affreq)

<div id="affModeladjsmoney{{$affreq->pay_affiliateid}}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel3" style="color:red">Adjust Money</h3>
    </div>
    <div class="modal-body">
   
    <form action="{{route('payment.adjustMoney', $affreq->pay_affiliateid)}}" method='POST'class="form-horizontal">
                               
                                   @csrf
                                
                            
                                   <div class="control-group">
                                    <label class="control-label">Current Balance</label>
                                    <div class="controls">
                                    <input type="number" value='{{$affreq->pay_amount}}'  class="input-medium" disabled='disabled'/>

                                        <input type="hidden" name='old_pay_amount' value='{{$affreq->pay_amount}}' placeholder="Current Amount" class="input-medium"/>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Amount</label>
                                    <div class="controls">
                                        <input type="number" name='pay_amount'  placeholder="Amount" class="input-medium" required/>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Action</label>
                                    <div class="controls">
                                        <select name='action'class="input-medium" >
                                            <option value="add">Add</option>
                                            <option value="deduct">Deduct</option>
                                        </select>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                
                                  
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-success">Payment</button>
    </div>
    </form>
</div>
@endforeach

     



<div id="adjustMoneyMerchant" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel3">Adjust Money</h3>
           </div>
           <div class="modal-body">
           <div class="form-horizontal">



                                 <div class="control-group">
                                    <label class="control-label">Current Amount</label>
                                    <div class="controls">


                                        <input type="text" name='old_pay_amount'  placeholder="Current Amount" class="input-medium" readonly/>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Amount</label>
                                    <div class="controls">
                                        <input type="number" name='pay_amount'  placeholder="Amount" class="input-medium" required/>
                                        <span id='AmountError'class="help-inline text-error"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Action</label>
                                    <div class="controls">
                                        <select name='action'class="input-medium" >
                                            <option value="add">Add</option>
                                            <option value="deduct">Deduct</option>
                                        </select>

                                    </div>
                                </div>
                     </div>
           <div class="modal-footer">
               <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
               <button  id='adjustMoneyBtn'  class="btn btn-success">Adjust Money</button>
           </div>
           </div>
   </div>









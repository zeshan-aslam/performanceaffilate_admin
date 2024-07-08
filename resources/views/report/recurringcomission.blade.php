<div class="row">
    <div class="col-11">
                <div class="row">
                    <div class="col-5 ml-4">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Merchants</label>
                                <div class="controls">
                                    <input name="_token" id="tokenRecurring" value="{{ csrf_token() }}" type="hidden">
        
                                    <select name="RCMerchant" class="input-medium m-wrap" tabindex="1">
                                        @foreach($merchants as $merchant)
                                                    <option value="{{$merchant->merchant_id}}">{{$merchant->merchant_company}}</option>
                                        @endforeach
        
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Dispaly</label>
                                <div class="controls">
                                    <select name="RCType" class="input-xlarge m-wrap" tabindex="1">
                                        <option value="Recurring">Recurring Transactions</option>
                                        <option value="approved">Approved Recurring Commission</option>
                                        <option value="pending">Pending Recurring Commission</option>
        
                                    </select>
                                </div>
                            </div>
        
                        </div>

                    </div>

                </div>
                <div class="row ">
                    <div class="col-11 mx-auto">
                  
                        <div id='Recurring'>
                            <center><h2 class='text-dark'>Recurring Transactions</h2></center>
                            <hr>
                           
                            <table  id='RecurringTable' class="table table-striped table-bordered table-hover">
                                <thead class="text-dark">
                                    <tr>
                    
                                        <th class="hidden-phone"> Affiliate</th>
                                        <th class="hidden-phone"> Date </th>
                                        <th class="hidden-phone"> Commission </th>
                                        <th class="hidden-phone"> Order ID </th>
                                        <th class="hidden-phone">Status </th>
                                        <th class="hidden-phone"> Action </th>
                    
                    
                                    </tr>
                                </thead>
                                  <tbody>
                                  </tbody>
                            </table>
                        </div>
                        <div id='approved'>
                            <center><h2 class='text-dark'>Approved Recurring Commission</h2></center>
                            <hr>
                            <table id='approvedTable' class="table table-striped table-bordered table-hover">
                                <thead class="text-dark">
                                    <tr>
                    
                                        <th class="hidden-phone"> Affiliate</th>
                                        <th class="hidden-phone"></i> Date </th>
                                        <th class="hidden-phone"> Commission </th>
                                        <th class="hidden-phone"> Order ID </th>
                    
                                        <th class="hidden-phone"> Action </th>
                    
                    
                                    </tr>
                                </thead>
                                <tbody>
                    
                    
                    
                                </tbody>
                            </table>
                        </div>
                        <div id='pending'>
                            <center><h2 class='text-dark'>Pending Recurring Commission</h2></center>
                            <hr>
                            <table id='pendingTable' class="table table-striped table-bordered table-hover">
                                <thead class="text-dark">
                                    <tr>
                    
                                        <th class="hidden-phone"> Affiliate</th>
                                        <th class="hidden-phone"></i> Date </th>
                                        <th class="hidden-phone"> Commission </th>
                                        <th class="hidden-phone"> Order ID </th>
                    
                                        <th class="hidden-phone"> Action </th>
                    
                    
                                    </tr>
                                </thead>
                                <tbody>
                    
                    
                    
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
           
    </div>
</div>


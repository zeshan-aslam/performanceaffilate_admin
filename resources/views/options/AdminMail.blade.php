<div class="card">
    <div class="card-header text-dark">
        Admin Mail

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-5 col-lg-5">
                <br><br>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Amount Per Mail:</label>
                        <div class="controls">
                            
                            <input type="number" name="adminAmount"><br><br><a class="btn btn-md" onclick="javascript:updateAdminAmount()">Modify Amount</a>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-5 col-lg-5">
                <br><br>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Header:</label>
                        <div class="controls">
                            
                            <textarea name="adminMailHeader" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Footer:</label>
                        <div class="controls">
                       
                            <textarea name="adminMailFooter" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="margin-left:9%;"></label>
                        <div class="controls">
                           
                            <a class="btn  btn-md" onclick="javascript:updateAdminMailOptions()">Modify
                                Option</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
    </div>



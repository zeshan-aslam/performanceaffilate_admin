<div class="card">
    <div class="card-header text-dark">
        Catagories

    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-horizontal">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label text-dark">Add Catagory:</label>
                        <input type="text" name="catName" placeholder="Catagory Name">
                        <a class="btn btn-md" onclick="javascript:insertCatagory() ;">Add</a><br>
                        <span class="help-inline catNameErr text-danger"></span>
                    </div>
                </div>
            
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label text-dark">Remove Catagory:</label>
                        <select name="catName">
                        </select>
                        <button class="btn  btn-md" type="button"
                        onclick='javascript:deleteCatagory();'>Remove</button>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>


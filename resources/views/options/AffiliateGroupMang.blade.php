<h3 style="font-weight: bold">
    »» Affiliate Group Management</h3>
<div class="row-fluid">
    <div class="span12">


        <h4>Add New Affiliate Group</h4>
        <hr>

            <div class="form-horizontal">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Group Title:</label>
                        <input type="hidden" name="id">
                        <input type="text" name="grouptitle">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label">Levels of Commission :</label>
                        <select size="1" class="input-small m-wrap" name="categorylevel" id="select1">
                            <option selected="selected" value="1"> 1 </option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn  btn-md" name="adminAddBtn" onclick="javaecript:insertgroupMang()"
                            type="button">Add</button>
                        <button type="button" name='adminUpdateBtn' class="btn "
                            onclick="javaecript:updateAffgroup()"><i class="icon-check"></i> Update </button>
                        <button type="button" name='adminCancelBtn' class="btn"
                            onclick="javaecript:cancelAdmin()"><i class="icon-remove-sign"></i> Cancel </button>
                    </div>
                </div>
            </div><hr>
      
            <table id='affgrouptable' class=" table table-striped table-hover">
                <thead class="text-dark">
                    <tr>
                        <th>Title</th>
                        <th>Group Level</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Group Level</th>
                        <th>Action</th>


                    </tr>
                </tfoot>
            </table>
    </div>
</div>



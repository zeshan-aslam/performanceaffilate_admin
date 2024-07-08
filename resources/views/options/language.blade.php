<div class="row-fluid">
    <div class="span7" id="right_column">
        <!-- BEGIN GENERAL PORTLET-->
        <div class="card p-4">
            <div class="card-header text-dark">
                <i class=" icon-trophy"></i>
                    Add or Edit languages</h4>
            </div>
            <div class="card-body">
                <div class="row-fluid">
                 <div class='form-horizontal'>
                    <div class="control-group">
                        <label class="control-label">Language</label>
                        <div class="controls">
                            <input type="hidden" name='languages_id'>
                            <input type="text" placeholder="Language Name" class="input-medium" name='languages_name'>
                            <span class="help-inline" id='LanguageError'></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Language Status</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="languages_status" value="active">
                                Active
                            </label>
                            <label class="radio">
                                <input type="radio"  name="languages_status" value="inactive" >
                                Inactive
                            </label>

                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" name='languagesAddBtn' class="btn btn-info" onclick="javaecript:addLanguage()"><i class="icon-plus"></i> Add </button>
                        <button type="button" name='languagesUpdateBtn' class="btn btn-success" onclick="javaecript:updateLanguage()"><i class="icon-check"></i> Update </button>
                        <button type="button" name='languagesCancelBtn' class="btn" onclick="javaecript:cancelLanguage()"><i class="icon-remove-sign"></i> Cancel </button>

                    </div>
                 </div>
                </div>


            </div>
        </div>
    </div>

    <div class="span5">
        <!-- BEGIN ORDERED LISTS PORTLET-->
        <div class="card p-4">
            <div class="card-header text-dark">
                Existing languages
            </div>
            <div class="card-body">
                <table id='languagesTable' class="table table-stripped table-hover ">
                    <tbody>
                    </tbody>

                </table>
                <br><br><br><br><br>
            </div>
        </div>
    </div>

</div>

<table class="tablebdr table-stripe table-border" width="90%">
    <tbody>
        <tr>
            <td style="color: red">
                <p><b>NOTE :</b></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>If you have added or activated a new Language to this system ,
                    Please copy the langage file to lang folders &nbsp;.</p>
            </td>
        </tr>
    </tbody>
</table>

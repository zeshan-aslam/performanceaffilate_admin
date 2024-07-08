<div class="row-fluid">
    <div class="span12">

        <div class="row-fluid">
            <h3 class="text-dark">Add User</h3><hr>
            <div class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">User Name:</label>
                    <div class="controls">
                        <input type="hidden" name="id" required>
                        <input type="text" name="username" required>
                    </div><br>
                    <label class="control-label">Password:</label>
                    <div class="controls">
                        <input type="password" name="password" required>
                    </div><br>
                    <label class="control-label">Email:</label>
                    <div class="controls">
                        <input type="text" name="email" required>
                    </div><br>
                    <label class="control-label">Send Mail to Admin User</label>
                    <div class="controls">
                        <input type="checkbox" name="">
                    </div>
                </div>
            </div>
            <center>
                <button type="button" name='adminAddBtn' class="btn btn-info" onclick="javaecript:insertadmin()"><i
                        class="icon-plus"></i> Add </button>
                <button type="button" name='adminUpdateBtn' class="btn btn-success"
                    onclick="javaecript:updateAdmin()"><i class="icon-check"></i> Update </button>
                <button type="button" name='adminCancelBtn' class="btn" onclick="javaecript:cancelAdmin()"><i
                        class="icon-remove-sign"></i> Cancel </button>

            </center>
            <table id='admintable' class=" table table-striped table-hover table-bordered">
                <thead>
                    <tr>

                        <th>User Name</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Action</th>


                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>

                        <th>User Name</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Action</th>


                    </tr>
                </tfoot>
            </table>
        </div>



    </div>
</div>

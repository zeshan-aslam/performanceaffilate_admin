<!--  -->
@php
$filenameError = public_path('files/error.htm');
$fp = fopen($filenameError, 'r');
$contentsError = fread($fp, filesize($filenameError));
fclose($fp);
@endphp
<div class="card">
    <div class="card-header text-dark">
        Change the Administrator Settings

    </div>
    <div class="card-body ">
        <div class="row ">
            <div class="col-5  mx-auto">
                <div class="form-horizontal">
                    <br><br>
                   
                
                    <div class="control-group">

                        <label class="control-label">Enter Email:</label>
                        <div class="controls">
                            <input type="email" value='{{ Auth::user()->email }}' placeholder="Enter Email"
                                name="userEmail" maxlength="25" class="input-medium">
                              
                            
                            <span class="help-inline userEmailErr text-danger"></span>

                        </div>
                       
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a class="btn btn-success btn-md" onclick='javascript:updateEmail();'>Modify Email</a>
                        </div>
                    </div>
                    <div class="control-group">

                        <label class="control-label">Enter Username:</label>
                        <div class="controls">
                            <input type="text" value='{{ Auth::user()->username }}' placeholder="username"
                                name="userName" maxlength="12" class="input-medium" class="input-medium">
                               
                            
                          <span class="help-inline userNameErr text-danger"></span>

                        </div>
                      
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a class="btn btn-success btn-md" onclick='javascript:updateUserName();'>Modify Login</a>
                        </div>
                    </div>


                </div>

            </div>
            
            <div class="col-5  mx-auto">

                <div class="form-horizontal">
                    <br>

                    <div class="control-group">

                        <label class="control-label">Current Password:</label>
                        <div class="controls">
                            <input type="text" name='userCurrentPassword' value="" placeholder="Current Password"
                                class="input-large" />
                            <span class="help-inline userCurrentPasswordErr text-danger"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">New Password</label>
                        <div class="controls">

                            <input type="password" maxlength="15" name='userPassword' placeholder="New Password"
                                class="input-large" required />
                            <span class="help-inline userPasswordErr text-danger"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Confirm Password</label>
                        <div class="controls">

                            <input type="password" name='userConfirmPassword' placeholder="Confirm Password"
                                class="input-large" maxlength="15" required />
                            <span class="help-inline userConfirmPasswordErr text-danger"
                                id='userConfirmPasswordError'></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">

                            <a type='submit' class="btn btn-success btn-md"
                                onclick='javascript:updateUserPassword();'>Modify Password</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-5  mx-auto">
                <div class="form-horizontal">
                    <br>
                <div class="control-group">
                    <label class="control-label">Site Title</label>
                    <div class="controls">
    
                   
                        <input name='siteTitle' maxlength="20" type="text"
                            value="{{ SiteHelper::getConstant('siteTitle') }}" placeholder="Site Title"
                            class="input-large" />
                        <span class="help-inline siteTitleErr text-danger"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Num of Record Per Page</label>
                    <div class="controls">
                       
                        <input name='siteLines' type="number" value="{{ SiteHelper::getConstant('lines') }}"
                            name='password' placeholder="10" class="input-large" required />
                        <span class="help-inline siteLinesErr text-danger"></span>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                    
                    <a class="btn btn-success" onclick='javascript:updateSiteInfo();'> Modify </a>
    
                </div>
                </div>
            </div>
            </div>
        
            <div class="col-5  mx-auto">
                <div class="form-horizontal">
                    <br>
                    <div class="control-group">
                        <label class="control-label">Set Error Page</label>
                        <div class="controls">
                         
                            <textarea name='siteError' class="input-large" rows="3">{{ $contentsError }}</textarea>
                            <span class="help-inline siteErrorErr text-danger"></span>
                           
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                       
                        <a class="btn btn-success btn-md" onclick='javascript:updateSiteError();'>Error Page Setting</a>
        
                    </div>
                    </div>
                </div>

            </div>

        </div>



    </div>
</div>



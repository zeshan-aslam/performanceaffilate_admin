<div class="row-fluid">
    <div class="span8" id="right_column">
        <!-- BEGIN GENERAL PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4> Email Messages</h4>

            </div>
            <div class="widget-body">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Choose Action:</label>
                                <div class="controls">
                                    <div class="input-prepend">
                                        <select size="1" name="mailSetupEvent"  onload="javascript:getMailSetup();" onchange="javascript:getMailSetup();">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Current Status:</label>
                                <div class="controls">
                                    <div >
                                        Active <input type="radio" value="yes" name="mailSetupStatus">&nbsp;&nbsp;
                                        Inactive <input type="radio"  value="no" name="mailSetupStatus" >
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">From:</label>
                                <div class="controls">
                                    <input type="text" name="mailSetupFrom" class="input-medium">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Subject:</label>
                                <div class="controls">
                                    <input type="text"name="mailSetupSubject" class="input-medium">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                    
                </div>


            </div>
        </div>
        <!-- END GENERAL PORTLET-->

        <!-- BEGIN SAMPLE PORTLET-->
        <div class="widget blue p-2">
            <div class="widget-title">
                <h4> Please Paste HTML code on Header Body and Footer Fields</h4>
            
            </div>
            <div class="widget-body">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Header</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" name="mailSetupHeader" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Body</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" rows="20" name="mailSetupBody"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Footer</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" rows="3" name="mailSetupFooter"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <input type="button" onclick="javascript:updateMailSetup();"class="btn  btn-md" value="Update">
                                </div>
                            </div>
                        </div>
                     

                    </div>
                  
                </div>
             
                <div class="row-fluid">
                    <div class="span12 form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Test Mail</label>
                            <div class="controls">
                                <input type="email" placeholder="Enter Test Mail" name="mailSetupTestTo"> 
                                <button class="btn btn-primary" onclick="javascript:sendSetupTestMail();">Test Mail</button>

                            </div>
                        </div>
                     

                    </div>
                </div>

            </div>

        </div>

        <!-- END SAMPLE PORTLET-->






        <!-- END HORIZONTAL DESCRIPTION LISTS PORTLET-->
    </div>

    <div class="span4">
        <!-- BEGIN ORDERED LISTS PORTLET-->
        <div class="widget blue">
           
            <div class="widget-title">
                <h4> Affiliate Variables</h4>
               
            </div>
            <div class="widget-body">
                <p align="center" valign="top">The variables are included in square brackets and their description is given
                    on the right. Copy the required variable including the square bracket and paste them to get the values
                    in the mail</p>
                <table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%">
                    <tbody>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[aff_firstname]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate
                                First Name</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[aff_lastname]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Last Name</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[aff_company]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate
                                Company Name</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[aff_email]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Affiliate
                                Email</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[aff_password]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Affiliate Password</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[aff_loginlink]</b></td>
                            <td align="left" width="140" height="20" class="gridNew">&nbsp;&nbsp;&nbsp;Affiliate
                                Login Link</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ORDERED LISTS PORTLET-->
        <!-- BEGIN UNORDERED LISTS PORTLET-->

    </div>

    <div class="span4">
        <!-- BEGIN ORDERED LISTS PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4>Merchant Variables</h4>
            
            </div>
            <div class="widget-body">
                <table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%">
                    <tbody>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[mer_firstname]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant
                                First Name</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[mer_lastname]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Merchant Last Name</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[mer_company]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant
                                Company Name</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[mer_email]</b></td>
                            <td align="left" width="140" class="gridNew" height="20">&nbsp;&nbsp;&nbsp;Merchant
                                Email</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[mer_password]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Merchant Password</td>
                        </tr>
                        <tr>
                            <td width="86" class="gridNew" height="20"><b>[mer_loginlink]</b></td>
                            <td align="left" width="140" height="20" class="gridNew">&nbsp;&nbsp;&nbsp;Merchant
                                Login Link</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ORDERED LISTS PORTLET-->
        <!-- BEGIN UNORDERED LISTS PORTLET-->

    </div>

    <div class="span4">
        <!-- BEGIN ORDERED LISTS PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4> Common Variables</h4>

            </div>
            <div class="widget-body">
                <table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%">
                    <tbody>
                        <tr>
                            <td width="86" height="20"><b>[today]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Current Time</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[from]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Admin Email</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[program]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Program Name</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ORDERED LISTS PORTLET-->
        <!-- BEGIN UNORDERED LISTS PORTLET-->

    </div>

    <div class="span4">
        <!-- BEGIN ORDERED LISTS PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4> Transaction Variables</h4>
        
            </div>
            <div class="widget-body">
                <table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%">
                    <tbody>
                        <tr>
                            <td width="86" height="20"><b>[type]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;i.e click, lead, sale</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[commission]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Commission</td>
                        </tr>
                        <tr>
                            <td width="86" height="20"><b>[date]</b></td>
                            <td align="left" width="140" height="20">&nbsp;&nbsp;&nbsp;Date of Transaction</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END ORDERED LISTS PORTLET-->
        <!-- BEGIN UNORDERED LISTS PORTLET-->

    </div>
</div>

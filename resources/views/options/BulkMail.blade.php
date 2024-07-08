            <!--  -->

            <div class="form-horizontal">
                <div class="control-group">
                    <div class="controls">
                        <label class="control-label" style="font-weight: bold; font-size:16px">Select a
                            mailinglist</label>
                        <select size="1" name="toGetMail" onchange="javascript:getMailList();">
                            <option selected="selected" value='a'>All Affiliate</option>
                            <option value='m'>All Merchant</option>
                        </select>
                    </div>
                </div>
                <hr>


                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Receivers:</label>
                            <div class="controls">
                                <div class="input-append">
                                    <h5 style="font-weight:bold" id='numOfMails'></h5>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Receivers</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <select size="6" name="mailList" multiple="multiple" class="selectMailingList">


                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>


            <form class="form-horizontal" action="#">
                <div class="row-fluid ">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label" >From</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input type="text" class=" medium"  name='bulkFrom'>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"> Header</label>
                            <div class="controls">
                                <div class="input-append">
                                    <textarea   cols="30" rows="3"  name='bulkHeader'></textarea>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Subject</label>
                            <div class="controls">
                                <div class="input-prepend">

                                    <input type="text" class=" medium"  name='bulkSubject'>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Footer</label>
                            <div class="controls">
                                <div class="input-prepend">
                                   <textarea cols="30" rows="3"  name='bulkFooter'></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><br>
                <div class="control-group ">
                    <label class="control-label">Body</label>
                    <div class="controls">
                        <textarea class="input-xxlarge" cols="77" rows="8"  name='bulkBody'></textarea>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label"></label>
                    <div class="controls">
                        <input type="button" value="Send" class="btn  btn-sm" onclick="javascript:sendBulkMail();">
                    </div>
                </div>
               
            </form>

      
        
        <div class="row-fluid">
            <div class="span12 form-horizontal">
                <div class="control-group">
                    <label class="control-label">Test Mail</label>
                    <div class="controls">
                        <input type="email" placeholder="Enter Test Mail" name="testMailTo"> 
                        <button class="btn" onclick="javascript:sendTestMail();">Test Mail</button>

                    </div>
                </div>
             

            </div>
        </div>
            <!--  -->

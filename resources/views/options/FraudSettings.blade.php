


                <div class="row-fluid">
                    <div class="card">
                        <div class="card-header text-dark">Fraud Settings</div>
                        <div class="card-body">
                        <table class="table">
                            <thead class="text-dark">
                                <th>Mark</th>
                                <th>Description</th>
                                <th>Seconds</th>
                                <th></th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <tr>
                                <span class="siteFraudClickSecondsErr text-danger"></span><br>
                                <td> <input type="checkbox" name="siteFraudRecentClick"<?php if(SiteHelper::getConstant('siteFraudRecentClick')==1) echo "checked = 'checked'"; ?>/></td>

                                <td><p>Check multiple repeating clicks that came from the same IP Address(same computer) within</p></td>
                                <td>   <input type="number" name="siteFraudClickSeconds"
                                    value="{{ SiteHelper::getConstant('siteFraudClickSeconds') }}"
                                    style="width:40px; "></td>
                                <td>seconds from initial click
                                    What to do with repeating clicks</td>
                                <td>  <select name="siteFraudClickAction">
                                    <option value="do not save" <?php if(SiteHelper::getConstant('siteFraudClickAction')=='do not save') echo "selected = 'selected'"; ?>>do not save</option>
                                    <option value="save as click" <?php if(SiteHelper::getConstant('siteFraudClickAction')=='save as click') echo "selected = 'selected'"; ?>>save as click</option>
                                </select></td>
                            </tr>
                            <tr>
                                <span class="siteFraudSaleSecondsErr text-danger"></span><br>
                                <td>  <input type="checkbox" name="siteFraudRecentSale" <?php if(SiteHelper::getConstant('siteFraudRecentSale')==1) echo "checked = 'checked'"; ?>/></td>

                                <td><p>  Check multiple repeating sales that came from the same IP Address(same computer) within</p></td>
                                <td>    <input type="number" name="siteFraudSaleSeconds"
                                    value="{{ SiteHelper::getConstant('siteFraudSaleSeconds') }}"
                                    style="width:40px; "></td>
                                <td>seconds from initial sale What to do with repeating sales</td>
                                <td>   <select name="siteFraudSaleAction">
                                    <option value="decline" <?php if(SiteHelper::getConstant('siteFraudSaleAction')=='decline') echo "selected = 'selected'"; ?>>decline</option>
                                    <option value="save" <?php if(SiteHelper::getConstant('siteFraudSaleAction')=='save') echo "selected = 'selected'"; ?>>save</option>
                                </select>
                            </td>
                            </tr>

                            <tr>
                                <td ><input type="checkbox" name="siteFraudDeclineRecentSale" <?php if(SiteHelper::getConstant('siteFraudDeclineRecentSale')==1) echo "checked = 'checked'"; ?>/></td>
                                <td colspan="4"> Automatically decline multiple repeating sales that have the same (non-empty) OrderId as the
                                    initial sale</td>
                            </tr>
                            <span class="siteLoginRetryErr text-danger"></span><br>
                            <tr>
                                <td></td>
                                <td >Login Protection Retries</td>
                                <td ><input type="number" name="siteLoginRetry"
                                        value="{{ SiteHelper::getConstant('siteLoginRetry') }}" style="width:40px; ">
                                </td>
                                <td colspan="2" rowspan="2"><b>miniHelp</b><br><p>many times allow to login with incorrect username/password
                                    When anaccount was blocked
                                    beacuse of a few unsuccessful login attempts it will remain blocked for the specified amount of seconds
                                    After specified number of retries, login is blocked  for the user for "Login Protection delay seconds
                                    Default is 3, if it is 0, Login Protection is switched off.</p>
                                </td>
                            </tr>
                            <span class="siteLoginDelayErr text-danger"></span><br>
                            <tr>
                                <td></td>

                                <td >Login Protection delay</td>
                                <td >&nbsp;&nbsp;<input type="number" name="siteLoginDelay"
                                        value="{{ SiteHelper::getConstant('siteLoginDelay') }}" style="width:40px; ">
                                </td>


                            </tr>


                        </tbody>
                        </table>
                        <center>
                            <input type="button" value="Submit" class="btn btn-primary" onclick='javascript:updateFraudSetting();'>
                        </center>



                    </div>
                    </div>





                </div>


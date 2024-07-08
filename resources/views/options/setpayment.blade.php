<div class='row-fluid'>
    <div class='span12'>
        <div class="card  p-3">
            <div class="card-header text-dark">
                Change Subscription Amounts For Merchant

            </div>
            <div class="card-body">
                <form action="#" class='form-horizontal' method='POST'>
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Normal</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <input name='siteNormalUser' placeholder="0" class=" " type="number"
                                    value="{{ SiteHelper::getConstant('siteNormalUser') }}" required />
                                <span class="help-inline siteNormalUserErr text-danger"></span><br><br>
                                <a class="btn  "
                                    onclick="javascript:updatesiteNormalUser('siteNormalUser');">Modify Normal
                                    Amount</a>
                            </div>
                        </div>

                    </div>
                    <div class="control-group">
                        <label class="control-label">Advance</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <input name='siteAdvancedUser' placeholder="0" class=" " type="number"
                                    value="{{ SiteHelper::getConstant('siteAdvancedUser') }}" required />
                                <span class="help-inline siteAdvancedUserErr text-danger"></span><br><br>
                                <a class="btn  "
                                    onclick="javascript:updatesiteAdvancedUser('siteAdvancedUser');">Modify Advance
                                    Amount</a>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Membership Payment Type</label>
                        <div class="controls">
                            <label class="radio">

                                <input type="radio" onclick='showDiv(this)' class='siteMembTypeCLass'
                                    name="siteMembType" value="1" <?php if (SiteHelper::getConstant('siteMembType') == 1) {
    echo "checked='checked'";
} else {
    echo '';
} ?> />
                                One Time
                            </label>
                            <label class="radio">
                                <input type="radio" onclick='showDiv(this)' class='siteMembTypeClass'
                                    name="siteMembType" value="2" <?php if (SiteHelper::getConstant('siteMembType') != 1) {
    echo "checked='checked'";
} else {
    echo '';
} ?> />
                                Recurring
                            </label>



                        </div>
                    </div>


                    <div class="RecurringDiv siteMembType control-group offset1">
                        <label class="control-label"></label>
                        <div class="controls">
                            <label class="control-label">Recuring Period</label>
                            <input type="text" name='siteMembValue' placeholder="Value"
                                value="{{ substr(SiteHelper::getConstant('siteMembValue'), 0, strpos(SiteHelper::getConstant('siteMembValue'), ' ')) }}"
                                class="input-mini" required /><span
                                class="help-inline siteMembValueErr text-danger"></span>
                            <select name='siteMembPeriod' class="input-small m-wrap" tabindex="1">

                                <option value="day(s)" <?php if (strpos(SiteHelper::getConstant('siteMembValue'), 'day')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Day(s)</option>
                                <option value="month(s)" <?php if (strpos(SiteHelper::getConstant('siteMembValue'), 'month')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Month(s)</option>
                                <option value="year(s)" <?php if (strpos(SiteHelper::getConstant('siteMembValue'), 'year')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Year(s)</option>

                            </select>
                        </div>
                    </div>




                    <div class="form-actions">
                        <button type="button" class="btn  "
                            onclick="updatesiteMembType('siteMembType')"><i
                                class="icon-edit"></i>Membership
                            Type</button>

                    </div>

                </form>
            </div>
        </div>

    </div>
</div>


<!--  -->

<div class="card  p-3 mt-2">
    <div class="card-header text-dark">
        Change Minimum Balance

    </div>
    <div class="card-body">
        <div class="form-horizontal">
            <div class="control-group">
                <div class="controls">
                    <label class="control-label">Minimum Amount:</label>
                    <input type="text" placeholder="Enter Min Amount"
                        value="{{ SiteHelper::getConstant('siteMinAmount') }}" name="siteMinAmount">
                    <span class="help-inline siteMinAmountErr text-danger"></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn   btn-md" onclick="javascript:updatesiteMinAmount('siteMinAmount');">Modify
                        Minimum Amount</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!--  -->

<div class='row-fluid'>
    <div class='span12'>
        <div class="card  p-3 mt-2">
            <div class="card-header text-dark">
                Change Program Settings
                <span class="tools">

                </span>
            </div>
            <div class="card-body">
                <form action="#" class='form-horizontal' method='POST'>
                    @csrf
                    <div class="control-group">
                        <label class="control-label">Program Fee</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <span class="add-on">£</span><input name='siteProgramFee' class=" "
                                    type="number" value="{{ SiteHelper::getConstant('siteProgramFee') }}"
                                    required /><span class="add-on">.00</span>
                                <span class="help-inline siteProgramFeeErr text-danger"></span>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Program Type</label>
                        <div class="controls">
                            <label class="radio">

                                <input type="radio" onclick="showDiv(this)" name="siteProgramType" value="1"
                                    <?php if (SiteHelper::getConstant('siteProgramType') == '1') {
                                        echo "checked='checked'";
                                    } else {
                                        echo '';
                                    } ?> />
                                One Time
                            </label>
                            <label class="radio">
                                <input type="radio"  onclick="showDiv(this)" class='onRecurringSelected'
                                    name="siteProgramType" value='2' <?php if (SiteHelper::getConstant('siteProgramType') != '1') {
                                  echo "checked='checked'";
                             } else {
                                  echo '';
                               } ?> />
                                Recurring
                            </label>



                        </div>
                    </div>


                    <div class="RecurringDiv siteProgramType control-group offset1">
                        <label class="control-label"></label>
                        <div class="controls">

                            <input type="text" name='siteProgramValue' placeholder="Value"
                                value="{{ substr(SiteHelper::getConstant('siteProgramValue'),0,strpos(SiteHelper::getConstant('siteProgramValue'), ' ')) }}"
                                class="input-mini" required /><span
                                class="help-inline siteProgramValueErr text-danger"></span>
                            <select name='siteProgramPeriod' class="input-small m-wrap" tabindex="1">

                                <option value="day(s)" <?php if (strpos(SiteHelper::getConstant('siteProgramValue'), 'day(s)')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Day(s)</option>
                                <option value="month(s)" <?php if (strpos(SiteHelper::getConstant('siteProgramValue'), 'month(s)')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Month(s)</option>
                                <option value="year(s)" <?php if (strpos(SiteHelper::getConstant('siteProgramValue'), 'year(s)')) {
    echo "selected='selected'";
} else {
    echo '';
} ?>>Year(s)</option>

                            </select>
                        </div>
                    </div>




                    <div class="form-actions">
                        <button type="button" class="btn  "
                            onclick="javascript:updateProgram('siteProgram');"><i class="icon-edit"></i> Update
                            Program
                            Fee</button>

                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
<!--  -->
<div class='row-fluid'>
    <div class='span12'>
        <div class="card  p-3 mt-2">
            <div class="card-header text-dark">
                Change Transaction Amounts

            </div>
            <div class="card-body">
                @if (count($errors) > 0)
                    <div class="error alert alert-danger">
                        <h3><strong>Errors</strong> </h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="#" class="form-horizontal" method="POST">

                    @csrf
                    <div class="control-group">
                        <label class="control-label">Impression Rate</label>
                        <div class="controls">
                            <div class="input-prepend input-append">
                                <input name='siteImpRate' class=" input-medium" type="number"
                                    value="{{ SiteHelper::getConstant('siteImpRate') }}" required /><span
                                    class="add-on">£</span><br><br>
                                <span class="help-inline siteImpRateErr text-danger"></span>
                                <button type="button" class="btn  "
                                    onclick="javascript:updatesiteImpRate('siteImpRate');">Modify Impression</button>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">


                        <div class='row-fluid'>

                            <div class='span5'>
                                <label class="control-label">Click Rate</label>
                                <div class="controls">
                                    <input name='siteAdminClickRate' type="number"
                                        value="{{ SiteHelper::getConstant('siteAdminClickRate') }}"
                                        class="input-medium" required /><span
                                        class="help-inline siteAdminClickRateErr text-danger"></span> <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteAdminClickRate('siteAdminClickRate');">Modify Click
                                        Amount</button>

                                </div>
                            </div>
                            <div class='span4'>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="siteAdminClickRateType" value="flatrate"
                                            <?php if (SiteHelper::getConstant('siteAdminClickRateType') != 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        £
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="siteAdminClickRateType" value="percentage"
                                            <?php if (SiteHelper::getConstant('siteAdminClickRateType') == 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        %
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="control-group">
                        <div class='row-fluid'>
                            <div class='span5'>
                                <label class="control-label">Lead Rate</label>
                                <div class="controls">
                                    <input name='siteAdminLeadRate' type="number" class="input-medium"
                                        value="{{ SiteHelper::getConstant('siteAdminLeadRate') }}" required />
                                    <span class="help-inline siteAdminLeadRateErr text-danger"></span>
                                    <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteAdminLeadRate('siteAdminLeadRate');">Modify Lead
                                        Amount</button>

                                </div>
                            </div>
                            <div class='span4'>
                                <div class="controls">
                                    <label class="radio">

                                        <input type="radio" name="siteAdminLeadRateType" value="flatrate"
                                            <?php if (SiteHelper::getConstant('siteAdminLeadRateType') != 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        £
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="siteAdminLeadRateType" value="percentage"
                                            <?php if (SiteHelper::getConstant('siteAdminLeadRateType') == 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        %
                                    </label>
                                </div>
                            </div>

                        </div>






                    </div>

                    <div class="control-group">


                        <div class='row-fluid'>

                            <div class='span5'>
                                <label class="control-label">Sale Rate</label>
                                <div class="controls">
                                    <input name='siteAdminSaleRate' type="number" class="input-medium"
                                        value="{{ SiteHelper::getConstant('siteAdminSaleRate') }}" required />
                                    <span class="help-inline siteAdminSaleRateErr text-danger"></span>
                                    <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteAdminSaleRate('siteAdminSaleRate');">Modify Sale
                                        Amount</button>

                                </div>
                            </div>
                            <div class='span4'>
                                <div class="controls">
                                    <label class="radio">

                                        <input type="radio" name="siteAdminSaleRateType" value="flatrate"
                                            <?php if (SiteHelper::getConstant('siteAdminSaleRateType') != 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        £
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="siteAdminSaleRateType" value="percentage"
                                            <?php if (SiteHelper::getConstant('siteAdminSaleRateType') == 'percentage') {
                                                echo "checked='checked'";
                                            } else {
                                                echo '';
                                            } ?> />
                                        %
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
<!--  -->

<!--  -->
<div class="card  p-3 mt-2">
    <div class="card-header text-dark">
        Change Minimum Withdraw Amount Of Affiliates

    </div>
    <div class="card-body">


        <div class="form-horizontal">
            <div class="control-group">
                <div class="controls">
                    <label class="control-label">Minimum Withdraw Amount:</label>
                    <input type="number" placeholder="Min Withdraw Amount" name='siteMinWithdrawAmount'
                        value="{{ SiteHelper::getConstant('siteMinWithdrawAmount') }}"><span
                        class="help-inline siteMinWithdrawAmountErr text-danger"></span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn   btn-md" type="button"
                        onclick="javascript:updatesiteMinWithdrawAmount('siteMinWithdrawAmount');">Modify Withdraw
                        Amount</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--  -->

<!--  -->
<div class='row-fluid'>
    <div class='span12'>
        <div class="card  p-3 mt-2">
            <div class="card-header text-dark">
                Change Transaction Amounts

            </div>
            <div class="card-body">
                <form class="form-horizontal">



                    <div class="control-group">


                        <div class='row-fluid'>

                            <div class='span5'>
                                <label class="control-label">For Merchant</label>
                                <div class="controls">
                                    <input name='siteMerchantMaxAmount' type="number"
                                        value="{{ SiteHelper::getConstant('siteMerchantMaxAmount') }}" max="1000000"
                                        onkeydown="javascript:(this.value>100000)?$('.siteMerchantMaxAmountErr').html('Exceeding Max Value'):$('.siteMerchantMaxAmountErr').html('');"
                                        class="input-medium" required /><span
                                        class="help-inline siteMerchantMaxAmountErr text-danger"></span> <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteMerchantMaxAmount('siteMerchantMaxAmount');">Modify
                                        Merchant </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">


                        <div class='row-fluid'>

                            <div class='span5'>
                                <label class="control-label">For Affiliate</label>
                                <div class="controls">
                                    <input name='siteAffiliateMaxAmount' type="number" max="1000000"
                                        onkeydown="javascript:(this.value>100000)?$('.siteAffiliateMaxAmountErr').html('Exceeding Max Value'):$('.siteAffiliateMaxAmountErr').html('');"
                                        value="{{ SiteHelper::getConstant('siteAffiliateMaxAmount') }}"
                                        class="input-medium" required /><span
                                        class="help-inline siteAffiliateMaxAmountErr text-danger"></span> <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteAffiliateMaxAmount('siteAffiliateMaxAmount');">Modify
                                        Affiliate</button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">


                        <div class='row-fluid'>

                            <div class='span5'>
                                <label class="control-label">For Admin</label>
                                <div class="controls">
                                    <input name='siteAdminMaxAmount' type="number" max="100000"
                                        onkeydown="javascript:(this.value>100000)?$('.siteAdminMaxAmountErr').html('Exceeding Max Value'):$('.siteAdminMaxAmountErr').html('');"
                                        value="{{ SiteHelper::getConstant('siteAdminMaxAmount') }}"
                                        class="input-medium" required /><span
                                        class="help-inline siteAdminMaxAmountErr text-danger"></span> <br><br>
                                    <button type="button" class="btn  "
                                        onclick="javascript:updatesiteAdminMaxAmount('siteAdminMaxAmount');">Modify
                                        Admin</button>

                                </div>
                            </div>
                        </div>
                    </div>









                </form>
            </div>
        </div>

    </div>
</div>

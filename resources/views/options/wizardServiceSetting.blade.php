<div class="row-fluid">
    <div class="span8" id="right_column">
        <!-- BEGIN GENERAL PORTLET-->
        <div class="widget blue">
            <div class="widget-title">
                <h4>Wizard Account's Include Services</h4>

            </div>
            <div class="widget-body">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Choose Account Type:</label>
                                <div class="controls">
                                    <div class="input-prepend">
                                        <select size="1" name="availableAccountType"
                                            onload="javascript:getAccountType();"
                                            onchange="javascript:getAccountType();">
                                            <option value="0" selected="selected">Select Account</option>

                                            @foreach ($columnData as $serviceData)
                                                <option value="{{ $serviceData }}">
                                                    {{ $serviceData }}</option>
                                            @endforeach
                                            {{-- <option value="managed">Managed</option> --}}


                                        </select>
                                    </div>
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
                <h4> Please Enter Text in Header Body and Footer Fields</h4>
            </div>
            <div class="widget-body">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="form-horizontal">
                            <!-- <div class="control-group">
                                <label class="control-label">Header</label>
                                <div class="controls">
                                    <textarea id="demo" name="demo" class="input-xlarge" name="Header" rows="3"></textarea>

                                    <textarea id="wizardContentHeader" name="wizardContentHeader" class="input-xlarge" name="Header" rows="3"></textarea>
                                </div>
                            </div> -->
                            <div class="control-group">
                                <label class="control-label">Body</label>
                                <div class="controls">
                                    <textarea id="wizardContentBody" name="wizardContentBody" class="input-xlarge" rows="20" name="Body"></textarea>
                                </div>
                            </div>
                            <!-- <div class="control-group">
                                <label class="control-label">Footer</label>
                                <div class="controls">
                                    <textarea id="wizardContentFooter" name="wizardContentFooter" class="input-xlarge" rows="3" name="Footer"></textarea>
                                </div>
                            </div> -->
                            <div class="form-actions">
                                <label class="control-label"></label>
                                <div class="controls">
                                    <input type="button" onclick="javascript:updateWizardServiceContent();"
                                        class="btn  btn-md" value="Update">
                                </div>
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
                <h4>Add New Account Type</h4>

            </div>
            <div class="widget-body">
                <select name="wizardAccountType" id="wizardAccountType" placeholder="Enter Account Type">
                    <option value="">Select Account</option>
                    <option value="entryLevel">Entry Level</option>
                    <option value="managed">Managed</option>
                </select>
                <!-- <input type="text" name="WizardAccountType" id="WizardAccountType" placeholder="Enter Account Type"> -->
                <button class="btn btn-sm btn-primary" onclick="javascript:addNewAccount();">Save</button>
            </div>
        </div>
        <!-- END ORDERED LISTS PORTLET-->
        <!-- BEGIN UNORDERED LISTS PORTLET-->

    </div>
</div>

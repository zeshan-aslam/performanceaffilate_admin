<div class="card p-4">

    <div class="card-body">


        <div class="row-fluid">
            <div class="span6" id="right_column">


                <h4 class="text-dark">Existing Currencies</h4>
                <hr>


                <div class="row-fluid">
                    <h5 id='baseCurrency'></h5>
                    <table id='currencyTable' class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Relation</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>


                <div class="row-fluid">
                    <h4 class="text-dark">
                        Add New Currency</h4>
                        <hr>
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Currency Caption<span class="colorred"> *</span></label>
                            <div class="controls">
                                <input type="text" name="curCode" maxlength="12">
                            </div><br>
                            <label class="control-label">Currency Code<span class="colorred"> *</span></label>
                            <div class="controls">
                                <input type="text" name="curCaption" maxlength="5">
                            </div><br>
                            <label class="control-label">Currency Symbol<span class="colorred"> *</span></label>
                            <div class="controls">
                                <input type="text" name='curSymbol' maxlength="5">
                            </div><br>
                            <label class="control-label">Currency Relation<span class="colorred">
                                    *</span></label>
                            <div class="controls">
                                <input type="number" name='curRelation' maxlength="10">
                            </div><br>
                            <div class="controls">
                                <input type="button" class="btn " value="Add"
                                    onclick="javascript:addCurrency()">
                            </div>
                        </div>
                    </div>
                    <center>

                    </center>
                </div>
            </div>

            <div class="span6">

                <h4 class="text-dark">Set New Currency Relation</h4> <hr>

                <div class="row-fluid">
                    <strong class="colorred">All the * fields are mandatory</strong><br><br>
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Currency<span class="colorred"> *</span></label>
                            <div class="controls">
                                <select name='selectCurrency' class="selectCurrency input-small m-wrap" tabindex="1">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Set Relation<span class="colorred">
                                    *</span><span id="relCurrency"></span></label>
                            <div class="controls">
                                <input type="number" name="relation_value">
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="control-group" align="center">
                            <input type="button" value="Submit" onclick="javascript:updateCurrencyValue();"
                                class="btn btn-secondary btn-sm">
                            <input type="button" value="Reset" onclick="javascript:resetCurrency();"
                                class="btn  btn-sm">
                        </div>
                    </div>
                </div>
                 <!-- <div class="row-fluid">
                    <h4 class="text-dark">
                        Base Currency</h4> <hr>
                    <div class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Select Base Currency</label>
                            <div class="controls">
                                <select name='selectCurrencyBase' class="selectCurrency input-small m-wrap"
                                    tabindex="1">

                                </select>
                            </div>
                        </div>
                    </div>
                    <center>
                        <input type="button" value="Change" onclick='javascript:changeCurrency();'
                            class="btn btn-sm">
                    </center>
                </div> -->

            </div>
            <!-- <div class="row-fluid">
                <div class="span12">
                    <p><b>
                            <font size="2" color="#0000FF">Get Currency Rates From XE.com</font>
                        </b>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="chk_currency" onclick="ChangeRateSystem('rate')">
                    </p>
                </div>
            </div> -->

        </div>
    </div>
</div>





<style>
    .colorred {
        color: red;
    }

</style>

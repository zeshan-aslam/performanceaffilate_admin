<div class="row-fluid">

    <div class="span12">

        <div class="row-fluid">
            <div class="span6">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">From </label>
                        <div class="controls">
                            <input name="_token" id="tokenForPeriod" value="{{ csrf_token() }}" type="hidden">

                            <input type="date" name="forPeriodFrom" class="input-medium" />

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">To</label>
                        <div class="controls">
                            <input type="date" name="forPeriodTo" class="input-medium " />

                        </div>
                    </div>
                </div>

            </div>
            <div class="span6">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Select Merchant</label>
                        <div class="controls">
                            <select name="forPeriodMerchant" class="input-medium m-wrap" tabindex="1">

                                <option value="All">All</option>
                                @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->merchant_id }}">{{ $merchant->merchant_company }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Select Affiliate</label>
                        <div class="controls">
                            <select name="forPeriodAffiliate" class="input-medium m-wrap" tabindex="1">
                                <option value="All">All</option>
                                @foreach ($affiliates as $affiliate)
                                    <option value="{{ $affiliate->affiliate_id }}">{{ $affiliate->affiliate_company }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>



                </div>

            </div>

        </div>
        <div class="row-fluid">
            <div class="span12">

                <br><br>
                <center>
                    <div class="control-group">
                        <a name="getForPeriod" class=" btn  btn-success"
                            onclick="getForPeriod(event.target)"> View <i class="icon-circle-arrow-down"></i></a>
                    </div>
                </center>

            </div>
        </div>
        <div class="row-fluid">
            
            <div class="span12">
                <div class="clearfix">


                </div>
                <div class="space15"></div>
                <table class="table table-striped table-bordered table-advance table-hover">
                    <thead class="text-dark">
                        <tr>
                            <th class="hidden-phone"> Transactions </th>
                            <th class="hidden-phone"></i> Number </th>
                            <th class="hidden-phone"> Commissions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="label label-warning label-mini">Impressions</span></td>
                            <td class="hidden-phone" id='forPeriodnImpression'></td>

                            <td class="hidden-phone" id='forPeriodimpressionCommission'></td>
                        </tr>
                        <tr>
                            <td><span class="label label-success label-mini">Clicks</span></td>
                            <td class="hidden-phone" id='forPeriodnClick'></td>

                            <td class="hidden-phone" id='forPeriodclickCommission'></td>
                        </tr>
                        <tr>
                            <td><span class="label label-important label-mini">Leads</span></td>
                            <td class="hidden-phone" id='forPeriodnLead'></td>

                            <td class="hidden-phone" id='forPeriodleadCommission'></td>
                        </tr>
                        <tr>
                            <td><span class="label label-info label-mini">Sale</span></td>
                            <td class="hidden-phone" id='forPeriodnSale'></td>

                            <td class="hidden-phone" id='forPeriodsaleCommission'></td>
                        </tr>

                    </tbody>
                </table>
                <dl class="dl-horizontal">
                    <dt>Raw Impressions</dt>
                    <dd id='forPeriodImpressions'></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Pending Amount</dt>
                    <dd id='forPeriodPending'></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Reversed Amount</dt>
                    <dd id='forPeriodReversed'></dd>
                </dl>



            </div>

        </div>



    </div>
</div>

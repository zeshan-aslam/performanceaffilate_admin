
<div class='row-fluid'>
    <div class='span4'>
        <div class="form-horizontal">
            <input name="_token" id="tokenGraphs" value="{{ csrf_token() }}" type="hidden">


            <div class="control-group">
                <label class="control-label">Select Merchant</label>
                <div class="controls">
                    <select name="MerchantGraphs" class="input-medium m-wrap" tabindex="1" name="merchant">
                        <option value="0">Select Merchant</option>
                        @foreach($merchants as $merchant)
                        <option value="{{$merchant->merchant_id}}">{{$merchant->merchant_company}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div id='AffiliateGraphsControlGroup' class="control-group">
                <label class="control-label">Select Affiliate</label>
                <div class="controls">
                    <select name="AffiliateGraphs" class="input-medium m-wrap" tabindex="1" name="affiliate">
                        
                    </select>
                </div>
            </div>




        </div>

    </div>
    <div class='span3'></div>
    <div class='span6 Chart_box'>
        <canvas id="Chart" width="100px" height="100px"></canvas>
    </div>
</div>




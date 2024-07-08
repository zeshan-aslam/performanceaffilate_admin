<div class='span8'>
                     <form class="form-horizontal">
                     <div class="control-group">
                                    <label class="control-label">Merchant</label>
                                    <div class="controls">
                                    <select name="MerchantDaily" class="input-medium m-wrap" tabindex="1" name="merchant">
                                            <option value="All">All</option>
                                            @foreach($merchants as $merchant)
                                            <option value="{{$merchant->merchant_id}}">{{$merchant->merchant_company}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                        <div class="control-group">
                                    <label class="control-label">Affiliate</label>
                                    <div class="controls">
                                    <select name="AffiliateDaily" class="input-medium m-wrap" tabindex="1" name="affiliate">
                                            <option value="All">All</option>
                                            @foreach($affiliates as $affiliate)
                                            <option value="{{$affiliate->affiliate_id}}">{{$affiliate->affiliate_company}}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                        <div class="form-actions">
                        <a name="getDailyData" class=" btn btn-success" onclick="getDaily(event.target)"> View <i class="icon-circle-arrow-down"></i></a>

                        </div>
                     </form>
                     <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                           <tr>
                              <th class="hidden-phone"> Transactions </th>
                              <th class="hidden-phone"></i> Number </th>
                              <th class="hidden-phone"> Commissions</th>

                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><span class="label label-warning label-mini">Impressions</span></td>
                              <td class="hidden-phone" id='nImpression'></td>

                              <td class="hidden-phone" id='impressionCommission'></td>
                           </tr>
                           <tr>
                              <td><span class="label label-success label-mini">Clicks</span></td>
                              <td class="hidden-phone" id='nClick'></td>

                              <td class="hidden-phone" id='clickCommission'></td>
                           </tr>
                           <tr>
                              <td><span class="label label-important label-mini">Leads</span></td>
                              <td class="hidden-phone" id='nLead'></td>

                              <td class="hidden-phone" id='leadCommission'></td>
                           </tr>
                           <tr>
                              <td><span class="label label-info label-mini">Sale</span></td>
                              <td class="hidden-phone" id='nSale'></td>

                              <td class="hidden-phone" id='saleCommission'></td>
                           </tr>

                        </tbody>
                     </table>
                     <dl class="dl-horizontal">
                        <dt>Raw Clicks</dt>
                        <dd id='rawClicks'></dd>
                     </dl>
                     <dl class="dl-horizontal">
                        <dt>Raw Impressions</dt>
                        <dd id='rawImpressions'></dd>
                     </dl>
                  </div>
                  <div class="span3">
                  <input name="_token" id="tokenDaily" value="{{ csrf_token() }}" type="hidden">
                  <div id="color-calendar"></div>



                  </div>

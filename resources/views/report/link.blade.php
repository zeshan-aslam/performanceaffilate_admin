<div class="row">
    <div class="col-12 mx-auto">
                <div class="row mx-auto">
                    <div class="col-2">
                        <div class="form">
                            <div class="control-group">
                                <label class="control-label">From </label>
                                <div class="controls">
                                    <input name="FromLink" type="date" placeholder=".input-medium"
                                        class="input-medium" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">To</label>
                                <div class="controls">
                                    <input name="ToLink" type="date" placeholder=".input-medium"
                                        class="input-medium" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="control-group">
                                <label class="control-label">Select Program</label>
                                <div class="controls">
                                    <select class="input-medium m-wrap" tabindex="1" name="ProgramLink">
                                        <option value="All">All</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->program_id }}">{{ $program->program_url }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Select Merchant</label>
                                <div class="controls">
                                    <select class="input-medium m-wrap" tabindex="1" name="MerchantLink">
                                        <option value="All">All</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->merchant_id }}">
                                                {{ $merchant->merchant_company }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                               
                                <div class="controls">
                                    <a name="getLinkData" class="input-small  btn  btn-success"
                                    onclick="getLink(event.target)"> View <i class="icon-circle-arrow-down"></i></a>
                                </div>
                            </div>
                            



                        </div>

                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-8 mx-auto ">
                                <table class="table table-bordered table-hover">
                                    <thead class="text-dark">
                                        <tr>
                                            <td class="hidden-phone" id="clickView">
                                                <a name='ClickToView' href="javascript:;" onclick="ViewModal()"
                                                    id="banner" style="display: none;" value=''>Click Here to View
                                                    Bannner</a>
                                                <a name='ClickToView' href="javascript:;" onclick="viewModal()"
                                                    id="clickViewData" style="display: none;" href='#'>Click Here to
                                                    View
                                                    Text</a>
                                                <a name='ClickToView' href="javascript:;" onclick="viewModal()"
                                                    id="clickViewData" style="display: none;" href='#'>Click Here to
                                                    View
                                                    Html</a>
                                                <a name='ClickToView' href="javascript:;" onclick="viewModal()"
                                                    id="clickViewData" style="display: none;" href='#'>Click Here to
                                                    View Pop
                                                    Up</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="hidden-phone"> Transactions </th>
                                            <th class="hidden-phone"></i> Number </th>
                                            <th class="hidden-phone"> Commissions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="label label-warning label-mini">Impressions</span></td>
                                            <td class="hidden-phone" id='nImpressionLink'></td>

                                            <td class="hidden-phone" id='impressionCommissionLink'></td>
                                        </tr>
                                        <tr>
                                            <td><span class="label label-success label-mini">Clicks</span></td>
                                            <td class="hidden-phone" id='nClickLink'></td>

                                            <td class="hidden-phone" id='clickCommissionLink'></td>
                                        </tr>
                                        <tr>
                                            <td><span class="label label-important label-mini">Leads</span></td>
                                            <td class="hidden-phone" id='nLeadLink'></td>

                                            <td class="hidden-phone" id='leadCommissionLink'></td>
                                        </tr>
                                        <tr>
                                            <td><span class="label label-info label-mini">Sale</span></td>
                                            <td class="hidden-phone" id='nSaleLink'></td>

                                            <td class="hidden-phone" id='saleCommissionLink'></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 mx-auto">
                                <dl class="dl-horizontal">
                                    <dt>Pending </dt>
                                    <dd id='pendingLink'></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Reversed </dt>
                                    <dd id='reversedLink'></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Impressions </dt>
                                    <dd id='impressionLink'></dd>
                                </dl>
                                <div class="pagination pagination-small pagination-centered custom_pagination">
                                    <ul>
                                        <li><a href="#">«</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">»</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>





                </div>


           
    </div>
</div>

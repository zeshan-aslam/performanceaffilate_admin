<div class="row-fluid">

    <div class="span12">
                  <input name="_token" id="productsToken" value="{{ csrf_token() }}" type="hidden">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">From </label>
                                    <div class="controls">
                                        <input name="productsFrom" type="date"  class="input-medium" />

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">To</label>
                                    <div class="controls">
                                        <input name="productsTo" type="date"  class="input-medium" />

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="span6">
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">Select Program</label>
                                    <div class="controls">
                                        <select class="input-medium m-wrap" tabindex="1" name="productsProgram">
                                            <option value="All">All</option>
                                            @foreach( $programs as  $program)
                                            <option value="{{$program->program_id}}">{{$program->program_url}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Select Merchant</label>
                                    <div class="controls">
                                        <select class="input-medium m-wrap" tabindex="1" name="productsMerchant">
                                           
                                            @foreach($merchants as $merchant)
                                            <option value="{{$merchant->merchant_id}}">{{$merchant->merchant_firstname ." " . $merchant->merchant_lastname }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>
                    <div class='row-fluid'>
                        <div class='span12'>
                            <center>

                                <div class="control-group">

                                    <div class="controls">
                                       <label class="checkbox">
                                            <input name="productsSale" type="checkbox" value="sale" /> Sale
                                        </label>
                                        <label class="checkbox">
                                            <input name="productsLead" type="checkbox" value="lead" /> Lead
                                        </label>
                                        <label class="checkbox">
                                            <input name="productsClick" type="checkbox" value="click" /> Click
                                        </label>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                    <br><br>
                    <div class="row-fluid">
                        <div class="span12">

                            <center>
                                <div class="control-group">
                                    <a name="getProductsData" class="input-sm  btn  btn-success" onclick="getProducts(event.target)"> View <i class="icon-circle-arrow-down"></i></a>

                                </div>
                            </center>

                        </div>
                    </div>


        <!-- END GRID SAMPLE PORTLET-->
    </div>

</div>


<div class="row-fluid">
    <div class="span12">
        <hr>

        <table id='productsTable' class="table table-striped table-bordered table-advance table-hover">
            <thead class="text-dark">
                <tr>
                    <th class="hidden-phone"> #</th>
                    <th class="hidden-phone"> Type</th>
                    <th class="hidden-phone"> Product </th>
                    <th class="hidden-phone">Affiliate</th>
                    <th class="hidden-phone"> Commission </th>
                    <th class="hidden-phone"> Date</th>
                    <th class="hidden-phone"> Status</th>
                </tr>
                </thead>
            <tbody>

            </tbody>
        </table>

    </div>

</div>

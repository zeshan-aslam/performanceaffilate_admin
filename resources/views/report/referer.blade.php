<?php

$joinId = [];
$j = 0;
foreach ($data as $row) {
    $j++;
    $joinId[$j] = $row->joinpgm_id;
}
?>

<div class="row">
    <div class="col-11">
           <div class="row">
                    <div class="col-5">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">From </label>
                                <div class="controls">
                                    <input name="refererFrom" type="date" placeholder=".input-medium"
                                        class="input-medium" />

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">To</label>
                                <div class="controls">
                                    <input name="refererTo" type="date" placeholder=".input-medium"
                                        class="input-medium" />

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Select Merchant</label>
                                <div class="controls">
                                    <select name="refererMerchant" class="input-medium m-wrap" tabindex="1"
                                        name="refererMerchant">
                                        <option value="All">All</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->merchant_id }}">
                                                {{ $merchant->merchant_company }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Select Program</label>
                                <div class="controls">
                                    <select name="refererProgram" class="input-medium m-wrap" tabindex="1"
                                        name="refererProgram">
                                        <option value="All">All</option>
                                        @foreach ($programs as $program)
                                            <option value="{{ $program->program_id }}">{{ $program->program_url }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-11">
                        <center>
                            <div class="control-group">
                                <!-- <label class="control-label">Type </label> -->
                                <div class="controls">
                                    <label class="checkbox">
                                        <input name="refererImpression" type="checkbox" value="impression" />Impression
                                    </label>
                                    <label class="checkbox">
                                        <input name="refererSale" type="checkbox" value="sale" /> Sale
                                    </label>
                                    <label class="checkbox">
                                        <input name="refererLead" type="checkbox" value="lead" /> Lead
                                    </label>
                                    <label class="checkbox">
                                        <input name="refererClick" type="checkbox" value="click" /> Click
                                    </label>
                                </div>
                            </div>
                        </center>
                        <br><br>
                        <center>
                            <div class="control-group">
                                <a name="getData" class="input-sm btn  btn-success"
                                    onclick="getReferer(event.target)"> View <i class="icon-circle-arrow-down"></i></a>

                            </div>
                        </center>
                    </div>
                </div>
          
                <hr>
                <table id='refererTable' class="table table-striped table-bordered table-hover">
                    <thead class="text-dark">
                        <tr>

                            <th class="hidden-phone"> Type</th>
                            <th class="hidden-phone">Affiliate</th>
                            <th class="hidden-phone"> HTTP_REFERER </th>
                            <th class="hidden-phone"> IP</th>
                            <th class="hidden-phone"> Date</th>
                            <th class="hidden-phone"> Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

         

    </div>
</div>
